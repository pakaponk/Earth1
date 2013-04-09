<?php

class Assignment extends AppModel {
	
	public $useTable = 'assignment';
	public $primaryKeyArray = array('problemset_id','school_id');
	public $primaryKey = 'id';

    public $hasMany = array(
        'AssignmentScore' => array(
            'className' => 'AssignmentScore',
            'dependent' => true
        ));

	public $belongsTo = array(
			'ProblemSet' => array(
					'className' => 'ProblemSet',
					'foreignKey' => 'problemset_id'
			),
            'Classroom' => array(
                    'className' => 'Classroom',
                    'foreignKey' => 'classroom_id'
            )
	);
	
}

?>