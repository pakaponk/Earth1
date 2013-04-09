<div id="title">
<h4>
    Teacher Home <small>this page contain everything you need to know</small>
</h4>
</div>

<div id="Main">
    <div id="left">
        <div id="xx" style="color:#666"><h4><i class="icon-file"></i> Your Classroom</h4></div>

    </div>

    <div id="right">
        <!--<div id="innerRight">
            <div id="headerText"><h5><i class="icon-th-large"></i> Point</h5></div>
            <div id="seemore">See more</div>
        </div>-->

        <div id="innerRight">
            <div id="headerText" style="float: left"><h4><i class="icon-road"></i> Leader Board</h4></div>
            <div id="seemore" style="float: right;padding-top: 15px"><?php echo $this->Html->link("See all",array('controller' => 'teacher','action' => 'leaderboard')) ?></div>
            <div style="clear: both"></div>
            <?php $left_right=0;$classrooms_num = count($leaderboards)-1;for ($j = 0;$j < $classrooms_num;$j++): ?>
                <?php if($left_right%2 == 0): ?>
                    <div id="subLeft">
                        <table class="table table-hover" id="rank">
                            <th><?php echo "Classroom : " . $leaderboards['Classroom'][$j]['Classroom']['grade'] . "/" . $leaderboards['Classroom'][$j]['Classroom']['room'];?></th>
                            <?php for ($i=0;$i<3;$i++): ?>
                                <tr bgcolor="#FBFBFB"><td><strong><?php echo $i+1 . ". " . $leaderboards[$j][$i]['User']['first_name'] . " " . $leaderboards[$j][$i]['User']['last_name']; ?></strong></td></tr>
                            <?php endfor ?>
                        </table>
                    </div>
                <?php endif ?>

                <?php if($left_right%2 == 1): ?>
                    <div id="subRight">
                        <table class="table table-hover" id="rank">
                            <th><?php echo "Classroom : " . $leaderboards['Classroom'][$j]['Classroom']['grade'] . "/" . $leaderboards['Classroom'][$j]['Classroom']['room'];?></th>
                            <?php for ($i=0;$i<3;$i++): ?>
                                <tr bgcolor="#FBFBFB"><td><strong><?php echo $i+1 . ". " . $leaderboards[$j][$i]['User']['first_name'] . " " . $leaderboards[$j][$i]['User']['last_name']; ?></strong></td></tr>
                            <?php endfor ?>
                        </table>
                    </div>
                <?php endif ?>

            <?php $left_right++; ?>
            <?php endfor ?>

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
            <!--<div id="seemore">See more</div>-->
        </div>

    </div>
    <div style="clear:both"></div>
</div>