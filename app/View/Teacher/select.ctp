<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 4/2/13 AD
 * Time: 5:05 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<script>
    $(document).ready(function () {
        //alert("The DOM is now loaded and can be manipulated.");
        //$('#selectCourseDiv').show();
        $("#selectCourseDiv").fadeIn("slow");
        $('#bg').fadeIn("slow");
    });
</script>



<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Select Course to View
</h3>

<div id="selectCourseDiv" style="position:relative;z-index:20010;padding: 10px;
margin-left: 50px;margin-right: 50px;width:600px;margin: 0px auto;display: none;background-color: #FAFAFA
;text-align: center" class="hero-unit">
    <h3>Select a Course to Display</h3>
    <?php foreach($course_list as $key => $list){?>
        <a href="javascript:get_class(<?php echo $key ;?>)" id="bt<?php echo $key ?>" class="btn btn-large"><?php echo $list ; ?></a>
    <?php } ?>

<div id="selectClassDiv"></div>
</div>




