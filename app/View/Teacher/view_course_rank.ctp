<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Course Ranking of Lesson <?php echo $lesson_name; ?></h3>

<div style="padding: 10px">

<?php 
	if(!empty($top10List)){
		?>
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
				echo '<tr>';

				echo '<td style="width:10%;text-align:center;">';
				echo $i+1;
				echo '</td>';

				echo '<td>';
				echo $top10List[$i]['User']['title'].$top10List[$i]['User']['first_name'].' '.$top10List[$i]['User']['last_name'];

				echo '</td>';

				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
	}else {
		echo '<div class="alert alert-error">';
		echo 'No one has complete all of assignments';
		echo '</div>';
		} ?>
</div>
