<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/29/13 AD
 * Time: 10:23 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Lesson Plan',array(
        'controller' => 'lesson_plan',
        'action' => 'index')); ?> <span class="divider">/</span></li>
    <li><?php echo $this->Html->link("Course : ".$course_data["Course"]["course_name"],array(
        'controller' => 'lesson_plan',
        'action' => 'view',$course_data["Course"]["course_id"])); ?> <span class="divider">/</span></li>
    <li><?php echo $this->Html->link("Lesson : ".$data["Lesson"]["lesson_name"],array(
        'controller' => 'lesson',
        'action' => 'view',$course_data["Course"]["course_id"],$data["Lesson"]["lesson_id"])); ?> <span class="divider">/</span></li>
    <li class="active">Topic : <?php echo $data["Topic"]["topic_name"]; ?></li>
</ul>

<h3
        style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Topic : <?php echo $data["Topic"]["topic_name"] ; ?>
    <!--<span style="float: right"> <a
        class="btn btn-primary"
        href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>-->
</h3>

<div style="padding: 10px;margin-left: 50px;margin-right: 50px">
    <?php
    echo $data["Topic"]["topic_description"];
    ?>
    <br/>
    <h4>Duration : </h4>
    <?php if($auth == "teacher") {?>
    <?php
    echo $this->Form->create('Topic');
    echo $this->Form->input('start_date',array('dateFormat' => 'DMY','default'=>$data["Topic"]["start_date"]));
    echo $this->Form->input('end_date',array('dateFormat' => 'DMY','default'=>$data["Topic"]["end_date"]));
    echo $this->Form->hidden('topic_id', array('value' => $data["Topic"]["topic_id"]));
    echo $this->Form->submit('Edit Date',array('class' => 'btn btn-primary'));
    ?>
    <?php }else{ ?>
    <span style="font-size: 15px">
    <?php echo $data["Topic"]["start_date"] ; ?> to <?php echo $data["Topic"]["end_date"] ;?>
    </span>
    <?php } ?>
    <div style="border-bottom: 1px solid #efefef">&nbsp;</div>

    <?php
        if($auth == "teacher"){
    ?>
    <div style="float: left;width: 370px">
        <h4>Add Problem to Topic : </h4>
        <?php
        echo $this->Form->input('concept_id',
            array(
                'empty' => '-- Select a Concept --',
                'type'=>'select',
                'options'=>$concept_list,
                'label'=>'Concept',
                'style'=>'width:330px',
                'onchange'=>'javascript:get_problem_to_topic("TopicConceptId");'));

        echo $this->Form->input('technique_id',
            array(
                'empty' => '-- Select a Technique --',
                'type'=>'select',
                'options'=>$technique_list,
                'label'=>'Technique',
                'style'=>'width:330px',
                'onchange'=>'javascript:get_problem_to_topic("TopicTechniqueId");'));

        ?>
        <div id="problem"></div>
        <div id="problem_id" style="visibility: hidden"></div>
        <div id="problem_status" style="visibility: hidden"></div>

    </div>
    <div style="float: right;padding: 0px;" id="problem_queue">
        <h4 style="float: left;width: 200px;margin-bottom: 10px">Problem Queue : </h4>
        <span style="float: right;margin-top: 5px"><a href="javascript:save_problem_to_topic(<?php echo $data["Topic"]["topic_id"] ;?>)" class="btn btn-primary">Save</a></span>
        <div style="clear: both"></div>
        <?php if($topic_problem == array()){ ?>

        <?php } ?>
            <?php foreach($topic_problem as $problem) :?>
                <div style="padding: 5px;font-size: 15px;width: 400px;margin-bottom: 5px" class="hero-unit" id="problem<?php echo $problem["Problem"]["problem_id"] ;?>">
               <span style="font-weight: bold" class="muted">
                   #<?php echo $problem["Problem"]["problem_id"] ; ?>
               </span>
                    <?php $arg = "" ;?>
                    <script>
                        problemId[problemCount] = <?php echo $problem["Problem"]["problem_id"] ; ?>;
                        problemStatus[problemCount++] = "add" ;
                    </script>
                <?php foreach($problem["ProblemLevel"] as $level) :?>
                    <?php $arg .= $level["main_text"]." "; ?>
                    <?php echo $level["main_text"]; ?>
                <?php endforeach ; ?>
                    <a href="javascript:remove_problem_topic('<?php echo $arg  ;?>','<?php echo $problem["Problem"]["problem_id"] ;?>')" class="btn">
                    remove</a>
                </div>
        <?php endforeach ; ?>
    </div>
    <div style="clear: both"></div>
    <?php } ?>
</div>