<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Apple
 * Date: 3/11/13 AD
 * Time: 5:17 PM
 * To change this template use File | Settings | File Templates.
 */
/**
 * @property Assignment $Assignment
 * @property StudentsAssignment StudentsAssignment
 */

App::uses('CakeTime', 'Utility');

class StudentController extends AppController{

    public $uses = array('Assignment','ProblemsetsProblem','ProblemDataSet','StudentsAssignment'
    ,'AssignmentScore','Classroom','CoursesClassroom','Course','User','Lesson');

    private function getTopClassList($all){
        $student_id = $this->Auth->user('id');
        $student = $this->User->find('first',array(
            'conditions' => array('User.id' => $student_id),
            'recursive' => -1));
        $classroom_id = $student['User']['classroom_id'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll('SET @rank=0');
        $result = $db->fetchAll(
            'SELECT *
                    FROM (SELECT  A.* , @rank:=@rank+1 AS rank
                                    FROM (SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , SUM(AssignmentScore.question) AS total_question , User.title , User.first_name , User.last_name , User.classroom_id
                                    FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                                                    (Assignment.id = AssignmentScore.assignment_id
                                                            AND User.id = AssignmentScore.student_id)
                                                            WHERE User.role = "student"
                                                    AND User.classroom_id = ?
                                                    GROUP BY User.id
                                    ORDER BY total_score DESC , User.id ASC
                    ) AS A ) AS Student
                    WHERE Student.student_id = ?',
            array($classroom_id,$student_id)
        );

        if (!$all)
        {
            $result2 = $db->fetchAll(
                'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , SUM(AssignmentScore.question) AS total_question , User.title , User.first_name , User.last_name , User.classroom_id
                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                            (Assignment.id = AssignmentScore.assignment_id
                                    AND User.id = AssignmentScore.student_id)
                                    WHERE User.role = "student"
                            AND User.classroom_id = ?
                            GROUP BY User.id
                ORDER BY total_score DESC , User.id ASC
                LIMIT 3',
                array($classroom_id)
            );
        }
        else
        {
            $result2 = $db->fetchAll(
                'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , SUM(AssignmentScore.question) AS total_question , User.title , User.first_name , User.last_name , User.classroom_id
                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                                (Assignment.id = AssignmentScore.assignment_id
                                        AND User.id = AssignmentScore.student_id)
                                        WHERE User.role = "student"
                                AND User.classroom_id = ?
                                GROUP BY User.id
                ORDER BY total_score DESC , User.id ASC',
                array($classroom_id)
            );
        }

        $result3 = $db->fetchAll('
                        SELECT COUNT(Assignment.id) AS total_assignment
                        FROM assignment AS Assignment
                        WHERE Assignment.classroom_id = ?
                        AND Assignment.release_date <= NOW()',
            array($classroom_id)
        );

        if(!empty($result) && ($result3[0][0]['total_assignment']==$result[0]['Student']['total_do_assignment'])){
            $complete_assignment = true;
        }else{
            $complete_assignment = false;
        }

        if(!empty($result) && $result[0]['Student']['rank'] <= 3)
            $beTop3 = true;
        else
            $beTop3 = false;

        $return = array('Student' => $result[0]['Student'],'List' => $result2,'total_assignment' => $result3[0][0]['total_assignment'] ,'complete_assignment' => $complete_assignment,'be_top3' => $beTop3);

        return $return;
    }

    private function setAssignmentStatus(){
        date_default_timezone_set("Asia/Bangkok");
        $assignments = $this->Assignment->find('all',array(
            'conditions' => array(
                'classroom_id' => $this->Auth->user('classroom_id'),
                'status' => (array('assigned','released'))
            )));
        foreach($assignments as $assignment)
        {
            $isEnd = substr(CakeTime::timeAgoInWords($assignment['Assignment']['end_date']),-3);
            switch($assignment['Assignment']['status'])
            {
                case('released') :
                    if ($isEnd == 'ago' || $isEnd == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        $this->Assignment->saveField('status','ended');
                    }
                    break;
                case ('assigned') :
                    $isRelease = substr(CakeTime::timeAgoInWords($assignment['Assignment']['release_date']),-3);
                    if ($isRelease== 'ago' || $isRelease == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        if ($isEnd == 'ago' || $isEnd == 'now')
                            $this->Assignment->saveField('status','ended');
                        else
                            $this->Assignment->saveField('status','released');
                    }
                    break;
                default : break;
            }
        }
    }

    private function saveStudentAnswer($problem,$asid,$answers,$i){
        $this->StudentsAssignment->create();
        $this->StudentsAssignment->set(array(
            'problemset_problem_id' => $problem['ProblemsetsProblem']['problemset_problem_id'],
            'student_id' => $this->Auth->user('id'),
            'assignment_id' => $asid,
            'problem_level_id' => $problem['ProblemsetsProblem']['problem_level_id'],
            'problem_level_dataset_id' => $problem['DataSet'][$answers['Problem'. $i .' hidden']]['ProblemDataSet']['problem_level_dataset_id']
        ));
        $std_ans = "";
        switch($problem['Problem']['problem_type'])
        {
            case "FIB" :
                for ($j = 1; $j <= $problem['ProblemLevel']['input_num'];$j++)
                {
                    if ($j > 1)
                    {
                        $std_ans .= ';';
                    }
                    $std_ans .= trim($answers['Problem'. $i . ' ' . $j]);
                }
                break;
            case "MPC" :
                $std_ans = $answers['Problem'. $i];
        }
        $this->StudentsAssignment->set('student_answer',$std_ans);
        $dataset = $problem['DataSet'][$answers['Problem'. $i .' hidden']]['ProblemDataSet']['dataset'];
        $solution = $this->getSolution($problem,$dataset);
        $correct = $std_ans == $solution;
        if ($correct)
            $this->StudentsAssignment->set('answer_status',1);
        else
            $this->StudentsAssignment->set('answer_status',0);
        $this->StudentsAssignment->save();
        return $correct;
    }

    private function getSolution($problem,$dataset){
        switch($problem['Problem']['problem_type'])
        {
            case "FIB" :
                for ($j = 0;$j < $problem['ProblemLevel']['output_num'];$j++)
                {
                    $dataset = substr($dataset,strpos($dataset,';')+1);
                }
                $solution = $dataset;
                break;
            case "MPC" :
                $solution = substr($dataset,strrpos($dataset,';',null)+1);
                break;
        }
        return $solution;
    }

    public function index2(){

    }

    public function index(){
        //$assignments = $this->Assignment->findAllByClassroomId($this->Auth->user('classroom_id'));

        //Automatic set status for assignment
        $this->setAssignmentStatus();

        $classroom = $this->Classroom->find('first',array(
            'conditions' => array(
                'id' => ($this->Auth->user('classroom_id'))
            ),
            'recursive' => 0
        ));
        $courses = $this->CoursesClassroom->find('all',array(
            'conditions' => array(
                'classroom_id' => $classroom['Classroom']['id'],
            ),
            'recursive' => 2,
            'fields' => array('CoursesClassroom.course_id','Course.course_name','Course.course_id')
        ));
        $courses_num = count($courses);
        for ($i = 0; $i< $courses_num;$i++)
        {
            $lessons = $courses[$i]['Course']['Lesson'];
            $last = array();
            $now = array();
            $next = array();
            $last_monday = strtotime('Monday last week');
            $last_sunday = strtotime('Sunday last week');
            $this_monday = strtotime('Monday this week');
            $this_sunday = strtotime('Sunday this week');
            $next_monday = strtotime('Monday next week');
            $next_sunday = strtotime('Sunday next week');
            foreach ($lessons as $lesson)
            {
                $lesson_start_date = strtotime($lesson['start_date']);
                $lesson_end_date = strtotime($lesson['end_date']);
                if (($lesson_start_date<$last_monday&&$lesson_end_date>=$last_monday)||($lesson_start_date>=$last_monday&&$lesson_start_date<=$last_sunday))
                {
                    $last[count($last)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$this_monday)
                        $now[count($now)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$next_monday)
                        $next[count($next)] = $lesson['lesson_name'];
                }
                else if ($lesson_start_date>=$this_monday&&$lesson_start_date<=$this_sunday)
                {
                    $now[count($now)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$next_monday)
                        $next[count($next)] = $lesson['lesson_name'];
                }
                else if ($lesson_start_date>=$next_monday&&$lesson_start_date<=$next_sunday)
                {
                    $next[count($next)] = $lesson['lesson_name'];
                }
            }
            $courses[$i]['LessonPlan']['This'] = $now;
            $courses[$i]['LessonPlan']['Next'] = $next;
            $courses[$i]['LessonPlan']['Last'] = $last;
        }
        $this->set('courses',$courses);

        $done = array();
        $not_done = array();
        $released = $this->Assignment->find('all',array(
            'conditions' => array(
                'classroom_id' => $this->Auth->user('classroom_id'),
                'status' => 'released'
            ),
            'fields' =>array(
                'Assignment.id','Assignment.problemset_id','Assignment.status','Assignment.release_date','Assignment.end_date',
                'ProblemSet.problemset_id','ProblemSet.problemset_name','Problemset.course_id'
            ),
            'recursive' => 2,
            'order' => "Assignment.end_date ASC"
        ));
        for ($i = 0 ; $i < count($released) ;$i++)
        {
            //Method 1
            $assignment_score = $this->AssignmentScore->findByAssignmentIdAndStudentId($released[$i]['Assignment']['id'],$this->Auth->user('id'));

            //Method 2
            /*
            $submit_num = count($released[$i]['AssignmentScore']);
            $assignment_score = null;
            for ($j = 0;$j < $submit_num ;$j++)
            {
                if ($released[$i]['AssignmentScore'][$j]['student_id'] == $this->Auth->user('id'))
                {
                    $assignment_score = true;
                    break;
                }
            }
            */
            if ($assignment_score != null)
            {
                $released[$i]['Score'] = $assignment_score['AssignmentScore'];
                array_push($done,$released[$i]);
            }
            else
            {
                array_push($not_done,$released[$i]);
            }
        }
        $this->set("assignments",$released);
        $this->set("done",$done);
        $this->set("not_done",$not_done);

        $leaderboard = $this->getTopClassList(false);
        //pr($leaderboard);
        $this->set("leaderboard",$leaderboard);
    }

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->Auth->allow('add');
            $this->layout = 'school_admin';
        }
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'student' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function add($classroomid){
        if ($this->request->is('post')){
            $uses = array('User');
            $this->loadModel('User');
            $sadmin = $this->Auth->user();
            $this->User->set('school_id',$sadmin['school_id']);
            $this->User->set('classroom_id',$classroomid);
            $this->User->set('role','student');
            if($this->User->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }

    public function assignment($asid){
        //$asid = Assignment ID
        $assignment = $this->Assignment->findById($asid);
        $this->set('assignment',$assignment);
    }

    public function start($str)
    {
        $asid = substr($str,11);
        $assignment = $this->Assignment->find('first',array(
            'conditions' => array(
                'Assignment.id' => $asid
            ),
            'fields' => 'ProblemSet.problemset_id'
        ));
        $problems = $this->ProblemsetsProblem->findAllByProblemsetId($assignment['ProblemSet']['problemset_id']);
        //$lproblems = All Problems that already binded with Level and Dataset
        $lproblems = array();
        foreach ($problems as $problem)
        {
            $problem['DataSet'] = $this->ProblemDataSet->findAllByProblemLevelId($problem['ProblemLevel']['problem_level_id']);
            array_push($lproblems,$problem);
        }
        //pr($lproblems);
        $this->set('problems',$lproblems);
        $this->set('asid',$asid);

        if ($this->request->is('post'))
        {
            $answers = $this->request->data('StudentsAssignment');
            $i = 1;
            $totalScore = 0;
            $totalQuestion = count($lproblems);
            $totalLevel = 0;
            foreach ($lproblems as $problem)
            {
                //saveStudentAnswer return "Is the student answer correct"
                if($this->saveStudentAnswer($problem,$asid,$answers,$i))
                    $totalScore++;
                $totalLevel += $problem['ProblemLevel']['level_id'];
                $i++;
            }
            $avg_level = $totalLevel/$totalQuestion;

            // Save Assignment Score of the student
            $score=$this->AssignmentScore->findByStudentIdAndAssignmentId($this->Auth->user('id'),$asid);
            if(!empty($score)){
                $this->AssignmentScore->id = $score['AssignmentScore']['assignment_score_id'];
            }
            $this->AssignmentScore->save(array('student_id' => $this->Auth->user('id') ,
                'assignment_id' => $asid ,
                'score' => $totalScore ,
                'question' => $totalQuestion ,
                'average_level' => $avg_level));

            //$this->redirect('/student/showCheckAnswer/'.$this->Auth->user('id').'/'.$asid);
            $this->set('totalScore',$totalScore);
            $this->set('totalQuestion',$totalQuestion);

        }
    }

    public function showCheckAnswer($student_id,$assignment_id){
        //$studentAssignmentList = $this->StudentsAssignment->findAllByStudentIdAndAssignmentId($student_id,$assignment_id);
        $db = $this->StudentsAssignment->getDataSource();
        $studentAssignments = $db->fetchAll(
            'SELECT StudentsAssignment.student_answer,StudentsAssignment.answer_status
            ,ProblemDataset.dataset,ProblemLevel.input_num,ProblemLevel.output_num,ProblemLevel.choice_num,ProblemLevel.main_text
            ,Problem.problem_type FROM students_assignments AS StudentsAssignment
            INNER JOIN level_datasets AS ProblemDataSet ON StudentsAssignment.problem_level_dataset_id = ProblemDataSet.problem_level_dataset_id
            INNER JOIN problem_levels AS ProblemLevel ON StudentsAssignment.problem_level_id = ProblemLevel.problem_level_id
            INNER JOIN (problemsets_problems AS ProblemsetProblem INNER JOIN problems AS Problem ON ProblemsetProblem.problem_id = Problem.problem_id)
            ON ProblemsetProblem.problemset_problem_id = StudentsAssignment.problemset_problem_id
            WHERE StudentsAssignment.student_id = ? AND StudentsAssignment.assignment_id = ?',
            array($student_id,$assignment_id)
        );
        //pr($studentAssignments);
        $this->set('studentAssignments',$studentAssignments);
        $totalScore = 0;
        $totalQuestion = 0;
        foreach($studentAssignments as $studentAssignment){
            if($studentAssignment['StudentsAssignment']['answer_status'] == 1)
            {
                $totalScore++;
            }
            $totalQuestion++;
        }
        $this->set('totalScore',$totalScore);
        $this->set('totalQuestion',$totalQuestion);
    }

    /*
    public function setAnswerStatus($student_id,$assignment_id){
        $studentAssignmentList = $this->StudentsAssignment->findAllByStudentIdAndAssignmentId($student_id,$assignment_id);
        $totalScore = 0;
        $totalQuestion = 0;
        $totalLevel = 0;
        foreach($studentAssignmentList as $studentAssignment){
            $studentAssignmentId = $studentAssignment['StudentsAssignment']['student_assignment_id'];
            $output_num = $studentAssignment['ProblemLevel']['output_num'];
            $input_num = $studentAssignment['ProblemLevel']['input_num'];
            $p_level = $studentAssignment['ProblemLevel']['level_id'];
            $dataset = $studentAssignment['ProblemDataSet']['dataset'];
            $student_answer = $studentAssignment['StudentsAssignment']['student_answer'];
            $dataset = explode(";", $dataset);
            $answer = explode(";", $student_answer);
            $solveList = array_slice($dataset, $output_num);

            $correct = true;
            pr($solveList);
            pr($answer);
            for($i=0;$i<$input_num;$i++){
                if($solveList[$i] != $answer[$i]){
                    $correct = false;
                }
            }
            if($correct){
                $this->StudentsAssignment->id = $studentAssignmentId;
                $this->StudentsAssignment->saveField('answer_status', '1',false);
                $totalScore++;
            }else{
                $this->StudentsAssignment->id = $studentAssignmentId;
                $this->StudentsAssignment->saveField('answer_status', '0',false);
            }
            $totalQuestion++;
            $totalLevel += $p_level;
        }
        
        $avg_level = $totalLevel/$totalQuestion;

        // Save score
        $score=$this->AssignmentScore->findByStudentIdAndAssignmentId($student_id,$assignment_id);
        if(!empty($score)){
            $this->AssignmentScore->id = $score['AssignmentScore']['assignment_score_id'];
        }
        $this->AssignmentScore->save(array('student_id' => $student_id ,
            'assignment_id' => $assignment_id ,
            'score' => $totalScore ,
            'question' => $totalQuestion ,
        	'average_level' => $avg_level));

        $this->redirect('/student/showCheckAnswer/'.$student_id.'/'.$assignment_id);
    }
    */
    
    public function view_class_rank($lesson_id){
        $student_id = $this->Auth->user('id');
        $student = $this->User->find('first',array(
            'conditions' => array('User.id' => $student_id),
            'recursive' => -1));
        $classroom_id = $student['User']['classroom_id'];
        $classroom = $this->Classroom->find('first',array(
            'conditions' => array('Classroom.id' => $classroom_id),
            'recursive' => -1));
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
        $lesson = $this->Lesson->find('first',array(
            'conditions' => array('Lesson.lesson_id' => $lesson_id),
            'recursive' => -1));
        $lesson_name = $lesson['Lesson']['lesson_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll('SET @rank=0');
        $result = $db->fetchAll(
            'SELECT *
                FROM (SELECT  A.* , @rank:=@rank+1 AS rank
                        FROM (SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name
                                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                    (Assignment.id = AssignmentScore.assignment_id
                                    AND User.id = AssignmentScore.student_id)
                                WHERE User.role = "student"
                                AND User.classroom_id = ?
                                AND Assignment.id IN (SELECT Assignment.id
                                                                        FROM assignment AS Assignment , problemset AS Problemset
                                                                        WHERE Assignment.problemset_id = Problemset.problemset_id
                                                                        AND Problemset.course_id IN (SELECT CoursesLesson.course_id
                                                                                                        FROM courses_lessons AS CoursesLesson
                                                                                                        WHERE CoursesLesson.lesson_id = ?
                                                                                                        )
                                                                        )
                                GROUP BY User.id
                                ORDER BY total_score DESC , User.id ASC
                        ) AS A ) AS Student
                WHERE Student.student_id = ?',
            array($classroom_id,$lesson_id,$student_id)
        );

        $result2 = $db->fetchAll(
            'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name
                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                        (Assignment.id = AssignmentScore.assignment_id
                        AND User.id = AssignmentScore.student_id)
                WHERE User.role = "student"
                AND User.classroom_id = ?
                AND Assignment.id IN (SELECT Assignment.id
                                                                        FROM assignment AS Assignment , problemset AS Problemset
                                                                        WHERE Assignment.problemset_id = Problemset.problemset_id
                                                                        AND Problemset.course_id IN (SELECT CoursesLesson.course_id
                                                                                                        FROM courses_lessons AS CoursesLesson
                                                                                                        WHERE CoursesLesson.lesson_id = ?
                                                                                                        )
                                                                        )
                GROUP BY User.id
                ORDER BY total_score DESC , User.id ASC
                LIMIT 10',
            array($classroom_id,$lesson_id)
        );

        $result3 = $db->fetchAll('
    			SELECT COUNT(Assignment.id) AS total_assignment
    			FROM assignment AS Assignment , problemset AS Problemset
    			WHERE Assignment.classroom_id = ?
    			AND Assignment.problemset_id = Problemset.problemset_id
    			AND Problemset.course_id IN (SELECT CoursesLesson.course_id
    										FROM courses_lessons AS CoursesLesson
    										WHERE CoursesLesson.lesson_id = ?)
    			AND Assignment.release_date <= NOW()',
            array($classroom_id,$lesson_id)
        );

        if(!empty($result) && ($result3[0][0]['total_assignment']==$result[0]['Student']['total_do_assignment'])){
            $complete_assignment = true;
        }else{
            $complete_assignment = false;
        }

        if(!empty($result) && $result[0]['Student']['rank'] <= 10)
            $beTop10 = true;
        else
            $beTop10 = false;

        $this->set('lesson_name',$lesson_name);
        $this->set('classroom_name',$classroom_name);
        $this->set('complete_assignment',$complete_assignment);
        $this->set('beTop10',$beTop10);
        $this->set('top10List',$result2);
        $this->set('student',$result);
        $this->set('student_id',$student_id);
    }
    
    public function view_course_rank($lesson_id){
        $student_id = $this->Auth->user('id');
        $student = $this->User->find('first',array(
            'conditions' => array('User.id' => $student_id),
            'recursive' => -1));
        $classroom_id = $student['User']['classroom_id'];

        $lesson = $this->Lesson->find('first',array(
            'conditions' => array('Lesson.lesson_id' => $lesson_id),
            'recursive' => -1));
        $lesson_name = $lesson['Lesson']['lesson_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll('SET @rank=0');
        $result = $db->fetchAll(
            'SELECT *
                FROM (SELECT  A.* , @rank:=@rank+1 AS rank
                        FROM (SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name
                                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                        (Assignment.id = AssignmentScore.assignment_id
                                        AND User.id = AssignmentScore.student_id)
                                WHERE User.role = "student"
                                AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
                                                                FROM problemset AS Problemset INNER JOIN
                                                                    courses_lessons AS CoursesLesson
                                                                    ON (Problemset.course_id = CoursesLesson.course_id)
                                                                WHERE CoursesLesson.lesson_id = ?)
                                AND User.classroom_id IN (SELECT CoursesClassroom.classroom_id
                                                              FROM courses_classrooms AS CoursesClassroom ,
                                                                      courses_classrooms AS CoursesClassroom2
                                                              WHERE CoursesClassroom.course_id = CoursesClassroom2.course_id
                                                              AND CoursesClassroom2.classroom_id = ?)
                                GROUP BY User.id
                                ORDER BY total_score DESC , User.id ASC
                        ) AS A ) AS Student
                WHERE Student.student_id = ?',
            array($lesson_id,$classroom_id,$student_id)
        );

        $result2 = $db->fetchAll(
            'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name
                FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                        (Assignment.id = AssignmentScore.assignment_id
                        AND User.id = AssignmentScore.student_id)
                WHERE User.role = "student"
                AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
                                                    FROM problemset AS Problemset INNER JOIN
                                                        courses_lessons AS CoursesLesson
                                                        ON (Problemset.course_id = CoursesLesson.course_id)
                                                    WHERE CoursesLesson.lesson_id = ?)
                AND User.classroom_id IN (SELECT CoursesClassroom.classroom_id
                                              FROM courses_classrooms AS CoursesClassroom ,
                                                  courses_classrooms AS CoursesClassroom2
                                              WHERE CoursesClassroom.course_id = CoursesClassroom2.course_id
                                              AND CoursesClassroom2.classroom_id = ?)
                GROUP BY User.id
                ORDER BY total_score DESC , User.id ASC
                LIMIT 10',
            array($lesson_id,$classroom_id)
        );

        if(!empty($result) && ($result[0]['Student']['total_do_assignment']==$result[0]['Student']['total_assignment'])){
            $complete_assignment = true;
        }else{
            $complete_assignment = false;
        }

        if(!empty($result) && $result[0]['Student']['rank'] <= 10)
            $beTop10 = true;
        else
            $beTop10 = false;

        $this->set('lesson_name',$lesson_name);
        $this->set('complete_assignment',$complete_assignment);
        $this->set('beTop10',$beTop10);
        $this->set('top10List',$result2);
        $this->set('student',$result);
        $this->set('student_id',$student_id);
    }

    public function leaderboard()
    {
        $student_id = $this->Auth->user('id');
        $student = $this->User->find('first',array(
            'conditions' => array('User.id' => $student_id),
            'recursive' => -1));
        $classroom_id = $student['User']['classroom_id'];

        $db = $this->Lesson->getDataSource();
        $lesson_list = $db->fetchAll('
    			SELECT *
    			FROM lesson AS Lesson
    			WHERE Lesson.lesson_id IN (SELECT CoursesLesson.lesson_id
    										FROM courses_lessons AS CoursesLesson , courses_classrooms AS CoursesClassroom
    										WHERE CoursesClassroom.course_id = CoursesLesson.course_id
    										AND CoursesClassroom.classroom_id = ?)
    			',array($classroom_id));

        $leaderboard = $this->getTopClassList(true);
        $this->set('leaderboard',$leaderboard);
        $this->set('lesson_list',$lesson_list);
    }
}

?>