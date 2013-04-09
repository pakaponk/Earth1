<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">
    Extend End date
</h3>


<div class="extend end date form" style="padding: 10px;width: 700px;margin: 0px auto">
		<?php echo $this->Form->create('Assignment');
		$time = $data[0]['Assignment']['end_date'];
		echo $this->Form->input('end_date', array('type' => 'text'));
		echo $this->Form->input('end_time_hour', array('type' => 'select',
				'label' => 'End Time' ,
				'options' => array_map(function($n) { return sprintf('%02d', $n); }, range(0,23) ) ,
				'div' => false ,
				'style'=>'width:70px;height:40px;font-size:18px;' ,
				));
		echo " : ";
		echo $this->Form->input('end_time_min', array('type' => 'select',
				'label' => false ,
				'div' => false ,
				'options' => array_map(function($n) { return sprintf('%02d', $n); }, range(0,59,5) ) ,
				'style'=>'width:70px;height:40px;font-size:18px'));
		/*echo $this->Form->dateTime('end_date', $dateFormat = 'DMY', $timeFormat = '24', $attributes = array(
		 'value' => $time,
				'interval' => 15,
				'minYear' => date('Y'),
				'separator' => '-')) ."<br/>";*/
		?>
	<?php
	echo $this->Form->submit('Extend End Date',array(
                    'class' => 'btn btn-primary'
                ));
                ?>
</div>
<input id="end_day" type="text" value="<?php echo $day; ?>" style="display:none;" />
<input id="end_month" type="text" value="<?php echo $month; ?>" style="display:none;" />
<input id="end_year" type="text" value="<?php echo $year; ?>" style="display:none;" />
<script type="text/javascript">
  $(document).ready(function(){
    //hide TaskDue and add two inputs in its place for date + time
    //when submitted, put their values into TaskDue
    //enable datepicker
    $('#AssignmentEndDate').hide().after('<input type="text" name="DueDate" id="DueDate" value="" style="width:200px"/>');
    $("#DueDate").Zebra_DatePicker({
      format: 'd/m/Y',
      direction: true
    });
    $("#DueDate").val($("#end_day").val() + "/" + $("#end_month").val() + "/" + $("#end_year").val());
 
    //put values back into CakePHP input element
    $("#AssignmentExtendEnddateForm").submit(function() {
      var DueDate = $("#DueDate").val();
      var DueTime = $("#DueTime").val();
      DueDate = DueDate.split('/');
      $("#AssignmentEndDate").val(DueDate[2] + '-' + DueDate[1] + '-' + DueDate[0] + ' ' + $("#AssignmentEndTimeHour").val() + ':' +
    		  $("#AssignmentEndTimeMin").val()*5 + ':00');
    });
  });
</script>
