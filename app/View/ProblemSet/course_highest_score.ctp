<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	The highest score of Course
	<?php echo $course_name; ?>
	of Problemset
	<?php echo $problemset_name; ?>
</h3>

<div style="padding: 10px">
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<thead>
			<th>Student Name</th>
			<th>Score</th>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $result[0]['Users']['title'].' '.$result[0]['Users']['first_name'].' '.$result[0]['Users']['last_name']; ?></td>
				<td><?php echo $result[0]['AssignmentScore']['score']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
