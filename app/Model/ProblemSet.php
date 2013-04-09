<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:34 AM
 * To change this template use File | Settings | File Templates.
 */
class ProblemSet extends AppModel{
    public $primaryKey = 'problemset_id';
    public $useTable = 'problemset';
    public $validate = array(
        'problemset_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A Name is required'
            )
        ),
        'guideline' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Guideline is required'
            )
        )
    );

    public $hasMany = array(
        'Assignment' => array(
            'className' => 'Assignment',
            'dependent' => true
        ),
        'ProblemsetsProblem' => array(
            'className' => 'ProblemsetsProblem',
            'dependent' => true
        )
    );

    public $belongsTo = array(
        'Teacher' => array(
            'foreignKey' => 'user_id'
        ),
        'Course' => array(
            'foreignKey' => 'course_id'
        )
    );

    public function beforeSave($options = array()) {
    }
}

?>