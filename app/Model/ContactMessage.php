<?php


class ContactMessage extends AppModel{
    public $useTable ='contact_message' ;
    public $validate = array(
         'name' => array(
             'required' => array(
                 'rule' => array('notEmpty'),
                 'message' => 'Name is required'
             )
         ),
         'email' => array(
             'required' => array(
                 'rule' => array('email','notEmpty'),
                 'message' => 'Invalid email'
             )
         ),
         'message' => array(
             'required' => array(
                 'rule' => array('notEmpty'),
                 'message' => 'Message is required'
             )
         )
    );
}

?>