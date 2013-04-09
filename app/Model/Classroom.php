<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 19/3/2556
 * Time: 11:03 น.
 * To change this template use File | Settings | File Templates.
 */

/** @noinspection PhpUndefinedClassInspection */
class Classroom extends AppModel{
    public $useTable = 'classrooms';
    //public $displayField = 'room';

    public $virtualFields = array("full_classroom"=>"CONCAT(grade, '/' ,room)");
    public $displayField = 'full_classroom';

    var $hasMany = array(
        'User' => array(
            'className' => 'User',
            'dependent'=> true,
        ),
        'CoursesClassroom' => array(
            'className' => 'CoursesClassroom',
            'dependent'=> true,
        )
    );

    public $validate = array(
        'grade' => array(
            'rule' => 'notEmpty',
            'message' => 'Please fill in a classroom grade'
        ),
        'room' => array(
            'rule' => 'notEmpty',
            'message' => 'Please fill in a classroom name'
        ),
    );

    var $hasAndBelongsToMany = array(
        'Course' =>
        array(
            'className'              => 'Course',
            'joinTable'              => 'courses_classrooms',
            'foreignKey'             => 'classroom_id',
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
        )
    );

}