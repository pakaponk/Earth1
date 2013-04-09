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
	<li><?php echo $this->Html->link('Lesson '.$lesson_name,array(
			'controller' => 'topic',
			'action' => 'index',
			$course_id,
			$lesson_id)); ?> <span class="divider">/</span>
	</li>
	<li class="active">Add Topic</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Add new Topic to
	<?php echo $lesson_name; ?>
</h3>
<div class="topic form"
	style="padding: 10px; width: 500px; margin: 0px auto;">
	<?php echo $this->Form->create('Topic'); ?>
	<?php
	echo $this->Form->input('topic_name',array('style'=>'width:350px'));
	echo $this->Form->input('topic_description',array('type' => 'textArea' ,
			'style'=>'width:400px;height:100px;'));
	echo $this->Form->hidden('lesson_id', array('value' => $lesson_id));
	echo $this->Form->hidden('creator_id', array('value' => $creator_id));
 	echo $this->Form->submit(__('Submit'),array('class' => 'btn btn-primary')); ?>
</div>
