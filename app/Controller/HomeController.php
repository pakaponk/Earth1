<?php

class HomeController extends AppController {
	//test comment for github - ICE
    // Bun
	public $uses = array('User','ContactMessage');
    public $layout = 'home';

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index','about_us','team');

        if(!$this->Auth->user()){
            $this->redirect(array('controller'=>'users','action'=>'login'));
        }

        //if($this->action !== 'index'){
            if($this->Auth->user('role') === 'student'){
                $this->redirect(array(
                    'controller' => 'student',
                    'action'     => 'index'
                ));
            }
            else if($this->Auth->user('role') == 'teacher'){
                $this->redirect(array(
                    'controller' => 'teacher',
                    'action'     => 'index'
                ));
            }
            else if($this->Auth->user('role') == 'admin'){
                $this->redirect(array(
                    'controller' => 'admin',
                    'action'    => 'index'
                ));
            }
            else if($this->Auth->user('role') == 'school_admin'){
                $this->redirect(array(
                    'controller' =>'school_admin',
                    'action'    => 'index'
                ));
            }
       //}
    }

	public function index($id=0,$str=null){
        //pr($id.$str);

        //pr( $this->Session->read('isLogin') );
        //pr( $this->Session->read('username') );
	}

    public function about_us(){}

    public function team(){
        if($this->request->is('post')){
            if ($this->ContactMessage->save($this->request->data)) {
                $this->Session->setFlash('MathBlink will receive you message soon','flash_complete');
                $this->redirect(array(
                    'controller' => 'home',
                    'action'    => 'team'
                ));
            }
        }
    }

}
//test comment

?>
