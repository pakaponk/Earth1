<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Overview of all the courses <span style="float: right"> <a
		class="btn btn-primary"
		href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>
</h3>


<div style="padding: 10px">
	<table class="table table-bordered table-hover" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<tbody>
			<?php
			foreach( $courses as $course ){
        /*$course_id = $course['Course']['course_id'];
        $course_name = $course['Course']['course_name'];
        $course_description = $course['Course']['course_description'];
        $school_id = $course['Course']['school_id'];*/

        $course_id = $course['course_id'];
        $course_name = $course['course_name'];
        $course_description = $course['course_description'];
        $school_id = $course['school_id'];
        $start_date = $course['start_date'];
        $end_date = $course['end_date'];
        //echo '<tr>';
        //echo '<td>'.$course_id.'</td>';
        //echo '<td>'.$course_name.'</td>';
        //echo '<td style="text-align: left;"><h3>'.$course_name.'</h3>'.$course_description.'</td>';
        //echo '<td>'.$school_id.'</td>';
        ?>

         <tr>
      <td style="text-align: left;width: 80%">
          <div style="width: 470px;float: left"><h4><?php echo $course_name ;?></h4>
          <?php echo $course_description ;?></div>

          <span style="width:110px;float: right;padding: 10px;text-align: left">
            <?php if($start_date=="" || $end_date ==""){ ?>
              <span class="label label-important">Please edit <br/>Start/End date</span>
              <?php   }else{?>
              <span class="label label-info">Start <?php echo $start_date ; ?></span>
              <span class="label label-info">End <?php echo $end_date ;?></span>
              <?php } ?>
            </span>
      </td>

           <td><a class="btn" href="<?php echo $this->Html->url('/lesson/index').'/'.$course_id."" ;?>">See Lesson</a>
			<a class="btn"
				href='<?php echo $this->Html->url('/course/edit/'.$course_id);
               ?>'>Edit Course</a><br/>

			<a class="btn"
				href='<?php echo $this->Html->url('/course/del/'.$course_id);
               ?>'
				onclick="return confirm('Are you sure?')">Delete Course</a>


			<?php '</td>';
			echo '</tr>';
    }
    ?>
		</tbody>
	</table>
</div>
