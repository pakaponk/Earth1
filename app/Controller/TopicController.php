<?php

class TopicController extends AppController{

    public $uses = array('Lesson','Course','Topic','Concept','Technique','Problem','ProblemLevel','TopicsProblem');

    public function index($course_id,$lesson_id){
        $this->set('lesson',$this->Lesson->findAllByLesson_id($lesson_id));
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);$lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_name',$lesson_name);
    }

    public function add($course_id,$lesson_id){
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_id',$lesson_id);
        $this->set('lesson_name',$lesson_name);
        $this->set('creator_id',$this->Auth->user('id'));
        if( $this->request->is('post') ){
            //Get School id from user
            $this->Topic->create();
            if ($this->Topic->save($this->request->data)) {
                $this->Session->setFlash(__('The topic has been saved'),'flash_complete');
                $this->redirect('/topic/index/'.$course_id.'/'.$lesson_id);
            } else {
                $this->Session->setFlash(__('The topic could not be saved. Please, try again.'),'flash_notification');
            }
        }
    }

    public function edit($course_id,$topic_id,$lesson_id){
        $topicData = $this->Topic->findAllByTopicId($topic_id);
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_id',$lesson_id);
        $this->set('lesson_name',$lesson_name);
        $this->set('data',$topicData);
        $this->set('creator_id',$this->Auth->user('id'));

        $this->Topic->id = $topic_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Topic->save($this->request->data)) {
                $this->Session->setFlash(__('The topic has been saved'),'flash_complete');
                $this->redirect('/topic/index/'.$course_id.'/'.$lesson_id);
            } else {
                $this->Session->setFlash(__('The topic could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->Topic->read(null, $this->Topic->id);
        }
    }

    public function del($topic_id){
        $this->Topic->delete($topic_id);
        $this->Session->setFlash(__('The topic has been delete'),'flash_complete');
        $this->redirect($this->referer());
    }

    public function view($course_id,$topic_id){
        $arr = $this->Topic->findByTopicId($topic_id);
        $course = $this->Course->findByCourseId($course_id);
        $concept = $this->Concept->find('list');
        $technique = $this->Technique->find('list');
        $all_problem = $this->ProblemLevel->Problem->find('all') ;
        $problem_arr = $arr["Problem"];
        $problem_id = array();
        for($i=0;$i<count($problem_arr);$i++){
            $problem_id[$i] = $problem_arr[$i]["problem_id"];
        }

       $topic_problem = $this->ProblemLevel->Problem->find('all',
       array(
                  'conditions' => array(
                    "Problem.problem_id" => $problem_id )
                  )
       );

        $this->set('topic_problem',$topic_problem);
        $this->set('data',$arr);
        $this->set('course_data',$course);
        $this->set('concept_list',$concept);
        $this->set('technique_list',$technique);

        if($this->request->is('post')){
            $this->Topic->save($this->request->data);
            $this->redirect($this->referer());
        }
    }

    public function get_problem_to_topic($type,$id = -1){
        //$this->autoRender = false ;
        $this->Technique->recursive = 2 ;
        $this->Concept->recursive = 2 ;
       //pr($this->ProblemLevel->Problem->Technique->find('all'));
        $data = array();
        if($id !== -1){
            if($type==0){
                $data = $this->ProblemLevel->Problem->Technique->findByTechniqueId($id);
            }elseif($type==1){
                $data = $this->ProblemLevel->Problem->Concept->findByConceptId($id);
            }
            $data = $data["Problem"];
        }
        $this->set('problem',$data);

        //pr($data["Problem"]);
    }

    public function save_problem_to_topic($topic_id,$problem_id,$problem_status){
        $this->autoRender = false ;
        //pr($problem_id);
        //pr($problem_status);

        $problem_id_array = explode(";",$problem_id);
        $problem_status_array = explode(";",$problem_status);

        $conditions = array (
            "TopicsProblem.topic_id" => $topic_id,
        );

        $this->TopicsProblem->deleteAll($conditions);

        $len = count($problem_id_array);
        for($i=0;$i<$len;$i++){
            if($problem_status_array[$i] == "add"){
                $saveData = array(
                    'id' =>'',
                    'topic_id'        => $topic_id,
                    'problem_id'        => $problem_id_array[$i]
                );
                $this->TopicsProblem->save($saveData);
            }
        }

    }

    public function beforeRender(){
        parent::beforeRender();
        $auth = $this->Auth->user('role');
        $this->set('auth',$auth);
    }

}

?>