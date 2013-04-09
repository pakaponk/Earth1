<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/19/13 AD
 * Time: 1:52 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($lesson_list);
$problemset_arr = $problemset_arr["ProblemSet"];
$course_arr = $course_arr["Course"];
?>


<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Problem Set',array(
        'controller' => 'teacher',
        'action' => 'problemset_main')); ?> <span class="divider">/</span></li>
    <li class="active"> <?php echo $this->Html->link($problemset_arr["problemset_name"],array(
        'controller' => 'problem_set',
        'action' => 'view',$problemset_arr["problemset_id"])); ?>
        <span class="divider">/</span> </li>
    <li class="active">Edit Problem set</li>
</ul>

<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">
    Problem set Editor <!--<span class="badge badge-info">Step 2</span>-->
</h3>
<div style="padding: 10px;width:700px;margin: 0px auto;">

    <h4 class="problemset_title">Problemset Name</h4>
    <h4 style="border-bottom: 1px solid #e5e5e5;padding-bottom: 10px">
        <span style="float: left;width: 80%"><?php echo $problemset_arr["problemset_name"]; ?></span>
        <span style="float: right;width:40px">
            <a href="<?=$this->Html->url('edit');?>" class="btn btn-primary btn-mini">Edit</a>
        </span>
        <div style="clear: both"></div>
    </h4>

    <h4 class="problemset_title">Guideline</h4>
    <h4 style="border-bottom: 1px solid #e5e5e5;padding-bottom: 10px">
        <div style="float: left;width: 80%;word-wrap: break-word;"><?php echo $problemset_arr["guideline"]; ?></div>
        <span style="float: right;width:40px">
            <a href="<?=$this->Html->url('edit');?>" class="btn btn-primary btn-mini">Edit</a>
        </span>
        <div style="clear: both"></div>
    </h4>

    <!--<h4 class="problemset_title">Problemset Type</h4>
    <h4 style="border-bottom: 1px solid #e5e5e5;padding-bottom: 10px"><?php echo $problemset_arr["problemset_type"]; ?></h4>-->

    <h4 class="problemset_title">Created Time</h4>
    <h4 style="border-bottom: 1px solid #e5e5e5;padding-bottom: 10px"><?php echo $problemset_arr["created"]; ?></h4>


    <br/><br/>

    <div style="width: 330px;float: left">
    <h4 class="problemset_title">Course</h4>
    <h4 style="padding-bottom: 10px"><?php echo $course_arr["course_name"]; ?></h4>
    <h4><?php //echo $course_arr["course_description"]; ?></h4>
    <h4 class="problemset_title">Lesson</h4>
    <?php
    echo $this->Form->input('lesson_id',
        array(
            'empty' => '-- Select a Lesson --',
            'type'=>'select',
            'options'=>$lesson_list,
            'label'=>false,
            'style'=>'width:330px',
            'onchange'=>'javascript:problemsetGetTopic("/mathblink/teacher/problemsetGetTopic","lesson_id");'));
        /*TODO
            /mathblink/teacher/problemsetGetTopic should be changed next time we deploy
        */
    ?>
    <?php
    ?>
    <div id="TopicDiv"></div>
    <div id="ProblemDiv"></div>

        <div id="debug_save"></div>
    </div>

    <div style="float: right;width: 330px;" id="problemset_queue_wrapper">
        <div class="hero-unit" id="problemset_queue" style="padding: 10px">
            <h4>Problem Queue<span style="float: right"><a href="javascript:save_problemset(<?php echo $problemset_arr["problemset_id"]; ?>);" class="btn btn-primary">Save</a></span></h4>
            <?php
                foreach($added_problem as $problem):
                $problem = $problem["ProblemLevel"];
                $latex = $problem["main_text"];
                $id = $problem["problem_level_id"];
            ?>
            <script>
                problemId[problemCount] = <?php echo $id ; ?>;
                problemStatus[problemCount++] = "add" ;
            </script>

            <div style="font-size: 13px;margin-bottom: -5px;border-bottom: 1px solid #b3b3b3" id="<?php echo $id ; ?>">
                <span style="width:50px"><?php echo $latex ; ?></span>
                <a href="javascript:removeProblem('<?php echo $latex ;?>','<?php echo $id ; ?>')" class="btn btn-mini">remove</a></div>

            <?php endforeach ?>

        </div>
    </div>
<div id="problemset_problem_id" style="visibility: hidden"></div>
<div id="problemset_problem_status" style="visibility: hidden"></div>
    <div style="clear: both"></div>
</div>


