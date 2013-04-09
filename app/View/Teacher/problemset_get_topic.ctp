<h4 class="problemset_title">Topic</h4>
<?php
echo $this->Form->input('topic_id',
    array(
        'empty' => '-- Select a Topic --',
        'type'=>'select',
        'options'=>$topic_list,
        'label'=>false,
        'style'=>'width:330px',
        'onchange'=>'javascript:problemsetGetProblem("/mathblink/teacher/problemsetGetProblem","topic_id");'));
?>
