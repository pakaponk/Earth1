<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Assignment <?php echo $assignment['ProblemSet']['problemset_name'] ?></h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 22/3/2556
 * Time: 10:04 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <h4>Guide Line</h4>
    <div style = "padding:10px;width:800px;height: 100px;margin:0px auto;background-color: #FFDACC">
        <p><?php echo $assignment['ProblemSet']['guideline']?></p>
    </div>
    <br />
    <div style="display: inline-block;margin: 0px 0px 10px 0px">
        <?php echo $this->Html->link("Start",array('controller'=>'student','action'=>'start'."/assignment=".$assignment['Assignment']['id']),array('class'=>'btn btn-primary'));?>
    </div>
    <div style="display: inline-block;margin: 0px 0px 0px 10px">
        <?php echo $this->Html->link("Cancel",array('controller'=>'student','action'=>'index'),array('class'=>'btn btn-primary'));?>
    </div>
</div>