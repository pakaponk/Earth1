<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 4/2/13 AD
 * Time: 5:59 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<h3>
    Select Class to View
</h3>
<?php
if($class_list == array()){ ?>
<span class="muted">no classroom</span>
<?php
}
?>
<?php foreach($class_list as $key => $list){?>
<a href="<?php echo $this->Html->Url(array('controller' =>'teacher','action' => 'problemset_main',$course_id,$key)) ?>" id="bt<?php echo $key ?>" class="btn btn-large"><?php echo $list ; ?></a>
<?php } ?>



