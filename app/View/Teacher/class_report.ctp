<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Class report
    <!--<span style="float: right">
    <a class="btn btn-primary" href="<?php echo  $this->Html->url(array(
        'controller' => 'Teacher' ,
        'action' => 'create_problemset'
    )) ;?> ">Create new</a>
    </span>-->
</h3>



<div style="padding: 10px;width: 800px;margin: 0px auto;">

    <div style="width: 390px;padding: 0px;float: left">
<?php
    $flag = 0 ;
?>
<?php foreach($teacher_class as $classroom) : ?>
    <?php  if($flag >= 7) {?>
     <table class="table table-bordered table-hover">
    <tr><td>
    <h4 style="width: 795px;float: left">Class <?php echo $classroom["full_classroom"]; ?></h4>
        <span style="float: right"><a href="" class="btn">View Class</a></span>
        <?php $j = 0 ;?>
        <?php foreach($data[$classroom["id"]] as $class) :?>
        <tr><td>
        <div style="font-weight: bold">
            <?php echo $problemset_name[$classroom["id"]][$j];?>
            <?php
            $percent = ($class["assignment_complete"]/$class["total_assignment"])*100;
        ?></div>
<div style="text-align: right;font-weight: bold;margin-top: -20px" class="muted" >
    <?php echo $class["assignment_complete"] ; ?> / <?php echo $class["total_assignment"] ; ?>
</div>
        <div class="progress progress-success progress-striped" >
            <div class="bar" style="width: <?php echo $percent ; ?>%;"></div>
        </div>
         <div style="margin-top: -17px;">
            <!-- Highest Score : <?php //echo $highest_score[$classroom["id"]][$j++][0]['AssignmentScore']['score']; ?>
             Lowest Score : <?php ?>
             <a href="" class="btn">View</a>-->
         </div>
        </td></tr>
        <?php endforeach ?>
    </td></tr>
    <?php } $flag++; ?>
    </table>
<?php endforeach ?>
    </div>


  <!--  <div style="width: 390px;padding: 0px;float: right">
        Course
        <table class="table table-bordered">
            <?php foreach($teacher_course as $class) : ?>
                <tr><td>
                    <?php
                    echo $class["course_name"];
                    ?>
                </td></tr>
            <?php endforeach ?>
        </table>
    </div>-->

<div style="clear: both"></div>


</div>