<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
  		'action' => 'index')); ?> <span class="divider">/</span></li>
	<li class="active">Edit Course</li>
</ul>
<h3
        style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Edit Course
</h3>

<div class="edit course form" style="padding: 10px;width:500px;margin: 0px auto;">
        <?php echo $this->Form->create('Course'); ?>
        <?php
        $name = $data[0]['Course']['course_name'];
        $description = $data[0]['Course']['course_description'];

        echo $this->Form->input('course_name',array('value' => $name,
            'style'=>'width:350px;'));

        echo $this->Form->input('course_description',array('value' => $description,
            'style'=>'width:400px;height:100px;' ,
            'type' => 'textArea'));

        echo $this->Form->hidden('school_id', array('value' => $school_id));
        echo $this->Form->input('start_date');
        echo $this->Form->input('end_date');
    ?>

    <?php
    echo $this->Form->submit('Edit Course',array(
        'class' => 'btn btn-primary',
        'title' => 'Send message'
    ));
    ?>
    <?php
    echo $this->Form->end();
    ?>
</div>