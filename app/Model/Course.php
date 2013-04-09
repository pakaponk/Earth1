<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:41 AM
 * To change this template use File | Settings | File Templates.
 */

class Course extends AppModel{
    public $primaryKey = 'course_id';
    public $useTable = 'course';
    public $displayField = 'course_name';

    public $hasMany = array(
        'CoursesClassroom' => array(
            'className' => 'CoursesClassroom',
            'dependent'=> true,
        ),
        'TeacherCourse' => array(
            'className' => 'TeacherCourse',
            'dependent' => true
        )
    );


    var $hasAndBelongsToMany = array(
        'Lesson' =>
        array(
            'className'              => 'Lesson',
            'joinTable'              => 'courses_lessons',
            'foreignKey'             => 'course_id',
            'associationForeignKey'  => 'lesson_id',
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
        'User' =>
        array(
            'className'              => 'User',
            'joinTable'              => 'teachers_courses',
            'foreignKey'             => 'course_id',
            'associationForeignKey'  => 'teacher_id',
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
        'Classroom' =>
        array(
            'className'              => 'Classroom',
            'joinTable'              => 'courses_classrooms',
            'foreignKey'             => 'course_id',
            'associationForeignKey'  => 'classroom_id',
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
