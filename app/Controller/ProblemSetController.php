<?php

class ProblemSetController extends AppController {

    public $uses = array('ProblemSet','Assignment','User','Classroom','AssignmentScore','Course');

    public function index(){

    }

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') == 'teacher'){
            $this->layout = 'teacher';
            $this->Auth->allow('del','edit','view','assign','setready','cancel','cancellall');
        }else{
            $this->Session->setFlash("You have no permission here","flash_notification");
            $this->redirect(array(
                'controller' => 'Home',
                'action' => 'index'
            ));
        }
    }

    public function isAuthorized($user) {

        if($this->Auth->user('role') == 'teacher'){
            return true ;
        }
        parent::isAuthorized($user);
        // Admin can access every action
        //return true ;

        // Default deny
        //return false;
    }

    public function del($problemset_id){
        $redirect = $this->referer();
        $problemData = $this->ProblemSet->findAllByProblemsetId($problemset_id);


        //////////////////////Check Problem Set is released , isn't it?/////////////////
        $assigned = false;
        foreach ($problemData[0]['Assignment'] as $assignment){
            if($assignment['status'] == 'released'){
                $assigned = true;
            }
        }

        if((!$assigned)){ //if Problem Set isn't released
            $this->ProblemSet->delete($problemset_id,true);
            $this->Assignment->deleteAll(array('Assignment.problemset_id' => $problemset_id));
            $this->Session->setFlash(__('The problem set has been deleted'),'flash_complete');
            $this->redirect($redirect);
        }else{
            $this->Session->setFlash(__('The problem set could not be deleted, because state is released'),'flash_notification');
            $this->redirect($redirect);
        }
    }

    public function edit($problemset_id){
        $redirect = array(
            'controller' => 'problem_set',
            'action'     => 'view',
            $problemset_id
        );
        $problemData = $this->ProblemSet->findAllByProblemsetId($problemset_id);


        //////////////////////Check Problem Set is released , isn't it?/////////////////
        $assigned = false;
        foreach ($problemData[0]['Assignment'] as $assignment){
            if($assignment['status'] == 'released'){
                $assigned = true;
            }
        }
        $this->set('assigned',$assigned);

        $this->set('data',$problemData);
        $this->set('user_id',$this->Auth->user('id'));

        $this->ProblemSet->id = $problemset_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ProblemSet->save($this->request->data)) {
                $this->Session->setFlash(__('The problem set has been saved'),'flash_complete');
                $this->redirect($redirect);
            } else {
                $this->Session->setFlash(__('The problem set could not be saved. Please, try again.'),'flash_notification');
                $this->redirect($redirect);
            }
        }
    }

    public function view($psid)
    {
        //problem set id => psid
        $ps = $this->ProblemSet->findByProblemsetId($psid); //Still Sample ID
        $this->set('ps',$ps);
        $assignments = $this->Assignment->findAllByProblemsetId($psid); //Still Sample ID
        $course_list = $this->Course->find('list');
        $this->set('course_list',$course_list);
        $this->set('assignments',$assignments);
    }

    public function assign($psid)
    {
        //get teacher's school id
        $schoolid = $this->Auth->user('school_id');

        //find all classroom in this school
        $classrooms = $this->ProblemSet->Teacher->Classroom->find('list',array(
            'conditions' => array('Classroom.school_id' => $schoolid)
        ));


        $checks = $this->Assignment->find('list',array(
            'fields' => array('Assignment.classroom_id','Assignment.problemset_id'),
            'conditions' => array(/*'Assignment.school_id' => $schoolid,/**/
                'Assignment.problemset_id' => &$psid)
        ));



        $classrooms = array_diff($classrooms,array_intersect_key($classrooms,$checks));
        $this->set('classrooms',$classrooms);
        //debug($classrooms);
        //Assign Action

        if($classrooms == array()){
            $this->Session->setFlash("There is no class for assigning","flash_notification");
            $this->redirect(array(
                'controller' => 'problem_set',
                'action' => 'view',
                $psid
            ));
        }
        if ($this->request->is('post'))
        {
            $this->Assignment->set('problemset_id',$psid);
            $this->Assignment->set('school_id',$schoolid);
            $this->Assignment->set('status','assigned');
            //$this->Assignment->set('classroom_id',$this->request->data('classroom'));
            $this->Assignment->save($this->request->data);
            $this->redirect(array(
                'controller' => 'problem_set',
                'action' => 'view',
                $psid
            ));
        }
    }

    public function setready($psid)
    {
        $ps= $this->ProblemSet->findByProblemsetId($psid);
        $this->ProblemSet->id = $ps['ProblemSet']['problemset_id'];
        $this->ProblemSet->set('ready',!$ps['ProblemSet']['ready']);
        $this->ProblemSet->save();
        $this->redirect(array(
            'controller' => 'problem_set',
            'action' => 'view',
            $psid
        ));
    }

    public function cancel($assignid,$psid)
    {
        $this->Assignment->delete($assignid);
        $this->redirect(array(
            'controller' => 'problem_set',
            'action' => 'view',
            $psid
        ));
    }

    public function cancelall($psid)
    {
        $this->Assignment->deleteAll(array('Assignment.problemset_id'=>$psid));
        $this->redirect(array(
            'controller' => 'problem_set',
            'action' => 'view',
            $psid
        ));
    }

    public function class_highest_score($classroom_id,$problemset_id){
        $assignment = $this->Assignment->findByClassroomIdAndProblemsetId($classroom_id,$problemset_id);
        $grade = $assignment['Classroom']['grade'];
        $room = $assignment['Classroom']['room'];
        $assignment_id = $assignment['Assignment']['id'];
        $problemset_name = $assignment['ProblemSet']['problemset_name'];

        $result = $this->User->AssignmentScore->find('all', array(
            'conditions' => array('AssignmentScore.student_id '.
                'IN'.
                ' (SELECT Student.id FROM user AS Student WHERE Student.classroom_id='.$classroom_id.
                ' AND Student.role="student")',
                'AssignmentScore.assignment_id' => $assignment_id),
            'fields' => array('AssignmentScore.score',
                'AssignmentScore.student_id',
                'User.*'),
            'recursive' => 1,
            'limit' => 3,
            'order' => array('AssignmentScore.score' => 'desc'),
        ));

        $this->set('result',$result);
        $this->set('problemset_name',$problemset_name);
        $this->set('grade',$grade);
        $this->set('room',$room);
    }

    public function get_class_highest_score($classroom_id,$problemset_id){
        $assignment = $this->Assignment->findByClassroomIdAndProblemsetId($classroom_id,$problemset_id);
        $grade = $assignment['Classroom']['grade'];
        $room = $assignment['Classroom']['room'];
        $assignment_id = $assignment['Assignment']['id'];
        $problemset_name = $assignment['ProblemSet']['problemset_name'];

        $result = $this->User->AssignmentScore->find('all', array(
            'conditions' => array('AssignmentScore.student_id '.
                'IN'.
                ' (SELECT Student.id FROM user AS Student WHERE Student.classroom_id='.$classroom_id.
                ' AND Student.role="student")',
                'AssignmentScore.assignment_id' => $assignment_id),
            'fields' => array('AssignmentScore.score',
                'AssignmentScore.student_id',
                'User.*'),
            'recursive' => 1,
            'limit' => 3,
            'order' => array('AssignmentScore.score' => 'desc'),
        ));

        return $result;
            //$this->set('result',$result);
        //$this->set('problemset_name',$problemset_name);
        //$this->set('grade',$grade);
        //$this->set('room',$room);
    }


    public function class_lowest_score($classroom_id,$problemset_id){
        $assignment = $this->Assignment->findByClassroomIdAndProblemsetId($classroom_id,$problemset_id);
        $grade = $assignment['Classroom']['grade'];
        $room = $assignment['Classroom']['room'];
        $assignment_id = $assignment['Assignment']['id'];
        $problemset_name = $assignment['ProblemSet']['problemset_name'];

        $result = $this->User->AssignmentScore->find('all', array(
            'conditions' => array('AssignmentScore.student_id '.
                'IN'.
                ' (SELECT Student.id FROM user AS Student WHERE Student.classroom_id='.$classroom_id.
                ' AND Student.role="student")',
                'AssignmentScore.assignment_id' => $assignment_id),
            'fields' => array('AssignmentScore.score',
                'AssignmentScore.student_id',
                'User.*'),
            'recursive' => 1,
            'limit' => 3,
            'order' => array('AssignmentScore.score' => 'asc'),
        ));

        $this->set('result',$result);
        $this->set('problemset_name',$problemset_name);
        $this->set('grade',$grade);
        $this->set('room',$room);
    }


    public function course_highest_score($course_id,$problemset_id){
        $problemset = $this->ProblemSet->findByProblemsetId($problemset_id);
        $problemset_name = $problemset['ProblemSet']['problemset_name'];
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AssignmentScore.assignment_id , AssignmentScore.student_id , AssignmentScore.score , Users.*
                        FROM assignment_score AS AssignmentScore , user AS Users
                        WHERE AssignmentScore.student_id IN (SELECT Student.id
                                                             FROM user AS Student
                                                             WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
                                                                                            FROM courses_classrooms AS CoursesClassroom
                                                                                            WHERE CoursesClassroom.course_id = ?)
                                                             AND Student.role="student")
                        AND AssignmentScore.assignment_id IN (SELECT id
                                                              FROM assignment AS Assignment
                                                              WHERE Assignment.problemset_id = ?)
                        AND Users.id = AssignmentScore.student_id
                        ORDER BY AssignmentScore.score DESC
                        LIMIT 5',
            array($course_id, $problemset_id)
        );

        $this->set('course_name',$course_name);
        $this->set('result',$result);
        $this->set('problemset_name',$problemset_name);
    }

    public function course_lowest_score($course_id,$problemset_id){
        $problemset = $this->ProblemSet->findByProblemsetId($problemset_id);
        $problemset_name = $problemset['ProblemSet']['problemset_name'];
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AssignmentScore.assignment_id , AssignmentScore.student_id , AssignmentScore.score , Users.*
                        FROM assignment_score AS AssignmentScore , user AS Users
                        WHERE AssignmentScore.student_id IN (SELECT Student.id
                                                             FROM user AS Student
                                                             WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
                                                                                            FROM courses_classrooms AS CoursesClassroom
                                                                                            WHERE CoursesClassroom.course_id = ?)
                                                             AND Student.role="student")
                        AND AssignmentScore.assignment_id IN (SELECT id
                                                              FROM assignment AS Assignment
                                                              WHERE Assignment.problemset_id = ?)
                        AND Users.id = AssignmentScore.student_id
                        ORDER BY AssignmentScore.score ASC
                        LIMIT 5',
            array($course_id, $problemset_id)
        );

        $this->set('course_name',$course_name);
        $this->set('result',$result);
        $this->set('problemset_name',$problemset_name);
    }

    public function course_progress($problemset_id){
    	$problemset = $this->ProblemSet->findByProblemsetId($problemset_id);
    	$problemset_name = $problemset['ProblemSet']['problemset_name'];
    	$course_id = $problemset['ProblemSet']['course_id'];
    	$course = $this->Course->findByCourseId($course_id);
    	$course_name = $course['Course']['course_name'];
    	
    	$db = $this->AssignmentScore->getDataSource();
    	$result = $db->fetchAll(
    			'SELECT count(AssignmentScore.assignment_score_id) AS assignment_complete 
				FROM assignment_score AS AssignmentScore , assignment AS Assignment 
				WHERE AssignmentScore.assignment_id = Assignment.id 
				AND Assignment.problemset_id = ?',
    			array($problemset_id)
    	);
    	$result2 = $db->fetchAll(
    			'SELECT count(*) AS total_assignment 
				FROM user AS User , assignment AS Assignment
    			WHERE User.classroom_id = Assignment.classroom_id
    			AND Assignment.problemset_id = ?',
    			array($problemset_id)
    	);
    	
    	$this->set('result',$result);
    	$this->set('result2',$result2);
    	$this->set('problemset_name',$problemset_name);
    	$this->set('course_name',$course_name);
    	
    }
    
    public function class_progress($classroom_id,$problemset_id){
    	$problemset = $this->ProblemSet->findByProblemsetId($problemset_id);
    	$problemset_name = $problemset['ProblemSet']['problemset_name'];
    	$classroom = $this->Classroom->findById($classroom_id);
    	$classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
    	 
    	$db = $this->AssignmentScore->getDataSource();
    	$result = $db->fetchAll(
    			'SELECT count(AssignmentScore.assignment_score_id) AS assignment_complete
				FROM assignment_score AS AssignmentScore , assignment AS Assignment , user AS User
				WHERE AssignmentScore.assignment_id = Assignment.id 
    			AND User.id = AssignmentScore.student_id 
    			AND User.classroom_id = ? 
				AND Assignment.problemset_id = ?',
    			array($classroom_id,$problemset_id)
    	);
    	$result2 = $db->fetchAll(
    			'SELECT count(*) AS total_assignment
				FROM user AS User , assignment AS Assignment
    			WHERE User.classroom_id = Assignment.classroom_id 
    			AND Assignment.classroom_id = ? 
    			AND Assignment.problemset_id = ?',
    			array($classroom_id,$problemset_id)
    	);
    	 
    	$this->set('result',$result);
    	$this->set('result2',$result2);
    	$this->set('problemset_name',$problemset_name);
    	$this->set('classroom_name',$classroom_name);
    	 
    }

    public function get_class_progress($classroom_id,$problemset_id){
        $problemset = $this->ProblemSet->findByProblemsetId($problemset_id);
        $problemset_name = $problemset['ProblemSet']['problemset_name'];
        $classroom = $this->Classroom->findById($classroom_id);
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT count(AssignmentScore.assignment_score_id) AS assignment_complete
				FROM assignment_score AS AssignmentScore , assignment AS Assignment , user AS User
				WHERE AssignmentScore.assignment_id = Assignment.id
    			AND User.id = AssignmentScore.student_id
    			AND User.classroom_id = ?
				AND Assignment.problemset_id = ?',
            array($classroom_id,$problemset_id)
        );
        $result2 = $db->fetchAll(
            'SELECT count(*) AS total_assignment
				FROM user AS User , assignment AS Assignment
    			WHERE User.classroom_id = Assignment.classroom_id
    			AND Assignment.classroom_id = ?
    			AND Assignment.problemset_id = ?',
            array($classroom_id,$problemset_id)
        );

        return array($result,$result2);

        //$this->set('result',$result);
        //$this->set('result2',$result2);
        //$this->set('problemset_name',$problemset_name);
        //$this->set('classroom_name',$classroom_name);
    }

}

?>