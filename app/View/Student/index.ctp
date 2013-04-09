<?php
/**
 * @var $this View
 */
    echo $this->Html->script('jquery-1.9.1.min');
    echo $this->Html->script('bootstrap');
    echo $this->Html->script('bootstrap.min');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

<div id="title">
<strong>
<h4>Welcome to Class
    <?php echo $profile_data['classroom_id'] ?>
    , today is
    <?php $my_t=getdate(date("U"));
        echo $my_t['mday']. " " . $my_t['month'] . " " . $my_t['year'];
    ?>
</h4>
</strong>
</div>

<div id="Main">
    <div id="left">
        <div id="xx" style="color:#666"><h4><i class="icon-file"></i> Your Assignment</h4></div>
        <?php foreach($not_done as $assignment):?>
        <div id="innerLeft-1">
            <div id="as-name"><h4><?php echo $assignment['ProblemSet']['problemset_name']?></h4></div>

            <div id="as-button">
                <?php
                        echo $this->Html->link("Do Now!",array('controller' => 'student','action' => 'assignment',$assignment['Assignment']['id']),array('class'=>'btn btn-danger'));
                ?>
            </div>
            <div style="clear:both"></div>

            <div id="as-lesson"><h5><?php echo $assignment['ProblemSet']['Course']['course_name'];?></h5></div>

            <div id="as-problem-count"><h5><?php echo count($assignment['ProblemSet']['ProblemsetsProblem']);?> Problem(s)</h5></div>

            <div id="as-time-left"><h5>
                    <?php
                            echo $this->Time->timeAgoInWords($assignment['Assignment']['end_date'],array(
                                'accuracy' => array('second' => 'second'),
                                'end' => ''
                            ));
                    ?>
            </h5></div>
            <div style="clear:both"></div>
        </div>
        <?php endforeach ?>

        <?php foreach($done as $assignment):?>
            <div id="innerLeft-1" class="ui-state-disabled">
                <div id="as-name"><h4><?php echo $assignment['ProblemSet']['problemset_name']?></h4></div>

                <div id="as-button">
                    <!--<?php echo $this->Html->para(null,"Complete",array('class' => 'btn btn-success'));?> -->
                    <h4 style="color:#7EC40E ;">COMPLETE</h4>
                </div>
                <div style="clear:both"></div>

                <div id="as-lesson"><h5><?php echo $assignment['ProblemSet']['Course']['course_name'];?></h5></div>

                <div id="as-problem-count"><h5><?php echo count($assignment['ProblemSet']['ProblemsetsProblem']);?> Problem(s)</h5></div>

                <div id="as-time-left"><h5>
                        <?php echo "Score : " . $assignment['Score']['score'] . " / " . $assignment['Score']['question']; ?>
                    </h5></div>
                <div style="clear:both"></div>
            </div>
        <?php endforeach ?>
    </div>
    <div id="right">
        <!--<div id="innerRight">
            <div id="headerText"><h5><i class="icon-th-large"></i> Point</h5></div>
            <div id="seemore">See more</div>
        </div>-->
        <div id="innerRight">
            <div id="headerText"><h4><i class="icon-star"></i> Badges</h4></div>
            <div id="badges">

                <div>
                    <?php echo $this->Html->image('Badge1.png',array('width'=>'126px'))?>
                    <?php echo $this->Html->image('Badge2.png',array('width'=>'126px'))?>
                    <?php echo $this->Html->image('Badge3.png',array('width'=>'126px'))?>
                </div>

                <!--<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Ski_trail_rating_symbol-green_circle.svg/600px-Ski_trail_rating_symbol-green_circle.svg.png" width="100" class="img-circle" />
                <img src="http://openclipart.org/people/nlyl/nlyl_blue_circle.svg" width="100" class="img-circle" />-->

            </div>

            <!-- <div id="seemore">See more</div>-->
        </div>

        <div id="innerRight">
            <div id="subLeft">
                <div id="headerText"><h5><i class="icon-road"></i> Your Rank</h5></div>
                <ul class="nav nav-pills" id="leaderboardTab">
                    <table class="table table-hover" id="rank">
                        <?php for($i = 0;$i < count($courses);$i++): ?>
                            <?php if($i == 0): ?>
                                <tr class="highlight">
                                    <td><strong><li class="active"><a href="<?php echo "#course" . $i;?>" style="color: black"><?php echo $courses[$i]['Course']['course_name']; ?></a></li></strong></td>
                                    <td>2nd</td>
                                </tr>
                            <?php endif ?>

                            <?php if($i != 0): ?>
                                <tr class="non-highlight">
                                    <td><strong><li class="active"><a href="<?php echo "#course" . $i;?>" style="color: black"><?php echo $courses[$i]['Course']['course_name']; ?></a></li></strong></td>
                                    <td>2nd</td>
                                </tr>
                            <?php endif ?>
                        <?php endfor ?>

                        <tr class="non-highlight">
                            <td><strong><li class="active"><a href="#course1" style="color: black">Mock up</a></li></strong></td>
                            <td>2nd</td>
                        </tr>
                    </table>
                </ul>

                <script>
                    $('#leaderboardTab a').click(function (e) {
                        e.preventDefault();
                        var $now = $('#leaderboardTab tr.highlight');
                        $now.addClass('non-highlight');
                        $now.removeClass('highlight');
                        $('#leaderboardTab li.active').removeClass('active');
                        var $next =  $(this).parents('tr');
                        $next.removeClass('non-highlight');
                        $next.addClass('highlight');
                        $(this).tab('show');
                    })
                </script>

                <!--
                <table class="table table-hover nav nav-tabs" id="rank">
                    <tr bgcolor="#FCFCDC" ><td><strong><u>Supplementary Class<u></strong></td><td>2nd</td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>Fundamental Class</strong></td><td>23rd</td></tr>
                </table>
                -->
                <!--<div id="seemore">See more</div>-->
            </div>

            <div id="subRight">
                <div class="tab-content">
                    <div class="tab-pane active" id="course0">
                        <div id="headerText"><h5><i class="icon-road"></i> Leader Board</h5></div>

                        <table class="table table-hover" id="rank">
                            <?php for ($i=0;$i<3;$i++): ?>
                                <?php if($leaderboard['List'][$i]['User']['student_id'] == $leaderboard['Student']['student_id']): ?>
                                    <tr bgcolor="#fafad2"><td><strong><?php echo $i+1 . ". " . $leaderboard['List'][$i]['User']['first_name'] . " " . $leaderboard['List'][$i]['User']['last_name']; ?></strong></td></tr>
                                <?php endif ?>
                                <?php if ($leaderboard['List'][$i]['User']['student_id'] != $leaderboard['Student']['student_id']): ?>
                                    <tr bgcolor="#FBFBFB"><td><strong><?php echo $i+1 . ". " . $leaderboard['List'][$i]['User']['first_name'] . " " . $leaderboard['List'][$i]['User']['last_name']; ?></strong></td></tr>
                                <?php endif ?>
                            <?php endfor ?>
                            <?php if(!$leaderboard['be_top3']): ?>
                                <tr bgcolor="#fafad2"><td><strong><?php echo $leaderboard['Student']['rank'] . ". " . $leaderboard['Student']['first_name'] . " " . $leaderboard['Student']['last_name'];?></strong></td></tr>
                            <?php endif ?>
                        </table>
                    </div>

                    <div class="tab-pane" id="course1">
                        <div id="headerText"><h5><i class="icon-road"></i> Leader Board</h5></div>
                        <table class="table table-hover" id="rank">
                            <tr bgcolor="#FBFBFB" ><td><strong>1. Worapol Ratanapan</strong></td></tr>
                            <tr bgcolor="#FCFCDC" ><td><strong><u>2. Weeratouch Pongruengkiat<u></strong></td></tr>
                            <tr bgcolor="#FBFBFB" ><td><strong>3. Bun Suwanparsert</strong></td></tr>
                        </table>
                    </div>
                </div>
                <div id="seemore"><?php echo $this->Html->link("See more",array('controller' => 'student','action' => 'leaderboard')) ?></div>
            </div>

            <div style="clear:both"></div>

        </div>

        <div id="innerRight">
            <span id="headerText"><h4><i class="icon-th-list"></i> Lesson Plan</h4></span>
            <?php $left_right=0;foreach($courses as $course): ?>
                <?php if($left_right%2 == 0): ?>
                    <div id="subLeft">
                        <table class="table table-hover" id="rank">
                            <th><?php echo $course['Course']['course_name'];?></th>
                            <tr bgcolor="#FBFBFB" ><td>
                                    <div style="float: left;width:45%"><strong>Next Week</strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_next = count($course['LessonPlan']['Next']);
                                        for($i = 0;$i < $count_next;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['Next'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                            <tr bgcolor="#FCFCDC" ><td>
                                    <div style="float: left;width:45%"><strong><u>This Week</u></strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_this = count($course['LessonPlan']['This']);
                                        for($i = 0;$i < $count_this;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['This'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                            <tr bgcolor="#FBFBFB" ><td>
                                    <div style="float: left;width:45%"><strong>Last Week</strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_last = count($course['LessonPlan']['Last']);
                                        for($i = 0;$i < $count_last;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['Last'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                        </table>
                    </div>
                <?php endif ?>
                <?php if($left_right%2 == 1): ?>
                    <div id="subRight">
                        <table class="table table-hover" id="rank">
                            <th><?php echo $course['Course']['course_name'];?></th>
                            <tr bgcolor="#FBFBFB" ><td>
                                    <div style="float: left;width:45%"><strong>Next Week</strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_next = count($course['LessonPlan']['Next']);
                                        for($i = 0;$i < $count_next;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['Next'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                            <tr bgcolor="#FCFCDC" ><td>
                                    <div style="float: left;width:45%"><strong><u>This Week</u></strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_this = count($course['LessonPlan']['This']);
                                        for($i = 0;$i < $count_this;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['This'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                            <tr bgcolor="#FBFBFB" ><td>
                                    <div style="float: left;width:45%"><strong>Last Week</strong> :</div>
                                    <div style="float: right;width:54%">
                                        <?php
                                        $count_last = count($course['LessonPlan']['Last']);
                                        for($i = 0;$i < $count_last;$i++):
                                            ?>
                                            <div>
                                                <?php echo $course['LessonPlan']['Last'][$i];?>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                    <div style="clear: both "></div></td></tr>
                        </table>
                    </div>
                <?php endif ?>
                <?php $left_right++ ?>
            <?php endforeach ?>

            <div style="clear: both;"></div>
            <!--]<div id="seemore">See more</div>-->
        </div>
    </div> <!--Still Mock up-->
    <div style="clear:both;">
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 21/3/2556
 * Time: 15:16 น.
 * To change this template use File | Settings | File Templates.
 */
?>
</div>