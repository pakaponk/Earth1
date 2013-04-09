<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/28/13 AD
 * Time: 2:51 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            editable: true,
            events: [
            <?php

            function getDay($str){
                $arr = explode("/",$str);
                return $arr[2];
            }

            function getMonth($str){
                $arr = explode("/",$str);
                return $arr[1];
            }

            function getYear($str){
                $arr = explode("/",$str);
                return $arr[0];
            }

               $notend = count($data);
              foreach($data as $set):
               $c = count($set) ;
            foreach($set as $lesson):
                $start = str_replace("-","/",$lesson["start_date"]);
                $end = str_replace("-","/",$lesson["end_date"]);

                $sd = getDay($start) ;
                $sm = getMonth($start)-1;
                $sy = getYear($start);

                $ed = getDay($end) ;
                $em = getMonth($end)-1;
                $ey = getYear($end);

                echo "
                    {
                        title: '".$lesson["lesson_name"]."',
                        start: new Date(".$sy.",".$sm.",".$sd."),
                        end: new Date(".$ey.",".$em.",".$ed.")
                    }";
                if($c !== 1 || $notend !== 1 ) echo",";
                $c--;
            endforeach;
              $notend--;
            endforeach;
            ?>
            ]
        });

    });
</script>
<h3 style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
Lesson plan
    <!--<span style="float: right">
        <a class="btn btn-primary" href="<?php echo $this->Html->Url(array(
            'controller' => 'course',
            'action'    => 'index'
        ));?>">View all Courses</a>
	</span>-->
</h3>


<div style="padding: 10px;margin-left: 50px;margin-right: 50px">

    <div id='calendar' style="width: 800px"></div><br/>

    <table class="table table-bordered table-hover" cellpadding="10"
           style="text-align: center; width: 800px; margin: 0px auto;">
        <tbody>
        <?php
        foreach( $courses as $course ){
            /*$course_id = $course['Course']['course_id'];
            $course_name = $course['Course']['course_name'];
            $course_description = $course['Course']['course_description'];
            $school_id = $course['Course']['school_id'];*/

            $course_id = $course['course_id'];
            $course_name = $course['course_name'];
            $course_description = $course['course_description'];
            $school_id = $course['school_id'];
            ?>
            <tr>
        <td style="text-align: left;">
            <div style="width: 630px;float: left"><h3><?php echo $course_name ;?></h3>
            <?php echo $course_description ;?></div>

        <span style="float: right"></span><a class="btn" href="<?php echo $this->Html->url('/teacher/view_lesson_plan').'/'.$course_id."" ;?>">
            View Lesson Plan
        </a></span>

</td></tr>

            <?php

        }
        ?>
        </tbody>
    </table>
</div>
