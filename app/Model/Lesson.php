<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:41 AM
 * To change this template use File | Settings | File Templates.
 */


class Lesson extends AppModel{
    public $primaryKey = 'lesson_id';
    public $useTable = 'lesson';
    public $displayField = 'lesson_name';
    var $hasMany = array(
        'Topic' => array(
            'className' => 'Topic',
            'dependent'=> true,
        )
    );

    var $hasAndBelongsToMany = array(
        'Course' =>
        array(
            'className'              => 'Course',
            'joinTable'              => 'courses_lessons',
            'foreignKey'             => 'lesson_id',
            'associationForeignKey'  => 'course_id',
            'unique'                 => true,
            'conditions'             => '',
            'fields'                 => '',
            'order'                  => '',
            'limit'                  => '',
            'offset'                 => '',
            'finderQuery'            => '',
            'deleteQuery'            => '',
            'insertQuery'            => ''
        ),
    );


}

?>
