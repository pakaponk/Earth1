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
    <li class="active">Lesson : <?php echo $data["Lesson"]["lesson_name"]; ?></li>
</ul>

<h3
        style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Lesson <?php echo $data["Lesson"]["lesson_name"] ; ?>
    <!--<span style="float: right"> <a
        class="btn btn-primary"
        href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>-->
</h3>

    <div style="padding: 10px;margin-left: 50px;margin-right: 50px">
        <?php
            echo $data["Lesson"]["lesson_description"];
        ?><br/>
        <h4>Duration :</h4>

        <?php
        if($auth == "teacher"){
            echo $this->Form->create('Lesson');
            echo $this->Form->input('start_date',array('dateFormat' => 'DMY','default'=>$data["Lesson"]["start_date"]));
            echo $this->Form->input('end_date',array('dateFormat' => 'DMY','default'=>$data["Lesson"]["end_date"]));
            echo $this->Form->hidden('lesson_id', array('value' => $data["Lesson"]["lesson_id"]));
            echo $this->Form->submit('Edit Date',array('class' => 'btn btn-primary'));
        }else{
            ?>
            <span style="font-size: 15px">
            <?php echo $data["Lesson"]["start_date"] ;?> to <?php echo $data["Lesson"]["end_date"]; ?>
            </span>
        <?php
            }
        ?>
        <br/>
        <h4>Topic :</h4>
        <?php foreach($data["Topic"] as $topic) :?>
            <a href="<?php echo $this->Html->Url(array('controller'=>'topic','action'=>'view',$course_data["Course"]["course_id"],$topic["topic_id"])); ?>" class="btn"><?php echo $topic["topic_name"] ;?></a>
        <?php endforeach; ?>

    </div>