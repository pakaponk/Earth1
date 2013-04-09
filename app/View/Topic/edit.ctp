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
	<li class="active">Edit Topic</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Edit Topic</h3>
<div class="edit topic form"
	style="padding: 10px; width: 500px; margin: 0px auto;">
	<?php echo $this->Form->create('Topic'); ?>
	<?php
	$name = $data[0]['Topic']['topic_name'];
	$description = $data[0]['Topic']['topic_description'];

	echo $this->Form->input('topic_name',array('value' => $name,
			'style'=>'width:400px;'));

	echo $this->Form->input('topic_description',array('value' => $description,
				'type' => 'textArea' ,
				'style'=>'width:400px;height:100px;'));

    echo $this->Form->input('start_date');
    echo $this->Form->input('end_date');
		echo $this->Form->hidden('creator_id', array('value' => $creator_id));	?>
	<?php
	echo $this->Form->submit('Edit Topic',array(
                    'class' => 'btn btn-primary'
                ));
                ?>
</div>
