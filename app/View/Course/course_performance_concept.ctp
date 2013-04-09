<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Performance of Course
	<?php echo $course_name; ?>
	of Concept
	<?php echo $concept_name; ?>
</h3>

<div style="padding: 10px">
	<table class="table table-bordered"
		style="text-align: center; width: 800px;">
		<tbody>
			<tr>
				<td style="text-align: center;">
					<h4>
						Course Performance of Concept
						<?php echo $concept_name; ?>
						:
						<?php echo $scorePercent; ?>%
					</h4>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<div class="progress progress-info progress-striped active">
						<div class="bar" style="width:<?php echo $scorePercent; ?>%;"></div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
