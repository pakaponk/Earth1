<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun Suwanparsert
 * Date: 3/15/13 AD
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */


class ProblemLevel extends AppModel{
    public $useTable ='problem_levels';
    public $primaryKey = 'problem_level_id';
    var $hasMany = array(
        'ProblemDataSet' => array(
            'className' => 'ProblemDataSet',
            'dependent' => true
        ),
        'ProblemsetsProblem' => array(
            'className' => 'ProblemsetsProblem',
            'dependent' => true)
    );

    public $belongsTo = array(
        'Problem' => array(
            'className' => 'Problem',
            'foreignKey' => 'problem_id'
        )
    );

}