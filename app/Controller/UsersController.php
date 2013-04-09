<?php



class UsersController extends AppController {

    public function index(){
        $this->redirect(array(
            'controller' => 'home',
            'action' => 'index'
        ));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Auth->user()){
            $this->Auth->allow('login','logout','me');
        }else{
            $this->Auth->allow('login','logout','signup');
        }
     }


    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin'
        || ($this->action==='edit_profile') ) {
            return true;
        }

        $this->Session->setFlash('You have no authoritative here','flash_notification');
        return false;
    }



     public function login() {
         $this->layout = 'login';
         if ($this->request->is('post')) {
             if ($this->Auth->login()) {
                $this->redirect(array('controller' => 'home', 'action' => 'index'));
                // $this->redirect($this->Auth->redirect());
                 //$this->redirect($this->Auth->login());
             } else {
                 $this->Session->setFlash(__('Invalid username or password, try again'),"flash_notification");
             }
         }
     }

     public function logout() {
         $this->redirect($this->Auth->logout());
     }



    public function edit_profile(){
        $userData = $this->User->findAllById($this->Auth->user('id'));
        $this->set('data',$userData);

        $this->User->id = $this->Auth->user('id');
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'),'flash_complete');
                $this->redirect(array(
                    'controller' => 'users',
                    'action'    => 'edit_profile'
                ));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->User->read(null, $this->User->id);
            unset($this->request->data['User']['password']);
        }
        //$this->Cake->findAllById(7);
    }

    public function signup(){

    }



     /*public function view($id = null) {
         $this->User->id = $id;
         if (!$this->User->exists()) {
             throw new NotFoundException(__('Invalid user'));
         }
         $this->set('user', $this->User->read(null, $id));
     }*/

     public function add() {
         if ($this->request->is('post')) {
             $this->User->create();
             if ($this->User->save($this->request->data)) {
                 $this->Session->setFlash(__('The user has been saved'));
                 $this->redirect(array('action' => 'index'));
             } else {
                 $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
             }
         }
     }/**/

     /*public function edit($id = null) {
         $this->User->id = $id;
         if (!$this->User->exists()) {
             throw new NotFoundException(__('Invalid user'));
         }
         if ($this->request->is('post') || $this->request->is('put')) {
             if ($this->User->save($this->request->data)) {
                 $this->Session->setFlash(__('The user has been saved'));
                 $this->redirect(array('action' => 'index'));
             } else {
                 $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
             }
         } else {
             $this->request->data = $this->User->read(null, $id);
             unset($this->request->data['User']['password']);
         }
     }

     public function delete($id = null) {
         if (!$this->request->is('post')) {
             throw new MethodNotAllowedException();
         }
         $this->User->id = $id;
         if (!$this->User->exists()) {
             throw new NotFoundException(__('Invalid user'));
         }
         if ($this->User->delete()) {
             $this->Session->setFlash(__('User deleted'));
             $this->redirect(array('action' => 'index'));
         }
         $this->Session->setFlash(__('User was not deleted'));
         $this->redirect(array('action' => 'index'));
     }/**/
}



?>