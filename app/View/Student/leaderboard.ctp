<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Leaderboard</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 30/3/2556
 * Time: 10:45 น.
 * To change this template use File | Settings | File Templates.
 */
?>

<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <div id="left">
    <div id="headerText"><h5><i class="icon-road"></i>Leader Board - Classroom <?php echo $profile_data['classroom_id']?></h5></div>
        <table class="table table-hover" id="rank">
            <thead>
                <th>No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Score</th>
            </thead>

            <tbody>
                <?php
                    $classroom_num = count($leaderboard['List']);
                    for ($i=0;$i<$classroom_num;$i++):
                ?>
                    <?php if($leaderboard['List'][$i]['User']['student_id'] == $leaderboard['Student']['student_id']): ?>
                        <tr bgcolor="#fafad2">
                            <td><strong><?php echo $i+1 ?><strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i]['User']['first_name'] ?></strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i]['User']['last_name']; ?></strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i][0]['total_score']; ?></strong></td>
                        </tr>
                    <?php endif ?>
                    <?php if ($leaderboard['List'][$i]['User']['student_id'] != $leaderboard['Student']['student_id']): ?>
                        <tr bgcolor="#FBFBFB">
                            <td><strong><?php echo $i+1 ?><strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i]['User']['first_name'] ?></strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i]['User']['last_name']; ?></strong></td>
                            <td><strong><?php echo $leaderboard['List'][$i][0]['total_score']; ?></strong></td>
                        </tr>
                    <?php endif ?>
                <?php endfor ?>
            </tbody>
        </table>
    </div>
    
    <div id="right">
		<div>
		<table class="table table-hover">
			<thead>
				<div id="headerText" style="padding:2px;padding-left:5px;"><h5>Rank by Lesson</h5></div>
            </thead>
            <tbody>
			<?php for($i=0;$i<count($lesson_list);$i++){ ?>
				<tr>
					<td><strong><?php echo $lesson_list[$i]['Lesson']['lesson_name']; ?></strong><span class="pull-right"><a href="<?php echo $this->Html->url('/student/view_class_rank/'.$lesson_list[$i]['Lesson']['lesson_id']); ?>"><span class="label label-info">Class Rank</span></a> <a href="<?php echo $this->Html->url('/student/view_course_rank/'.$lesson_list[$i]['Lesson']['lesson_id']); ?>"><span class="label label-info">Course Rank</span></a></span></td>
				</tr>
			<?php }	?>
			</tbody>
			</table>
		</div>
    </div>
    <div style="clear: both"></div>
</div>