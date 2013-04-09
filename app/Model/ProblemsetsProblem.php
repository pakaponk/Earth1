<?php

class ProblemsetsProblem extends AppModel {

	public $useTable = 'problemsets_problems';
	public $primaryKeyArray = array('student_id','assignment_id','problem_order');
	public $primaryKey = 'problemset_problem_id';

    /*public $hasMany = array(
        'StudentsAssignment' => array(
            'className' => 'StudentsAssignment' ,
            'dependent' => true)
    );*/

    public $belongsTo = array(
			'ProblemSet' => array(
					'className' => 'ProblemSet',
					'foreignKey' => 'problemset_id'
			),
			'Problem' => array(
					'className' => 'Problem',
					'foreignKey' => 'problem_id'
			),
			'ProblemLevel' => array(
					'className' => 'ProblemLevel',
					'foreignKey' => 'problem_level_id'
			)
	);

}

?>