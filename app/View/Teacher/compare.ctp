<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Compare average scores of a problem set of two classes</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 26/3/2556
 * Time: 11:58 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="padding: 10px;width: 800px;margin: 0px auto;">
<div>
<?php
    /*
    echo $this->Form->input('ProblemSet', array(
        'empty' => '-- Select a ProblemSet --',
        'type'=>'select',
        'options'=>$problemsets,
        'label'=>false,
        'style'=>'width:350px',
        'onchange'=>'javascript:problemsetGetTopic("/mathblink/teacher/problemsetGetTopic","lesson_id");'
    ));
    */
    echo $this->Form->create('CompareRoom');

    echo $this->Form->input('1', array(
       'empty' => '-- Select Room --',
       'type' => 'select',
       'options' => $classroom_list,
       'label' => 'Room 1'
    ));

    echo $this->Form->input('2', array(
        'empty' => '-- Select Room --',
        'type' => 'select',
        'options' => $classroom_list,
        'label' => 'Room 2'
    ));

    echo $this->Form->submit('Compare',array(
        'class' => 'btn btn-primary'
    ));

?>
<?php if($result == true): ?>
<br />
<h4>Compare Result</h4>
<table class="table table-bordered table-striped">
    <th>
        Classroom 1 : Average Score
    </th>
    <th>
        Classroom 2 : Average Score
    </th>
    <tr>
        <td> <?php
                if ($assignment1['Assignment']['status'] != "ended")
                {
                    echo sprintf("%.2f",$score1['Average']) . " / " . $question_num . " ( From " . $score1_num . " students sent the assignment )" ;
                }
                else
                {
                    echo sprintf("%.2f",$score1['Average']) . " / " . $question_num . " ( " . $score1_num . " students sent the assignment from " . $num1 . " in classroom )" ;
                }
            ?></td>
        <td> <?php
                if ($assignment2['Assignment']['status'] != "ended")
                {
                    echo sprintf("%.2f",$score2['Average']) . " / " . $question_num . " ( From " . $score2_num . " students sent the assignment )" ;
                }
                else
                {
                    echo sprintf("%.2f",$score2['Average']) . " / " . $question_num . " ( " . $score2_num . " students sent the assignment from " . $num2 . " in classroom )" ;
                }
            ?></td>
    </tr>
<?php endif ?>
</table>