<?php

class AssignmentScore extends AppModel{

    public $useTable = 'assignment_score';
    public $primaryKey = 'assignment_score_id';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'student_id'
        ),
        'Assignment' => array(
            'className' => 'Assignment',
            'foreignKey' => 'assignment_id'
        )
    );
}

?>