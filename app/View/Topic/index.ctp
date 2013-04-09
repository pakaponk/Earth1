<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
			'action' => 'index')); ?> <span class="divider">/</span></li>
	<li><?php echo $this->Html->link('Course '.$course_name,array(
			'controller' => 'lesson',
			'action' => 'index',
			$course_id)); ?> <span class="divider">/</span></li>
	<li class="active"><?php echo 'Lesson '.$lesson_name; ?></li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Overview of Topics of
	<?php echo $lesson[0]['Lesson']['lesson_name']; ?>
	Lesson <span style="float: right"> <a class="btn btn-primary"
		href='<?php echo $this->html->url(array(
                       'controller' => 'topic' ,
                       'action' => 'add'
                   )).'/'.$course_id.'/'.$lesson[0]['Lesson']['lesson_id']; ?>'>Add
			Topic</a>
	</span>
</h3>
<div style="padding: 10px">
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">

		<?php
		foreach( $lesson[0]['Topic'] as $topic ){
		$topic_id = $topic['topic_id'];
		$topic_name = $topic['topic_name'];
		$topic_description = $topic['topic_description'];
		$creator_id = $topic['creator_id'];
            $start_date = $topic['start_date'];
            $end_date = $topic['end_date'];
?>
		<tr>
		<td width="80%">
            <div style="float:left;width: 470px"><h4><?php echo $topic_name ;?></h4>
            <?php echo $topic_description;?></div>
            <span style=" width:100px;float:right;padding: 10px">
                <?php if($start_date=="" || $end_date ==""){ ?>
                <span class="label label-important">Please edit <br/>Start/End date</span>
                <?php   }else{?>
                <span class="label label-info">Start <?php echo $start_date ; ?></span>
                <span class="label label-info">End <?php echo $end_date ;?></span>
                <?php } ?>
            </span>
        </td>
		<td>
		<a class="btn"
			href='<?php echo $this->html->url('/topic/edit/'.$course_id.'/'.$topic_id.'/'.$lesson[0]['Lesson']['lesson_id']);
		?>'>Edit Topic</a>
		<a class="btn"
			href='<?php echo $this->html->url('/topic/del/'.$topic_id);
		?>'
			onclick="return confirm('Are you sure?')">Delete Topic</a>
		<?php '</td>';
		echo '</tr>';
	}
	?>
	</table>
</div>
