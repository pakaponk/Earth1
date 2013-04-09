<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
			'action' => 'index')); ?> <span class="divider">/</span>
	</li>
	<li class="active"><?php echo 'Course '.$course_name; ?>
	</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	<?php echo $course[0]['Course']['course_name']; ?>
	Course
    <?php if($user_role === 'school_admin') { ?>
    <span style="float: right"> <a class="btn btn-primary "
		href='<?php echo $this->html->url(array(
        'controller' => 'lesson' ,
        'action' => 'add'
    )).'/'.$course[0]['Course']['course_id']; ?>'>Add new lesson</a> <a
		class="btn"
		href='<?php echo $this->html->url(array(
            'controller' => 'lesson' ,
            'action' => 'addWithList'
        )).'/'.$course[0]['Course']['course_id']; ?>'>Add exist lesson</a>
	</span>
        <?php } ?>
</h3>

<div style="padding: 10px">

	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<?php
		foreach( $course[0]['Lesson'] as $lesson ){
		$lesson_id = $lesson['lesson_id'];
		$lesson_name = $lesson['lesson_name'];
		$lesson_description = $lesson['lesson_description'];
		$creator_id = $lesson['creator_id'];
        $start_date = $lesson['start_date'];
            $end_date = $lesson['end_date'];
        ?>
	    <tr>
		<td width="80%">
            <div style="width: 470px;float: left"><h4><?php echo $lesson_name ;?></h4>
                <?php echo $lesson_description; ?></div>

            <span style="width:110px;float: right;padding: 10px;text-align: left">
            <?php if($start_date=="" || $end_date ==""){ ?>
                <span class="label label-important">Please edit <br/>Start/End date</span>
            <?php   }else{?>
                <span class="label label-info">Start <?php echo $start_date ; ?></span>
                <span class="label label-info">End <?php echo $end_date ;?></span>
            <?php } ?>
            </span>

        </td>
        <td><a class="btn btn" href="<?php echo $this->html->url('/topic/index').'/'.$course_id.'/'.$lesson_id ; ?>
">See Topic</a>

            <a class="btn"
			href='<?php echo $this->html->url('/lesson/edit/'.$lesson_id.'/'.$course[0]['Course']['course_id']);
				?>'>Edit Lesson</a>
		<a class="btn"
			href='<?php echo $this->html->url('/lesson/del/'.$lesson_id.'/'.$course[0]['Course']['course_id']);
				?>'
			onclick="return confirm('Are you sure?')">Delete Lesson</a>
		<?php '</td>';
		echo '</tr>';
	}
	?>
	</table>
</div>
