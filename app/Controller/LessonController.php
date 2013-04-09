<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 2:20 PM
 * To change this template use File | Settings | File Templates.
 */

class LessonController extends AppController{

    public $uses = array('Lesson','Course','Topic','CoursesLesson');

    public function index($course_id){

        /*$data = array(
         'CoursesLesson' => array(
                 'course_id' => 3 ,
                 'lesson_id' => 2
         )
        );*/

        //$this->CoursesLesson->save($data);
        $this->set('course',$this->Course->findAllByCourse_id($course_id));
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $this->set('user_role',$this->Auth->user('role'));
    }

    public function add($course_id){
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $this->set('creator_id',$this->Auth->user('id'));
        if( $this->request->is('post') ){
            //Get School id from user
            $this->Lesson->create();
            if ($this->Lesson->save($this->request->data)) {
                $lesson_id = $this->Lesson->getLastInsertID();
                $data = array(
                    'CoursesLesson' => array(
                        'course_id' => $course_id ,
                        'lesson_id' => $lesson_id
                    )
                );
                $this->CoursesLesson->save($data);
                $this->Session->setFlash(__('The lesson has been saved'));
                $this->redirect('/lesson/index/'.$course_id);
            } else {
                $this->Session->setFlash(__('The lesson could not be saved. Please, try again.'));
            }
        }
    }

    public function addWithList($course_id){
        if( $this->request->is('post') ){
            $lesson_id = $this->request->data['Lesson']['lesson_id'];
            $dataArr = array(
                'CoursesLesson' => array(
                    'course_id' => $course_id ,
                    'lesson_id' => $lesson_id
                )
            );
            $this->CoursesLesson->create();
            //debug($course_id." ".$lesson_id);
            if($this->CoursesLesson->save($dataArr)){
                $this->Session->setFlash(__('The lesson has been saved'));
                $this->redirect('/lesson/index/'.$course_id);
            }else{

            }
        }else{
            $courseData = $this->Course->findByCourseId($course_id);
            $course_name = $courseData['Course']['course_name'];
            $this->set('course_id',$course_id);
            $this->set('course_name',$course_name);
            $this->set('creator_id',$this->Auth->user('id'));

            ///////////////////////////////////////////////////////////////////////////////
            /////////////////// Select List of Lesson that not in courses_lessons /////////
            ///////////////////////////////////////////////////////////////////////////////
            $conditionsSubQuery['CoursesLesson.course_id'] = $course_id;
            $db = $this->Lesson->getDataSource();
            $subQuery = $db->buildStatement(
                array(
                    'fields'     => array('CoursesLesson.lesson_id'),
                    'table'      => $db->fullTableName($this->CoursesLesson),
                    'alias'      => 'CoursesLesson',
                    'limit'      => null,
                    'offset'     => null,
                    'joins'      => array(),
                    'conditions' => $conditionsSubQuery,
                    'order'      => null,
                    'group'      => null
                ),
                $this->Lesson
            );
            $subQuery = ' Lesson.lesson_id NOT IN (' . $subQuery . ') ';
            $subQueryExpression = $db->expression($subQuery);
            $conditions[] = $subQueryExpression;
            $this->set('lesson_list',$this->Lesson->find('list', compact('conditions')));
        }
    }

    public function edit($lesson_id,$course_id){
        $lessonData = $this->Lesson->findAllByLessonId($lesson_id);
        $courseData = $this->Course->findByCourseId($course_id);
        $course_name = $courseData['Course']['course_name'];
        //$start = explode("-",$courseData['Course']['start_date']);
        //$end = explode()
        $this->set('course_id',$course_id);
        $this->set('course_name',$course_name);
        $this->set('data',$lessonData);
        $this->set('creator_id',$this->Auth->user('id'));

        $this->Lesson->id = $lesson_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Lesson->save($this->request->data)) {
                $this->Session->setFlash(__('The lesson has been saved'),'flash_complete');
                $this->redirect('/lesson/index/'.$course_id);
            } else {
                $this->Session->setFlash(__('The lesson could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->Lesson->read(null, $this->Lesson->id);
        }
    }

    public function del($lesson_id,$course_id){
        $this->CoursesLesson->deleteAll(array('lesson_id' => $lesson_id,"course_id" => $course_id));
        //$this->Lesson->delete($lesson_id,true);
        $this->Session->setFlash(__('The lesson has been deleted'),'flash_complete');
        $this->redirect($this->referer());
    }

    public function view($course_id,$lesson_id){
        $arr = $this->Lesson->findByLessonId($lesson_id);
        $course = $this->Course->findByCourseId($course_id);
        $this->set('data',$arr);
        $this->set('course_data',$course);
        if($this->request->is('post')){
            $this->Lesson->save($this->request->data);
            $this->redirect($this->referer());
        }
        //pr($course);
    }

    public function beforeRender(){
        parent::beforeRender();
        $auth = $this->Auth->user('role');
        $this->set('auth',$auth);
    }

}