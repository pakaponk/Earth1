<?php

class TeacherCourse extends AppModel{

    public $useTable = 'teachers_courses';
    public $primaryKey = 'teacher_course_id';

    public $belongsTo = array(
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
        ),
        'Teacher' => array(
            'className' => 'Teacher',
            'foreignKey' => 'teacher_id',
        ));

}

?>