<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:34 AM
 * To change this template use File | Settings | File Templates.
 */

class Technique extends AppModel{
    public $primaryKey = 'technique_id';
    public $useTable = 'technique';
    public $displayField = 'technique_name';
    public $belongsTo = 'Unit';

    public $hasAndBelongsToMany = array(
        'Problem' =>
        array(
            'className'              => 'Problem',
            'joinTable'              => 'problems_tags',
            'foreignKey'             => 'tag_id',
            'associationForeignKey'  => 'problem_id',
            'unique'                 => true,
            'conditions'             => array('ProblemsTag.type' => 0),
            'fields'                 => '',
            'order'                  => '',
            'limit'                  => '',
            'offset'                 => '',
            'finderQuery'            => '',
            'deleteQuery'            => '',
            'insertQuery'            => ''
        )
    );
}

?>