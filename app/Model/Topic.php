<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:42 AM
 * To change this template use File | Settings | File Templates.
 */


class Topic extends AppModel{
    public $primaryKey = 'topic_id';
    public $useTable = 'topic';

    public $belongsTo = array(
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'lesson_id'
        )
    );

    var $hasAndBelongsToMany = array(
        'Problem' =>
        array(
            'className'              => 'Problem',
            'joinTable'              => 'topics_problems',
            'foreignKey'             => 'topic_id',
            'associationForeignKey'  => 'problem_id',
            'unique'                 => true,
            'conditions'             => '',
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