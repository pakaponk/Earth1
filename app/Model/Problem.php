<?php


class Problem extends AppModel{
    public $primaryKey = 'problem_id'; // example_id is the field name in the database
    //public $hasMany = 'Problem_level';
    public $hasMany = array(
        'ProblemLevel' => array(
            'className' => 'ProblemLevel',
            'dependent'=> true
        ),
        'ProblemsetsProblem' => array(
            'className' => 'ProblemsetsProblem',
            'dependent' => true
        )
    );
    var $hasAndBelongsToMany = array(
        'Topic' =>
        array(
            'className'              => 'Topic',
            'joinTable'              => 'topics_problems',
            'foreignKey'             => 'problem_id',
            'associationForeignKey'  => 'topic_id',
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
        'Technique' =>
        array(
            'className'              => 'Technique',
            'joinTable'              => 'problems_tags',
            'foreignKey'             => 'problem_id',
            'associationForeignKey'  => 'tag_id',
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
        'Concept' =>
        array(
            'className'              => 'Concept',
            'joinTable'              => 'problems_tags',
            'foreignKey'             => 'problem_id',
            'associationForeignKey'  => 'tag_id',
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