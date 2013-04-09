<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Problem Set',array(
        'controller' => 'teacher',
        'action' => 'problemset_main')); ?> <span class="divider">/</span></li>
    <li class="active">     <?php echo $ps['ProblemSet']['problemset_name'] ?>    </li>
</ul>
<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">
     <?php echo $ps['ProblemSet']['problemset_name'] ?>
    <span style="float: right" >

        <a href="<?php echo $this->Html->url(array(
                'controller' => 'teacher',
                'action' => 'problemset',
                $ps["ProblemSet"]["problemset_id"])
        );  ?>" class="btn btn-primary">Edit Problem</a>

        <a href="<?php echo $this->Html->url(array(
                'action' => 'edit',
                $ps["ProblemSet"]["problemset_id"])
        );  ?>" class="btn">Edit Detail</a>
    </span>
</h3>

<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <?php
    // Ready/Unready Button Text
    $str;
    // Check if Problem Set is ready,it can assign to class
    $assign_check;
    // Count Assignments
    $assign_count=count($assignments);
    ?>
    <span style="width: 300px;float: left">
    <?php
    echo $this->Html->para(null,'Course:',array('style' => 'margin: 0 0 1em 0;font-size:21px;font-weight:bolder;'));
    echo $this->Html->para(null,$course_list[$ps['ProblemSet']['course_id']],array('style' => 'margin: 0 0 1em 0;font-size:18px;'));
    ?>
    </span>
    <span style="float: right;width: 300px;background-color: #f2f2f2;padding: 10px">
    <?php
    echo $this->Html->para(null,'Created:',array('style' => 'font-size:15px;font-weight:bolder;'));
    echo $this->Html->para(null,$ps['ProblemSet']['created'],array('style' => 'font-size:15px;'));
    echo $this->Html->para(null,'Last modified:',array('style' => 'font-size:15px;font-weight:bolder;'));
    echo $this->Html->para(null,$ps['ProblemSet']['modified'],array('style' => 'font-size:15px;'));
    ?>
        </span>
<?php
    echo $this->Html->para(null,'Status:',array('style' => 'margin: 0 0 1em 0;font-size:21px;font-weight:bolder;'));
    ?>

    <?php
    if (is_null($ps['ProblemSet']['ready']) || (!$ps['ProblemSet']['ready']))
    {
        echo $this->Html->para(null,'Creating',array('style' => 'margin: 0 0 1em 0;font-size:18px;'));
        $str = 'Set Ready';
        $assign_check = false;
    }
    else
    {
        echo $this->Html->para(null,'Ready',array('style' => 'margin: 0 0 1em 0;font-size:18px;'));
        $str = 'Set Unready';
        $assign_check = true;
    }?>

    <!--<a class="btn" href="<?php echo $this->Html->url(array(
            'controller' => 'teacher',
            'action' => 'problemset',
            $ps["ProblemSet"]["problemset_id"])
    );  ?>">Edit Problem set</a>-->

    <!--<a class="btn" href="<?php echo $this->Html->url(array(
        'action' => 'edit',
        $ps["ProblemSet"]["problemset_id"])
    );  ?>">Edit data</a>-->

    <?php
    if ($assign_count==0)
    {
        echo $this->Html->link($str, array('action'=> 'setready',$ps['ProblemSet']['problemset_id']),array('class' => 'btn'));
    }
    ?>

    <?php
    if ($assign_check)
    {
        echo $this->Html->link("Assign to Class", array('action' => 'assign',$ps['ProblemSet']['problemset_id']),array('class' => 'btn'));
    }
    ?>

    <?php
    if ($assign_count>1)
    {
        echo $this->Html->link("Cancel All Assignment", array('action'=> 'cancelall',$ps['ProblemSet']['problemset_id']),array('class' => 'btn'));
    }
    ?>

    <br></br>
    <?php if($assign_count == 0) echo"<br/>"; ?>

    <?php if($assign_count>0):?>
    <h4>Assignment :</h4>
    <table class="table table-bordered" width="800" cellpadding="10" style="text-align: center">
        <tr>
            <th>Classroom</th>
            <th>Release Date</th>
            <th>End Date</th>
            <th>Cancel </th>
        </tr>
        <?php foreach($assignments as $assignment): ?>
        <tr>
            <td><?php echo $assignment['Classroom']['room']; ?></td>
            <td><?php echo $assignment['Assignment']['release_date']; ?></td>
            <td>
                <?php echo $assignment['Assignment']['end_date']; ?>
                <span style="float: right">
                    <?php echo $this->Html->link("Extend Ended-date", array('controller' => 'assignment','action'=> '/extendEnddate/' . $assignment['Assignment']['id'].'/'.$ps["ProblemSet"]["problemset_id"]),array('class' => 'btn btn-mini'));?>
                </span>
            </td>
            <td>
                <?php echo $this->Html->link("Cancel", array('action'=> '/cancel/' . $assignment['Assignment']['id'].'/'.$ps["ProblemSet"]["problemset_id"]),array('class' => 'btn btn-mini'));?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php endif ?>

</div>