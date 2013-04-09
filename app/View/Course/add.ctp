<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
  		'action' => 'index')); ?> <span class="divider">/</span></li>
	<li class="active">Add Course</li>
</ul>
<h3
        style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Add new Course
</h3>

<div class="course form" style="padding: 10px;width:500px;margin: 0px auto;">
    <?php echo $this->Form->create('Course'); ?>
        <?php echo $this->Form->input('course_id');
        echo $this->Form->input('course_name',array('style'=>'width:350px'));
        echo $this->Form->input('course_description',array('type' => 'textArea' ,
            'style'=>'width:400px;height:100px;'));
        echo $this->Form->hidden('school_id', array('value' => $school_id));
        ?>
    <?php echo $this->Form->submit(__('Add Course'),array('class' => 'btn btn-primary'));
    ?>
</div>
