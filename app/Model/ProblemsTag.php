<?php


class ProblemsTag extends AppModel{
	public $useTable = 'problems_tags';
    public $primaryKey = 'problem_tag_id'; // example_id is the field name in the database
    //public $hasMany = 'Problem_level';
	var $belongTo = array(
			'Concept' => array(
					'className' => 'Concept',
					'foreignKey' => 'tag_id')
			,
			'Technique' => array(
					'className' => 'Technique',
					'foreignKey' => 'tag_id')
			);
}

?>