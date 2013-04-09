
<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">
    Create Problemset - Step 1
</h3>

<div style="padding: 10px;width:400px;margin: 0px auto;">

<?php echo $this->Form->create('ProblemSet'); ?>
    <h4>Problemset Name</h4>
<?php echo $this->Form->input('problemset_name',array('label'=> false,'style'=>'width:350px')); ?>
    <h4>Guide Line</h4>
<?php echo $this->Form->input('guideline',array('type' => 'textarea','label'=> false,'style'=>'width:350px;height:150px')); ?><br/>
<h4>Course</h4>
    <?php

    echo $this->Form->input('course_id',array('type'=>'select'
    ,'options'=>$course_list
    ,'label'=>false
    ,'empty' => '-- Select a Course --'
    ,'style'=>'width:350px'));
?>

<!--<div id="LessonDiv"></div>-->
<div id="TopicDiv"></div>
<div id="ProblemDiv"></div>


<br/>
<div style="width:100%;text-align: center">
<?php
echo $this->Form->submit('Create new problemset',array(
'class' => 'btn btn-large btn-primary',
'title' => 'Create new problemset'
));
?>
</div>


<?php echo $this->Form->end(); ?>


</div>