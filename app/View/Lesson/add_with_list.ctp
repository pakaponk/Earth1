<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
  		'action' => 'index')); ?> <span class="divider">/</span></li>
	<li><?php echo $this->Html->link('Course '.$course_name,array(
			'controller' => 'lesson',
			'action' => 'index',
			$course_id)); ?> <span class="divider">/</span></li>
	<li class="active">Add Exist Lesson</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Add exist Lesson</h3>

<div class="lesson form"
	style="padding: 10px; width: 500px; margin: 0px auto;">
	<?php echo $this->Form->create('Lesson'); ?>
	<?php 
	echo $this->Form->input('lesson_id',array('type'=>'select',
				'options' => $lesson_list,
				'label' => 'Lesson',
				'style'=>'width:350px;'));
		?>
	</fieldset>
	<?php echo $this->Form->submit(__('Add Lesson'),array('class' => 'btn btn-primary')); ?>
</div>
