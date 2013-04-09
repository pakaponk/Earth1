<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Problem Set',array(
        'controller' => 'teacher',
        'action' => 'problemset_main')); ?> <span class="divider">/</span></li>
    <li class="active"> Assign</li>
</ul>

<h3
	style="padding: 10px; margin-left: 50px; margin-right: 50px; border-bottom: 1px solid #e5e5e5">Assign
	to Class</h3>

<div style="padding: 10px; width: 800px; margin: 0px auto;">
	<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: CloudStrife
	 * Date: 20/3/2556
	 * Time: 9:50 เธ�.
	 * To change this template use File | Settings | File Templates.
	 */
	echo $this->Form->create('Assignment');
	echo $this->Form->input('classroom_id');


	echo $this->Form->input('release_date', array('type' => 'text' ,
			'label' => 'Release Date/Time' ,
			'div' => false));
	echo "&nbsp;&nbsp;";
	echo $this->Form->input('release_time_hour', array('type' => 'select',
			'label' => false ,
			'options' => array_map(function($n) {
			return sprintf('%02d', $n);
	}, range(0,23) ) ,
	'div' => false ,
	'style'=>'width:70px;height:30px;font-size:17px;' ,
	));
	echo " : ";
	echo $this->Form->input('release_time_min', array('type' => 'select',
			'label' => false ,
			'div' => false ,
			'options' => array_map(function($n) {
			return sprintf('%02d', $n);
	}, range(0,59,5) ) ,
	'style'=>'width:70px;height:30px;font-size:17px'));


	echo $this->Form->input('end_date', array('type' => 'text' ,
			'label' => 'End Date/Time' ,
			'div' => false));
	echo "&nbsp;&nbsp;";
	echo $this->Form->input('end_time_hour', array('type' => 'select',
			'label' => false ,
			'options' => array_map(function($n) {
			return sprintf('%02d', $n);
	}, range(0,23) ) ,
	'div' => false ,
	'style'=>'width:70px;height:30px;font-size:17px;' ,
	));
	echo " : ";
	echo $this->Form->input('end_time_min', array('type' => 'select',
			'label' => false ,
			'div' => false ,
			'options' => array_map(function($n) {
			return sprintf('%02d', $n);
	}, range(0,59,5) ) ,
	'style'=>'width:70px;height:30px;font-size:17px'));
    echo $this->Form->submit(__('Submit'),array('class' => 'btn btn-primary'));	?>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    //hide TaskDue and add two inputs in its place for date + time
    //when submitted, put their values into TaskDue
    //enable datepicker
    $('#AssignmentReleaseDate').hide().after('<input type="text" name="ReleaseDate" id="ReleaseDate" value="" style="width:200px"/>');
    $('#AssignmentEndDate').hide().after('<input type="text" name="EndDate" id="EndDate" value="" style="width:200px"/>');
    $("#ReleaseDate").Zebra_DatePicker({
      format: 'd/m/Y',
      direction: true,
      pair: $('#EndDate')
    });
    $("#EndDate").Zebra_DatePicker({
        format: 'd/m/Y',
        direction: true
      });
 
    //put values back into CakePHP input element
    $("#AssignmentAssignForm").submit(function() {
    	var ReleaseDate = $("#ReleaseDate").val();
    	ReleaseDate = ReleaseDate.split('/');
        $("#AssignmentReleaseDate").val(ReleaseDate[2] + '-' + ReleaseDate[1] + '-' + ReleaseDate[0] + ' ' + $("#AssignmentReleaseTimeHour").val() + ':' +
      		  $("#AssignmentReleaseTimeMin").val()*5 + ':00');
      	var EndDate = $("#EndDate").val();
      	EndDate = EndDate.split('/');
     	$("#AssignmentEndDate").val(EndDate[2] + '-' + EndDate[1] + '-' + EndDate[0] + ' ' + $("#AssignmentEndTimeHour").val() + ':' +
    		  $("#AssignmentEndTimeMin").val()*5 + ':00');
    });
  });
</script>
