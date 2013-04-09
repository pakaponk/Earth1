<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/26/13 AD
 * Time: 4:57 PM
 * To change this template use File | Settings | File Templates.
 */
class LeaderBoardController extends AppController{

    public $uses = array('Lesson','Course','Topic','ProblemSet','CoursesLesson','Teacher'
                         ,'Problem','ProblemLevel','ProblemDataSet','ProblemsetsProblem'
                         ,'Classroom','Assignment','AssignmentScore','User');

    public function index(){
        $teacher_data = $this->Teacher->findById($this->Auth->user('id'));
        $course_data = $teacher_data["Course"];
        $class_data = $teacher_data["Classroom"];
        pr($class_data);
    }

    //This function will give top 10 in the specific class and specefic lesson
    public function top_class($class_id,$lesson_id){

    }

    public function top_course($course_id,$lesson_id){

    }

    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function isAuthorized($user){
        if($user['role'] == "student" || $user['role'] =="student"){
            return true ;
        }
        return parent::isAuthorized($user);
    }
}
?>