<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/18/13 AD
 * Time: 2:30 PM
 * To change this template use File | Settings | File Templates.
 */

class SchoolAdminController extends AppController{

    public $uses = array('Lesson','Course','Topic','Users','Post','CoursesLesson');
    public $layout = 'school_admin';

    public function index(){

    }

    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'school_admin' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function course_lesson_topic_management(){

    }

    public function class_teacher_student_management(){

    }

    public function testadd(){
        //pr($this->CoursesLesson->find('all'));

        /*$data = array(
            'CoursesLesson' => array(
                'lesson_id' => 0,
                'course_id' => 0
            )
        );
        $this->CoursesLesson->save($data);*/

        //$this->loadModel('CoursesLessons');
        //$this->Document->find('all');
    }
}