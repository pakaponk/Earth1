<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 3:04 PM
 * To change this template use File | Settings | File Templates.
 */

class ProblemLevelController extends AppController{
    public function index(){
        $this->redirect(array(
            'controller' => 'Home',
            'action'    => 'index'
        ));
        //pr($this->ProblemLevel->find('all'));
    }
}

?>