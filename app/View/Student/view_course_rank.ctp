<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><a href="<?php echo $this->Html->url('/student/leaderboard'); ?>">Leaderboard</a> <span class="divider">/</span></li>
	<li class="active">Course Ranking by Lesson <?php echo $lesson_name; ?></li>
</ul>
<h3
        style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Course Ranking of Lesson <?php echo $lesson_name; ?>
</h3>

<div style="padding: 10px">
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<thead>
			<th style="text-align:center;">Rank No.</th>
			<th>Student Name</th>
		</thead>
		<tbody>
			<?php 
			$length = count($top10List);
			for($i=0;$i<$length;$i++){
				if($top10List[$i]['User']['student_id'] == $student_id){
					echo '<tr class="alert-success">';
					echo '<td style="width:10%;text-align:center;">';
					echo $i+1;
					echo '</td>';
				
					echo '<td>';
					echo $top10List[$i]['User']['title'].$top10List[$i]['User']['first_name'].' '.$top10List[$i]['User']['last_name'];
					echo '<span class="label label-success pull-right">Your Rank</span>';
				
					echo '</td>';
				
					echo '</tr>';
				}else{
					echo '<tr>';
				
					echo '<td style="width:10%;text-align:center;">';
					echo $i+1;
					echo '</td>';
				
					echo '<td>';
					echo $top10List[$i]['User']['title'].$top10List[$i]['User']['first_name'].' '.$top10List[$i]['User']['last_name'];
	
					echo '</td>';
				
					echo '</tr>';
				}
			}
				if(!$beTop10){
					echo '<tr class="alert alert-block">';
					echo '<td style="width:10%;text-align:center;">';
					echo $student[0]['Student']['rank'];
					echo '</td>';
				
					echo '<td>';
					echo $student[0]['Student']['title'].$student[0]['Student']['first_name'].' '.$student[0]['Student']['last_name'];
					echo '<span class="label label-important pull-right">Your Rank</span>';
					echo '</td>';
				
					echo '</tr>';
				}
			?>
		</tbody>
	</table>
	<?php
		if(!$complete_assignment){
			echo '<div class="alert alert-error" style="margin-top:20px;">';
			echo 'You\'re not complete any assignments';
			echo '</div>';
		} ?>
</div>
