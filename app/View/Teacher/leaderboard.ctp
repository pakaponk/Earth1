<?php
/**
 * @var $this View
 */
?>

<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Leaderboard</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 30/3/2556
 * Time: 10:45 น.
 * To change this template use File | Settings | File Templates.
 */
    echo $this->Html->script("jquery-1.9.1.min.js");
    echo $this->Html->script('bootstrap.js');
    echo $this->Html->script('bootstrap.min.js');
?>

<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <div id="left">
        <ul class="nav nav-pills" id="myTab">
            <?php for($i = 0;$i < $classrooms_num;$i++): ?>
                <?php if ($i==0): ?>
                    <li class="active"><a href="<?php echo "#classroom".$i?>" data-toggle="pill">Class <?php echo $leaderboards['Classroom'][$i]['Classroom']['grade'] . "/" . $leaderboards['Classroom'][$i]['Classroom']['room']?></a></li>
                <?php endif ?>
                <?php if ($i!=0): ?>
                    <li><a href="<?php echo "#classroom".$i?>" data-toggle="pill">Class <?php echo $leaderboards['Classroom'][$i]['Classroom']['grade'] . "/" . $leaderboards['Classroom'][$i]['Classroom']['room']?></a></li>
                <?php endif ?>
            <?php endfor ?>
        </ul>

        <div id="myTabContent" class="tab-content">
        <?php for ($j = 0;$j < $classrooms_num;$j++): ?>

            <?php if($j==0): ?>
            <div class="tab-pane active fade in" id="<?php echo "classroom".$j;?>">
            <?php endif ?>

            <?php if($j!=0): ?>
            <div class="tab-pane fade in" id="<?php echo "classroom".$j;?>">
            <?php endif ?>

            <div id="headerText"><h5><i class="icon-road"></i> Leader Board - Classroom <?php echo $leaderboards['Classroom'][$j]['Classroom']['grade'] . "/" . $leaderboards['Classroom'][$j]['Classroom']['room']?></h5></div>
            <table class="table table-hover" id="rank">
                <thead>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Total Score</th>
                </thead>

                <tbody>
                <?php
                    $student_num = count($leaderboards[$j]);
                    for ($i=0;$i<$student_num;$i++):
                ?>
                    <tr bgcolor="#FBFBFB">
                        <td><strong><?php echo $i+1 ?><strong></td>
                        <td><strong><?php echo $leaderboards[$j][$i]['User']['first_name'] ?></strong></td>
                        <td><strong><?php echo $leaderboards[$j][$i]['User']['last_name']; ?></strong></td>
                        <td><strong><?php echo $leaderboards[$j][$i][0]['total_score']; ?></strong></td>
                    </tr>
                <?php endfor ?>
                </tbody>
            </table>
            </div>
        <?php endfor ?>
        </div>
    </div>
    <div id="right">
    </div>
    <div style="clear:both"></div>

</div>

