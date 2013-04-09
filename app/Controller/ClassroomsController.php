<?php
/**
 *@property Classroom $classrooms
 */

/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 19/3/2556
 * Time: 11:02 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassroomsController extends AppController{

    public $uses = array('Lesson','Classroom','AssignmentScore','User','ProblemSet','CoursesLesson','Assignment','Topic','Concept','Technique');

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->layout = 'school_admin';
        }
    }

    public function index(){
        $sadmin = $this->Auth->user();
        $classrooms = $this->Classroom->findAllBySchoolId($sadmin['school_id']);
        $this->set('classrooms',$classrooms);
    }

    public function create(){
        if ($this->request->is('post')){
            $sadmin = $this->Auth->user();
            //pr($sadmin);
            $this->request->data["Classroom"]["school_id"] = $sadmin["school_id"];
            if($this->Classroom->save( $this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }

    public function edit($classroomid){
        if ($this->request->is('post')){
            $this->Classroom->id = $classroomid;
            $this->Classroom->save($this->request->data);
            $this->redirect(array(
                'controller' => 'classrooms',
                'action' => 'index'
            ));
        }
    }

    public function classPerformanceLesson($classroom_id,$lesson_id){
        $classroom = $this->Classroom->findById($classroom_id);
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
        $lesson = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lesson['Lesson']['lesson_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AVG(AssignmentScore.score) AS avg_score , AssignmentScore.question
    			FROM assignment_score AS AssignmentScore
    			WHERE AssignmentScore.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id = ?
    												AND Student.role="student")
    			AND AssignmentScore.assignment_id IN (SELECT Assignment.id
    													FROM assignment AS Assignment , problemset AS Problemset
    													WHERE Assignment.problemset_id=Problemset.problemset_id
    													AND Problemset.course_id IN (SELECT CoursesLesson.course_id
    																					FROM courses_lessons AS CoursesLesson
    																					WHERE CoursesLesson.lesson_id = ?)
    													)
    			GROUP BY AssignmentScore.assignment_id',
            array($classroom_id, $lesson_id)
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
        $this->set('classroom_name',$classroom_name);
        $this->set('result',$result);
    }

    public function classPerformanceTopic($classroom_id,$topic_id){
        $classroom = $this->Classroom->findById($classroom_id);
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
        $topic = $this->Topic->findByTopicId($topic_id);
        $topic_name = $topic['Topic']['topic_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT AVG(AssignmentScore.score) AS avg_score , AssignmentScore.question
    			FROM assignment_score AS AssignmentScore
    			WHERE AssignmentScore.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id = ?
    												AND Student.role="student")
    			AND AssignmentScore.assignment_id IN (SELECT Assignment.id
    													FROM assignment AS Assignment , problemset AS Problemset
    													WHERE Assignment.problemset_id=Problemset.problemset_id
    													AND Problemset.course_id IN (SELECT CoursesLesson.course_id
    																					FROM courses_lessons AS CoursesLesson , topic AS Topic 
    																					WHERE CoursesLesson.lesson_id=Topic.lesson_id 
    																					AND Topic.topic_id = ?)    													)
    			GROUP BY AssignmentScore.assignment_id',
            array($classroom_id, $topic_id)
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
        $this->set('classroom_name',$classroom_name);
        $this->set('result',$result);
    }

    public function classPerformanceConcept($classroom_id,$concept_id){
        $classroom = $this->Classroom->findById($classroom_id);
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
        $concept = $this->Concept->findByConceptId($concept_id);
        $concept_name = $concept['Concept']['concept_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT SUM(StudentsAssignment.answer_status) AS sum_score , COUNT(StudentsAssignment.student_assignment_id) AS total_question
    			FROM students_assignments AS StudentsAssignment 
    			WHERE StudentsAssignment.student_id IN (SELECT Student.id 
    												FROM user AS Student 
    												WHERE Student.classroom_id = ? 
    												AND Student.role="student") 
    			AND StudentsAssignment.problem_level_id IN (SELECT ProblemLevel.problem_level_id 
    													FROM problem_levels AS ProblemLevel , problems_tags AS ProblemTag 
    													WHERE ProblemLevel.problem_id = ProblemTag.problem_id 
    													AND ProblemTag.tag_id = ? 
    													AND ProblemTag.type = ?)'
            ,array($classroom_id, $concept_id, 1)
        );

        $scorePercent = $result[0][0]['sum_score']*100/$result[0][0]['total_question'];

        $this->set('scorePercent',$scorePercent);
        $this->set('concept_name',$concept_name);
        $this->set('classroom_name',$classroom_name);
        $this->set('result',$result);

    }

    public function classPerformanceTechnique($classroom_id,$technique_id){
        $classroom = $this->Classroom->findById($classroom_id);
        $classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
        $technique = $this->Technique->findByTechniqueId($technique_id);
        $technique_name = $technique['Technique']['technique_name'];

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll(
            'SELECT SUM(StudentsAssignment.answer_status) AS sum_score , COUNT(StudentsAssignment.student_assignment_id) AS total_question
    			FROM students_assignments AS StudentsAssignment
    			WHERE StudentsAssignment.student_id IN (SELECT Student.id
    												FROM user AS Student
    												WHERE Student.classroom_id = ?
    												AND Student.role="student")
    			AND StudentsAssignment.problem_level_id IN (SELECT ProblemLevel.problem_level_id
    													FROM problem_levels AS ProblemLevel , problems_tags AS ProblemTag
    													WHERE ProblemLevel.problem_id = ProblemTag.problem_id
    													AND ProblemTag.tag_id = ?
    													AND ProblemTag.type = ?)'
            ,array($classroom_id, $technique_id, 0)
        );

        $scorePercent = $result[0][0]['sum_score']*100/$result[0][0]['total_question'];

        $this->set('scorePercent',$scorePercent);
        $this->set('technique_name',$technique_name);
        $this->set('classroom_name',$classroom_name);
        $this->set('result',$result);

    }

}