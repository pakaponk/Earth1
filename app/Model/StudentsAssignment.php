<?php

class StudentsAssignment extends AppModel {

	public $useTable = 'students_assignments';
	public $primaryKeyArray = array('student_id','assignment_id','problem_order');
	public $primaryKey = 'student_assignment_id';

    public $belongsTo = array(
        'ProblemDataSet' => array(
            'className' => 'ProblemDataSet' ,
            'foreignKey' => 'problem_level_dataset_id'
        ),
        'ProblemLevel' => array(
            'className' => 'ProblemLevel' ,
            'foreignKey' => 'problem_level_id')
    );
}

?>