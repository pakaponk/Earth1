<?php
/**
 * @var $this View
 */
?>
<!--MathJax.Hub.Typeset();-->
<script>
    MathJax.Hub.Typeset();
</script>

<!-- Modal -->
<?php if($this->request->is('post')): ?>
<div id="myModal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel" style="text-align: center">Score Summary : <?php echo $totalScore . ' / ' . $totalQuestion ?></h3>
    </div>
    <div class="modal-body">
        <div class="progress progress-success progress-striped active">
            <div class="bar" style="width: <?php echo $totalScore*100/$totalQuestion .'%' ?>"></div>
        </div>
    </div>
    <div class="modal-footer">
        <?php echo $this->Html->link('Solution',array('controller' => 'student','action' => 'showCheckAnswer'.'/'.$profile_data['id'].'/' . $asid),array('class' => 'btn btn-primary','id' => 'solution')); ?>
    </div>
</div>
<?php endif ?>

<script>
    $('document').ready(function(){
        var sh = 1;
        $('#show').click(function(){
            $('#date').toggle();
            if (sh == 1)
            {
                $('#show h4').html('Show Time Remaining');
                sh = 0;
            }
            else
            {
                $('#show h4').html('Hide Time Remaining');
                sh = 1;
            }
        });
        $('#myModal').on('hide',function(){
            window.location = $('#solution').attr('href')
        });
        <?php if($this->request->is('post')): ?>
            $('#myModal').modal('show');
        <?php endif ?>
    });
</script>
<?php
    echo $this->Html->script('jquery-1.9.1.min.js');
    echo $this->Html->script('bootstrap.js');
    echo $this->Html->script('bootstrap.min.js');
    echo $this->Html->script('script.js');
?>

<h3 id="header" style="width:800px;padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5;">
    <div style="float: left;padding: 10px"">Do Assignment</div>
    <div style="float: right;padding: 0px">
        <div id="show"><h4 class="btn btn-danger" data-toggle="popover">Hide Time Remaining</h4></div>
        <div>
            <h4 id="date" style="text-align: center">01:00:00</h4>
        </div>
    </div>
    <div style="clear: both"></div>
</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 22/3/2556
 * Time: 12:02 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="padding: 20px;width: 800px;margin: 0px auto;">
    <?php
    echo $this->Form->create('StudentsAssignment');
    ?>
    <table class="table table-bordered table-striped">
        <?php $i = 1;foreach ($problems as $problem):?>
            <tr>
                <td>
                    <div style="padding: 10px;margin-top: 10px">
                        <p><strong>Problem <span class="badge badge-info"><?php echo $i; ?></span></strong><p>

                        <div class="help-block">
                            <span class='help-inline'><?php

                                $main = $problem['ProblemLevel']['main_text'];
                                //Random Data set
                                $data_set = rand(0,count($problem['DataSet'])-1);

                                //Get inputs from random data set
                                $input = $problem['DataSet'][$data_set]['ProblemDataSet']['dataset'];
                                $input_num = $problem['ProblemLevel']['input_num'];
                                $output_num = $problem['ProblemLevel']['output_num'];
                                $choice_num = $problem['ProblemLevel']['choice_num'];

                                if ($problem['Problem']['problem_type'] == 'FIB'){
                                    for ($j = 0;$j < $input_num;$j++)
                                    {
                                        $start = strrpos($input,';',null);
                                        $input = substr($input,0,$start);
                                    }
                                }
                                else{
                                    $cut = $choice_num+1; // Number of Choice + 1 Answer in data set
                                    for ($j = 0;$j < $cut;$j++)
                                    {
                                        $start = strrpos($input,';',null);
                                        $input = substr($input,0,$start);
                                    }
                                }
                                //Replace inputs field in main text
                                for ($j = 1;$j <= $output_num;$j++)
                                {
                                    $find = 'o_{' . "$j" . "}";
                                    $end = strpos($input,';',0);
                                    if ($j<$output_num)
                                        $main = str_replace($find,substr($input,0,$end),$main);
                                    else
                                        $main = str_replace($find,substr($input,0),$main);
                                    $input = substr($input,$end+1);
                                }

                                $start = 0;
                                $output = array();
                                $chr = array_fill(0,26,0);
                                for ($j = 1;$j <= $input_num;$j++)
                                {
                                    $find = 'i_{' . "$j" . "}";
                                    do{
                                        $rand = rand(97,122);
                                    }
                                    while($chr[$rand-97] == 1);
                                    $output[$j-1] = chr($rand);
                                    $chr[$rand-97] =1;
                                    $main = str_replace($find,$output[$j-1],$main);
                                }

                                if ($problem['Problem']['problem_type'] == "MPC"){
                                    $input = $problem['DataSet'][$data_set]['ProblemDataSet']['dataset'];
                                    $count=0;
                                    $start = 0;
                                    while ($count<$output_num)
                                    {
                                        $start = strpos($input,';',$start)+1;
                                        $count++;
                                    }
                                    $end = strrpos($input,';',null);
                                    $choice_data = substr($input,$start,$end-$start);
                                    $choice = array();
                                    for ($j=0; $j < $choice_num;$j++){
                                        $end = strpos($choice_data,';',0);
                                        if ($j<$output_num)
                                        {
                                            $tmp = substr($choice_data,0,$end);
                                            $choice[$tmp] = $tmp;
                                        }
                                        else
                                        {
                                            $tmp = substr($choice_data,0);
                                            $choice[$tmp] = $tmp;
                                        }
                                        $choice_data = substr($choice_data,$end+1);
                                    }
                                }
                                echo $main;
                                ?></span>
                        </div>
                        <?php if ($problem['Problem']['problem_type'] == "FIB"): ?>
                            <?php for ($j = 1;$j <= $problem['ProblemLevel']['input_num'];$j++): ?>
                                <span class="help-inline"> <?php echo '$$' . $output[$j-1] . " = " . "$$"?></span>
                                <?php echo $this->Form->text('Problem'. $i . ' ' .$j,array('class'=>'input-mini')); ?>
                            <?php endfor ?>
                        <?php endif ?>

                        <?php if ($problem['Problem']['problem_type'] == "MPC"): ?>
                            <label class="radio">
                            <?php
                                $attributes = array(
                                    'legend' => false,
                                    'label' => 'false',
                                    'separator' => '</label><label class="radio">'
                                );
                                echo $this->Form->radio("Problem" . $i,$choice,$attributes)
                            ?>
                            </label>
                        <?php endif ?>

                            <?php echo $this->Form->hidden('Problem'. $i . ' hidden',array('value' => $data_set));?>
                    </div>
                </td>
            </tr>
            <?php $i++;endforeach?>
    </table>
    <?php
    echo $this->Form->submit("Submit",array('id' => 'submit','class' => 'btn btn-primary','div' => 'form-actions'));
    ?>
</div>