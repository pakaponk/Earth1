<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 2:21 PM
 * To change this template use File | Settings | File Templates.
 */

class CourseController extends AppController{
    public $uses = array('Course','CoursesLesson','Lesson','Classroom','AssignmentScore','User'
                    ,'ProblemSet','CoursesLesson','Assignment','Topic','Concept','Technique'
                    ,'Teacher','TeachersCourse');

    public function index(){
        //$this->autoRender = false ;
        if($this->Auth->user('role') == "teacher"){
            $teacher = $this->Teacher->findById($this->Auth->user('id'));
            $courses = $teacher["Course"];
        }else if($this->Auth->user('role') =="school_admin"){
            $arr = array();
            $courses = $this->Course->find('all');
            for($i=0;$i<count($courses);$i++){
                $arr[$i] = $courses[$i]["Course"];
            }
            $courses = $arr;
        }
        $this->set('courses',$courses);
        if($this->Auth->user('role') == "teacher"){
            $this->render('teacher_index');
        }else{
            $this->render('index');
        }
    }

    public function beforeRender(){
    }

    public function add(){
        $this->set('school_id',$this->Auth->user('school_id'));
        if( $this->request->is('post') ){
            //Get School id from user
            $this->Course->create();
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('The course has been saved'),'flash_complete');
            } else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'),'flash_notification');
            }

            if($this->Auth->user('role') === 'teacher'){
                $arr = array("teacher_course_id" =>""
                             ,"teacher_id" => $this->Auth->user('id')
                             ,"course_id" => $this->Course->id );
                $this->TeachersCourse->save($arr);
            }

            $this->redirect(array('action' => 'index'));
        }
    }

    public function edit($course_id){
        $courseData = $this->Course->findAllByCourseId($course_id);
        $this->set('data',$courseData);
        $this->set('school_id',$this->Auth->user('school_id'));

        $this->Course->id = $course_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('The course has been saved'),'flash_complete');
                $this->redirect('/course/index/');
            } else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->Course->read(null, $this->Course->id);
        }
    }

    public function del($course_id){
        $this->TeachersCourse->primaryKey = "teacher_course_id";
        $this->Course->delete($course_id,false);
        $this->CoursesLesson->deleteAll(array('CoursesLesson.course_id' => $course_id));
        $this->Session->setFlash(__('The course has been deleted'),'flash_complete');
        $this->redirect($this->referer());
    }


    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function isAuthorized($user) {
        if (isset($user['role'])) {
            if($user['role'] == "school_admin"){
                return true ;
            }else if($user['role'] == "teacher"){
                if($this->action =="add"){
                    return false ;
                }
                return true ;
            }
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function coursePerformanceLesson($course_id,$lesson_id){
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];
        $lesson = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lesson['Lesson']['lesson_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AVG(AssignmentScore.score) AS avg_score , AssignmentScore.question
    			FROM assignment_score AS AssignmentScore
    			WHERE AssignmentScore.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
    																				FROM courses_classrooms AS CoursesClassroom
    																				WHERE CoursesClassroom.course_id = ?) 
    												AND Student.role="student")
    			AND AssignmentScore.assignment_id IN (SELECT Assignment.id
    													FROM assignment AS Assignment , problemset AS Problemset
    													WHERE Assignment.problemset_id=Problemset.problemset_id
    													AND Problemset.course_id IN (SELECT CoursesLesson.course_id
    																					FROM courses_lessons AS CoursesLesson
    																					WHERE CoursesLesson.lesson_id = ?)
    													)
    			GROUP BY AssignmentScore.assignment_id',
            array($course_id, $lesson_id)
        );

        $scorePercent = 0;
        $totalQuestion = 0;
        foreach ($result AS $assignmentScore){
            $scorePercent += $assignmentScore[0]['avg_score'];
            $totalQuestion += $assignmentScore['AssignmentScore']['question'];
        }
        $scorePercent = $scorePercent*100/$totalQuestion;

        $this->set('scorePercent',$scorePercent);
        $this->set('lesson_name',$lesson_name);
        $this->set('course_name',$course_name);
        $this->set('result',$result);
    }

    public function coursePerformanceTopic($course_id,$topic_id){
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];
        $topic = $this->Topic->findByTopicId($topic_id);
        $topic_name = $topic['Topic']['topic_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AVG(AssignmentScore.score) AS avg_score , AssignmentScore.question
    			FROM assignment_score AS AssignmentScore
    			WHERE AssignmentScore.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
    																				FROM courses_classrooms AS CoursesClassroom
    																				WHERE CoursesClassroom.course_id = ?)
    												AND Student.role="student")
    			AND AssignmentScore.assignment_id IN (SELECT Assignment.id
    													FROM assignment AS Assignment , problemset AS Problemset
    													WHERE Assignment.problemset_id=Problemset.problemset_id
    													AND Problemset.course_id IN (SELECT CoursesLesson.course_id
    																					FROM courses_lessons AS CoursesLesson , topic AS Topic
    																					WHERE CoursesLesson.lesson_id=Topic.lesson_id
    																					AND Topic.topic_id = ?)
    													)
    			GROUP BY AssignmentScore.assignment_id',
            array($course_id, $topic_id)
        );

        $scorePercent = 0;
        $totalQuestion = 0;
        foreach ($result AS $assignmentScore){
            $scorePercent += $assignmentScore[0]['avg_score'];
            $totalQuestion += $assignmentScore['AssignmentScore']['question'];
        }
        $scorePercent = $scorePercent*100/$totalQuestion;

        $this->set('scorePercent',$scorePercent);
        $this->set('topic_name',$topic_name);
        $this->set('course_name',$course_name);
        $this->set('result',$result);
    }

    public function coursePerformanceConcept($course_id,$concept_id){
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];
        $concept = $this->Concept->findByConceptId($concept_id);
        $concept_name = $concept['Concept']['concept_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT SUM(StudentsAssignment.answer_status) AS sum_score , COUNT(StudentsAssignment.student_assignment_id) AS total_question
    			FROM students_assignments AS StudentsAssignment
    			WHERE StudentsAssignment.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
    																				FROM courses_classrooms AS CoursesClassroom
    																				WHERE CoursesClassroom.course_id = ?) 
    												AND Student.role="student")
    			AND StudentsAssignment.problem_level_id IN (SELECT ProblemLevel.problem_level_id
    													FROM problem_levels AS ProblemLevel , problems_tags AS ProblemTag
    													WHERE ProblemLevel.problem_id = ProblemTag.problem_id
    													AND ProblemTag.tag_id = ?
    													AND ProblemTag.type = ?)'
            ,array($course_id, $concept_id, 1)
        );

        $scorePercent = $result[0][0]['sum_score']*100/$result[0][0]['total_question'];

        $this->set('scorePercent',$scorePercent);
        $this->set('concept_name',$concept_name);
        $this->set('course_name',$course_name);
        $this->set('result',$result);

    }

    public function coursePerformanceTechnique($course_id,$technique_id){
        $course = $this->Course->findByCourseId($course_id);
        $course_name = $course['Course']['course_name'];
        $technique = $this->Technique->findByTechniqueId($technique_id);
        $technique_name = $technique['Technique']['technique_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT SUM(StudentsAssignment.answer_status) AS sum_score , COUNT(StudentsAssignment.student_assignment_id) AS total_question
    			FROM students_assignments AS StudentsAssignment
    			WHERE StudentsAssignment.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id IN (SELECT CoursesClassroom.classroom_id
    																				FROM courses_classrooms AS CoursesClassroom
    																				WHERE CoursesClassroom.course_id = ?)
    												AND Student.role="student")
    			AND StudentsAssignment.problem_level_id IN (SELECT ProblemLevel.problem_level_id
    													FROM problem_levels AS ProblemLevel , problems_tags AS ProblemTag
    													WHERE ProblemLevel.problem_id = ProblemTag.problem_id
    													AND ProblemTag.tag_id = ?
    													AND ProblemTag.type = ?)'
            ,array($course_id, $technique_id, 0)
        );

        $scorePercent = $result[0][0]['sum_score']*100/$result[0][0]['total_question'];

        $this->set('scorePercent',$scorePercent);
        $this->set('technique_name',$technique_name);
        $this->set('course_name',$course_name);
        $this->set('result',$result);

    }

}
