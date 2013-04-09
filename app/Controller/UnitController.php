<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:32 AM
 * To change this template use File | Settings | File Templates.
 */

class UnitController extends AppController{
    public $primaryKey = 'unit_id';

    public function index(){
        pr($this->Unit->find('all'));
    }
}

?>