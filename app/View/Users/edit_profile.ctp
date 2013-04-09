<!-- File: /app/View/Posts/index.ctp -->

<?php
//echo $refer;
//debug($data);
?>

<div style="clear:both"></div>


<div style="clear:both"></div>

<div id="Main">

    <div id="edit_profile_form" style="padding: 10px;width: 98%">
        <h3 style="border-bottom: 1px solid #e5e5e5;"><?php echo __('Edit Profile'); ?></h3>

        <div style="margin: 0px auto;width: 400px">
            <?php echo $this->Form->create('User'); ?>
                <?php
                echo $this->Form->input('password',array(
                    'style'=>'width:350px;height:45px;font-size:22px'))."<br/>";
                echo $this->Form->input('first_name',array('value' =>$data[0]['User']['first_name'],
                    'style'=>'width:350px;height:45px;font-size:22px'))."<br/>";
                echo $this->Form->input('middle_name',array('value' => $data[0]['User']['middle_name'],
                    'style'=>'width:350px;height:45px;font-size:22px'))."<br/>";
                echo $this->Form->input('last_name',array('value' => $data[0]['User']['last_name'],
                    'style'=>'width:350px;height:45px;font-size:22px'))."<br/>";

                ?>
            <?php
                echo $this->Form->submit('Edit Profile',array(
                    'class' => 'btn btn-large',
                    'title' => 'Login'
                ));
                ?>
         </div>


    </div>

</div>
