<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/29/13 AD
 * Time: 5:04 PM
 * To change this template use File | Settings | File Templates.
 */
class LessonPlanController extends AppController {
    public $uses = array('Lesson','Course','Topic','ProblemSet','CoursesLesson','Teacher'
                         ,'Problem','ProblemLevel','ProblemDataSet','ProblemsetsProblem'
                         ,'Classroom','Assignment','AssignmentScore','User','CoursesClassroom');

    public $components = array('RequestHandler');

    public function index(){
        if($this->Auth->user('role') == "teacher"){
            $data = $this->Teacher->findById($this->Auth->user('id'));
        }else{
           $this->Classroom->recursive = 2 ;
            $classroom = $this->Classroom->User->findById($this->Auth->user('id')) ;
           $classroom_id = $classroom["Classroom"]["id"];
            $data = $this->Course->Classroom->find('all',array("conditions"=>array("Classroom.id" => $classroom_id))) ;

            //pr($data[0]["Course"]);
            $data = $data[0];
        }

        $course_lesson = $this->Course->find('all');
        $courses = $data["Course"];
        //pr($courses);
        $course_id = array();
        $course_lesson_data =array();
        for($i=0;$i<count($courses);$i++){
            $course_id[$i] = $courses[$i]["course_id"];
        }
        for($i=0;$i<count($course_lesson);$i++){
            if( in_array($course_lesson[$i]["Course"]["course_id"],$course_id) )
                $course_lesson_data[ $course_lesson[$i]["Course"]["course_id"] ] = $course_lesson[$i]["Lesson"];
        }
        //pr($course_lesson_data);
        //pr($course_id);
        //pr($this->Course->find('all'));
        $this->set('data',$course_lesson_data);
        $this->set('courses',$courses);
    }

    public function view($course_id){
        //$this->Lesson->recursive = 2 ;
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);

        //pr($data);
    }

    public function full($course_id){
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);
    }

    public function full_calendar($course_id){
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);
    }
}