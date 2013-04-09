<?php



App::uses('AuthComponent', 'Controller/Component');
App::uses('Security','Utility');


class User extends AppModel{

    public $useTable = 'user';
    //public $primaryKey = 'user_id';

    /*public $hasMany = array(
        'StudentsAssignment' => array(
            'className' => 'StudentsAssignment',
            'dependent' => true)
    );*/

    public $belongsTo = array(
        'Classroom'
    );

   public $hasMany = array(
        'AssignmentScore' => array(
            'className' => 'AssignmentScore',
            'dependent' => true,
            'foreignKey' => 'student_id'
        ));

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'first_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A firstname is required'
            )
        )
        /*,
         'email' => array(
                 'valid' => array(
                         'rule'	=> 'email';
                 )
         ),
'password' => array(
        'valid' => array(
                'rule'	=> array('between', 5, 10);
        )
),
'role' => array(
        'valid' => array(
                'rule' => array('inList', array('admin', 'school_admin','student','teacher')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
        )
)*/
    );


    public function beforeSave($options = array()){
        $this->data['User']['password'] = Security::hash( $this->data['User']['password'] , 'sha1' , true );
        return true;
    }




    /*
     public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
    $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
    }*/
}

?>