<?php


class ProblemController extends AppController{
   // public $scaffold ;
    public $uses = array('Problem','ProblemLevel','ProblemDataSet');

    public $layout = 'default' ;
    public function index(){
        pr($this->Problem->find('all'));
        //debug($this->Problem->find('all'));
    }
}



?>