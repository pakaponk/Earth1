<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/17/13 AD
 * Time: 8:50 PM
 * To change this template use File | Settings | File Templates.
 */

class AdminController extends AppController{

    public $layout ='admin';

    public function index(){

    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin' ) {
            return true;
        }
        //$this->Session->setFlash('You have no authoritative here','flash_notification');
        return false;
    }

    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function login(){
        pr("please login first");
    }
}