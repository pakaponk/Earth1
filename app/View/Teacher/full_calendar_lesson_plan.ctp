<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/28/13 AD
 * Time: 3:33 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($data);
?>
<!--<link href='../fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='../fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />-->
<?php
echo $this->Html->css('fullcalendar.css');
echo $this->Html->css('fullcalendar.print.css');

echo $this->Javascript->link('jquery-ui-1.10.2.custom.min');
echo $this->Javascript->link('fullcalendar.min');
//echo $this->Javascript->link('jquery-1.9.1.min');

?>
<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Lesson Plan',array(
        'controller' => 'teacher',
        'action' => 'lesson_plan')); ?> <span class="divider">/</span></li>
    <li><?php echo $this->Html->link("Course : ".$data["Course"]["course_name"],array(
        'controller' => 'teacher',
        'action' => 'view_lesson_plan',
        $data["Course"]["course_id"])); ?> <span class="divider">/</span></li>
    <li class="active">Full Calendar View</li>
</ul>

<script>


    $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

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


            $c = count($data["Lesson"]) ;
            foreach($data["Lesson"] as $lesson):
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
                if($c !== 1) echo",";
                $c--;
            endforeach;
            ?>
            ]
        });

    });

    function add_date(startDate,endDate,name){
        //  alert(startDate+" "+endDate);
        startDate = new Date(startDate.replace(/-/g,"/"));
        endDate = new Date(endDate.replace(/-/g,"/"));
        var myEvent = {
            title:name,
            allDay: true,
            start: startDate,
            end: endDate

        };
        $('#calendar').fullCalendar( 'renderEvent', myEvent );
    }


    /*,
                    {
                        title: 'Long Event',
                        start: new Date(y, m, d-5),
                        end: new Date(y, m, d-2)
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d-3, 16, 0),
                        allDay: false
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d+4, 16, 0),
                        allDay: false
                    },
                    {
                        title: 'Meeting',
                        start: new Date(y, m, d, 10, 30),
                        allDay: false
                    },
                    {
                        title: 'Lunch',
                        start: new Date(y, m, d, 12, 0),
                        end: new Date(y, m, d, 14, 0),
                        allDay: false
                    },
                    {
                        title: 'Birthday Party',
                        start: new Date(y, m, d+1, 19, 0),
                        end: new Date(y, m, d+1, 22, 30),
                        allDay: false
                    },
                    {
                        title: 'Click for Google',
                        start: new Date(y, m, 28),
                        end: new Date(y, m, 29),
                        url: 'http://google.com/'
                    }*/
</script>

<!--
<script src='../jquery/jquery-1.9.1.min.js'></script>
<script src='../jquery/jquery-ui-1.10.2.custom.min.js'></script>
<script src='../fullcalendar/fullcalendar.min.js'></script>-->

<h3
        style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
    <?php echo $data["Course"]["course_name"] ; ?> lesson plan
    <!--<span style="float: right"> <a
        class="btn btn-primary"
        href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>-->
</h3>
<div>
    <!--<div style="padding: 0px;margin-left: 50px;margin-right: 50px;width: 350px">
        <h4>Over all lesson plan</h4>
    </div>-->
    <!--<div style="padding: 10px;margin-left: 50px;width: 350px">
        <?php echo $data["Course"]["course_description"]; ?>
    </div>-->

    <div style="padding: 10px;margin-left: 50px">
        <div id='calendar' style="width: 800px"></div>
    </div>

    <!--<div style="padding: 10px;width: 350px;margin-left: 50px" class="hero-unit">
    <?php foreach($data["Lesson"] as $lesson):
        $start = str_replace("-","/",$lesson["start_date"]);
        $end = str_replace("-","/",$lesson["end_date"]);

        ?>

        <strong>Lesson</strong> <?php echo $lesson["lesson_name"] ?><br/>
        <?php foreach($lesson["Topic"] as $topic) :?>
           <!-- <span style="margin-left: 3.5em"><strong>Topic</strong> <?php echo $topic["topic_name"] ?></span><br/>
        <?php endforeach ; ?>
    <?php endforeach ; ?>
</div>-->


</div>




<div style="clear: both"></div>