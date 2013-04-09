<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:34 AM
 * To change this template use File | Settings | File Templates.
 */

class Unit extends AppModel{
    public $primaryKey = 'unit_id';
    public $useTable = 'unit';
    //var $hasMany = 'Technique';

    public $hasMany = array(
        'Technique' => array(
            'className' => 'Technique',
            'foreignKey' => 'unit_id',
        ),
        'Concept' => array(
            'className' => 'Concept',
            'foreignKey' => 'unit_id',
        )
    );

}

?>