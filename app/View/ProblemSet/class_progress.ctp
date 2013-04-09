<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Class <?php echo $classroom_name; ?> Progress of Problemset
	<?php echo $problemset_name; ?>
</h3>

<div style="padding: 10px">
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<thead>
			<th>Assignment Complete : <?php echo $result[0][0]['assignment_complete'].' / '.$result2[0][0]['total_assignment']; ?></th>
		</thead>
		<tbody>
			<tr>
				<td><div class="progress progress-info progress-striped active">
						<div class="bar" style="width:<?php echo $result[0][0]['assignment_complete']*100/$result2[0][0]['total_assignment']; ?>%;"></div></td>
			</tr>
		</tbody>
	</table>
</div>