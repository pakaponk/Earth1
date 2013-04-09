<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Lesson Plan',array(
        'controller' => 'teacher',
        'action' => 'lesson_plan')); ?> <span class="divider">/</span></li>
    <li><?php echo $this->Html->link("Course : ".$data["Course"]["course_name"],array(
        'controller' => 'teacher',
        'action' => 'view_lesson_plan',
         $data["Course"]["course_id"])); ?> <span class="divider">/</span></li>
    <li class="active">Full Lesson Plan</li>
</ul>

<h3
        style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    Full Lesson Plan
    <!--<span style="float: right"> <a
        class="btn btn-primary"
        href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>-->
</h3>


<div style="padding: 0px;width: 770px;margin:0px auto;">
    <?php foreach($data["Lesson"] as $lesson):
    $start = str_replace("-","/",$lesson["start_date"]);
    $end = str_replace("-","/",$lesson["end_date"]);

    ?>

    <div class="hero-unit" style="padding: 10px;margin-bottom: 5px">
    <strong>Lesson</strong> <?php echo $lesson["lesson_name"] ?><br/>
    <?php foreach($lesson["Topic"] as $topic) :?>
         <span style="margin-left: 3.5em"><strong>Topic</strong> <?php echo $topic["topic_name"] ?></span><br/>
        <?php endforeach ; ?>
    </div>
    <?php endforeach ; ?>

    </div>
