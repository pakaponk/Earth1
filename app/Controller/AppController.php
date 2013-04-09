<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime','Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		/*'DebugKit.Toolbar',*/
        'Session',
        'RequestHandler',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'home', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
            'authorize' => array('Controller') ,
            'fields'	=> array('username' => 'username','password' => 'password'),
            'userModel'	=> 'User'
        )
    );

    public $helpers = array('Javascript', 'Ajax','Js' => array('Jquery'),'Time');

    public $layout = 'main';

    public function beforeFilter(){
        parent::beforeFilter();

        $userArr = $this->Auth->user();
        $this->set('profile_data',$userArr);

        if( $this->Auth->user('role') === 'school_admin'){
            $this->layout = 'school_admin';
        }
        else if($this->Auth->user('role') ==='teacher'){
            $this->layout = 'teacher';
        }
        else if($this->Auth->user('role') ==='student'){
            $this->layout = 'student';
        }
    }

    public function isAuthorized($user) {
        // Admin can access every action
        return true ;

        // Default deny
        //return false;
    }

    
}
