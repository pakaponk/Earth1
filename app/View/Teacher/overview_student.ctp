<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Overview of Student Score in Problemset</h3>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 28/3/2556
 * Time: 12:00 น.
 * To change this template use File | Settings | File Templates.
 */
    $assign = array();
?>
<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <h4>Q4</h4>
    <div>
        <table class="table table-bordered">
            <th>Student</th>
            <th>Classroom</th>
            <th>Score</th>
            <?php if(!$course_end): ?>
            <?php for($i=0 ; $i < $q ; $i++): ?>
                <tr>
                    <?php array_push($assign,$score[$i]['User']['id']);?>
                    <td><?php echo $score[$i]['User']['first_name'];?></td>
                    <td><?php echo $score[$i]['User']['classroom_id'];?></td>
                    <td><?php echo $score[$i]['AssignmentScore']['score'];?></td>
                </tr>
            <?php endfor ?>
            <?php endif ?>
            <?php if ($course_end): ?>
                <?php for($i=0 ; $i < $q ; $i++): ?>
                    <tr>
                        <td><?php echo $score[$i]['User']['first_name'];?></td>
                        <td><?php echo $score[$i]['User']['classroom_id'];?></td>
                        <td><?php echo $score[$i]['AssignmentScore']['score'];?></td>
                    </tr>
                <?php endfor ?>
            <?php endif ?>
            <table>
    </div>
    <h4>Q1</h4>
    <div>
        <table class="table table-bordered">
            <th>Student</th>
            <th>Classroom</th>
            <th>Score</th>
            <?php if (!$course_end): ?>
            <?php for($i=0 ; $i < $q ; $i++): ?>
                <tr>
                    <?php array_push($assign,$score[$score_num-$i-1]['User']['id']);?>
                    <td><?php echo $score[$score_num-$i-1]['User']['first_name'];?></td>
                    <td><?php echo $score[$score_num-$i-1]['User']['classroom_id'];?></td>
                    <td><?php echo $score[$score_num-$i-1]['AssignmentScore']['score'];?></td>
                </tr>
            <?php endfor ?>
            <?php endif ?>
            <?php if ($course_end): ?>
                <?php for($i=0 ; $i < $q ; $i++): ?>
                    <tr>
                        <td><?php echo $score[$course_num-$i-1]['User']['first_name'];?></td>
                        <td><?php echo $score[$course_num-$i-1]['User']['classroom_id'];?></td>
                        <td><?php echo $score[$course_num-$i-1]['AssignmentScore']['score'];?></td>
                    </tr>
                <?php endfor ?>
            <?php endif ?>
        <table>
    </div>
    <h4>Q4 Nor Q1</h4>
    <div>
        <table class="table table-bordered">
            <th>Student</th>
            <th>Classroom</th>
            <th>Score</th>
            <?php if(!$course_end): ?>
            <?php for($i=$q ; $i < $score_num-$q ; $i++): ?>
                <tr>
                    <?php array_push($assign,$score[$i]['User']['id']);?>
                    <td><?php echo $score[$i]['User']['first_name'];?></td>
                    <td><?php echo $score[$i]['User']['classroom_id'];?></td>
                    <td><?php echo $score[$i]['AssignmentScore']['score'];?></td>
                </tr>
            <?php endfor ?>
            <?php endif ?>
            <?php if($course_end): ?>
                <?php for($i=$q ; $i < $course_num-$q ; $i++): ?>
                    <tr>
                        <td><?php echo $score[$i]['User']['first_name'];?></td>
                        <td><?php echo $score[$i]['User']['classroom_id'];?></td>
                        <td><?php echo $score[$i]['AssignmentScore']['score'];?></td>
                    </tr>
                <?php endfor ?>
            <?php endif ?>
        <table>
    </div>
    <?php if(!$course_end): ?>
        <h4>Still not assign</h4>
            <table class="table table-bordered">
                <th>Student</th>
                <th>Classroom</th>
                <?php for($i=0 ; $i < count($course_students) ; $i++): ?>
                    <tr>
                        <?php if (!is_integer(array_search($course_students[$i]['User']['id'],$assign))):?>
                        <td><?php echo $course_students[$i]['User']['first_name'];?></td>
                        <td><?php echo $course_students[$i]['User']['classroom_id'];?></td>
                        <?php endif ?>
                    </tr>
                <?php endfor; ?>
            <table>
    <?php endif ?>
</div>