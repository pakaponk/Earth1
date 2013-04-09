<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 2:55 PM
 * To change this template use File | Settings | File Templates.
 */

class ProblemDataSet extends AppModel{
    public $primaryKey = 'problem_level_dataset_id';
    public $useTable = 'level_datasets' ;
    public $belongsTo = array(
        'ProblemLevel' => array(
            'className' => 'ProblemLevel',
            'foreignKey' => 'problem_level_id'
        )
    );
}