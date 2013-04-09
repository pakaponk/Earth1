<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Create Classroom</h3>

<div style="padding: 10px;width: 700px;margin: 0px auto">
    <?php
    echo $this->Form->create();
    echo $this->Form->input('grade');
    echo $this->Form->input('room');
    echo $this->Form->input('start_date',array('style'=>'width:120px'));
    echo $this->Form->input('end_date',array('style'=>'width:120px'));
    echo $this->Form->end('Save');
    ?>
</div>