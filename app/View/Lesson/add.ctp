<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
			'action' => 'index')); ?> <span class="divider">/</span>
	</li>
	<li><?php echo $this->Html->link('Course '.$course_name,array(
			'controller' => 'lesson',
			'action' => 'index',
			$course_id)); ?> <span class="divider">/</span>
	</li>
	<li class="active">Add Lesson</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Add new Lesson to
	<?php echo $course_name; ?>
</h3>

<div class="lesson form"
	style="padding: 10px; width: 500px; margin: 0px auto;">
	<?php echo $this->Form->create('Lesson'); ?>
	<?php

	echo $this->Form->input('lesson_name',array('style'=>'width:350px'));
	echo $this->Form->input('lesson_description',array('type' => 'textArea' ,
				'style'=>'width:400px;height:100px;'));
		echo $this->Form->hidden('creator_id', array('value' => $creator_id));
		?>
	<?php echo $this->Form->submit(__('Add new Lesson'),array('class' => 'btn btn-primary')); ?>
</div>
