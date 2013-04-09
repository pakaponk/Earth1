
<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Add Student to Classroom</h3>

<div style="padding: 10px;width: 500px;margin: 0px auto;">
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->input('email');
    $options = array('Mr.' => 'Mr.','Ms.' => 'Ms.', 'Mrs.' => 'Mrs.');
    echo $this->Form->label('Title');
    echo $this->Form->select('title',$options, array('default' => 'Mr.'));
    echo $this->Form->input('first_name');
    echo $this->Form->input('middle_name');
    echo $this->Form->input('last_name');
    echo $this->Form->end('Add Student');
    ?>
</div>