<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li>
        <?php echo $this->Html->link('Problem Set',array(
        'controller' => 'teacher',
        'action' => 'problemset_main')); ?>
        <span class="divider">/</span></li>
    <li>
        <?php echo $this->Html->link($data[0]['ProblemSet']['problemset_name'],array(
        'controller' => 'problemset',
        'action' => 'view' ,
        $data[0]["ProblemSet"]["problemset_id"])); ?>
        <span class="divider">/</span></li>
    </li>
    <li class="active">Edit Problem Set</li>
</ul>

<h3
        style="padding: 10px; margin-left: 50px; margin-right: 50px; border-bottom: 1px solid #e5e5e5">
    Edit Problem set</h3>

<div class="edit problem set form" style="padding: 10px; width: 500px; margin: 0px auto;">
		<?php echo $this->Form->create('ProblemSet');
		$name = $data[0]['ProblemSet']['problemset_name'];
		$guideline = $data[0]['ProblemSet']['guideline'];

		if(!$assigned){ // if problem set isn't released , problem set name can be edited
			echo $this->Form->input('problemset_name',array('value' => $name,
					'style'=>'width:350px;'))."<br/>";
		}else{
			echo $this->Form->input('problemset_name',array('value' => $name,
					'style' => 'width:350px',
					'disabled '=> 'disabled'))."<br/>";
		}
		echo $this->Form->input('guideline',array('type'=>'textarea','value' => $guideline,
				'style'=>'width:350px;height:60px;'))."<br/>";

	echo $this->Form->hidden('user_id', array('value' => $user_id));	?>
	<?php
	echo $this->Form->submit('Edit Problem Set',array(
                    'class' => 'btn btn-primary'
                ));
                ?>
</div>
