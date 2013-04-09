<!-- File: /app/View/Posts/index.ctp -->

<?php
//echo $refer;
//debug($posts);
?>

<div style="clear:both"></div>


<div style="clear:both"></div>
<div id="title"><strong><h4>Welcome to Class 1/2 , today is 2 January 2013</h4></strong></div>

<div id="Main">
    <div id="left">
        <div id="xx" style="color:#666"><h4><i class="icon-file"></i> Your Assignment</h4></div>


        <div id="innerLeft-1" style="background-color:#FF9E9E ;">
            <div id="as-name" style="background-color:#FF7575 ;"><h4>Linear Equation</h4></div>
            <div id="as-button">
                <button class="btn btn-danger" type="button">Do Now!</button>
            </div>
            <div style="clear:both"></div>
            <div id="as-lesson"><h5>Lesson : Equation</h5></div>
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>
            <div id="as-time-left"><h5>3 days left</h5></div>
            <div style="clear:both"></div>
        </div>

        <div id="innerLeft-1" >
            <div id="as-name"><h4>Basic of Equation</h4></div>
            <div id="as-button">
                <button class="btn btn-success" type="button">See Details</button>
            </div>
            <div style="clear:both"></div>
            <div id="as-lesson"><h5>Lesson : Equation</h5></div>
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>
            <div id="as-time-left"><h5>1 week left</h5></div>
            <div style="clear:both"></div>
        </div>

        <div id="innerLeft-1" >
            <div id="as-name" ><h4>Determinant 3x3 </h4></div>
            <div id="as-button">
                <button class="btn btn-success" type="button">See Details</button>
            </div>
            <div style="clear:both"></div>
            <div id="as-lesson"><h5>Lesson : Metrix</h5></div>
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>
            <div id="as-time-left"><h5>1 week left</h5></div>
            <div style="clear:both"></div>
        </div>


        <div id="innerLeft-1" style="background-color:#F5F5F5;">
            <div id="as-name" style="background-color:#E2E3E1 ;"><h4>Basic of Matrix</h4></div>
            <div id="as-button" style="margin-top:-10px ;">
                <!--<button class="btn btn-success" type="button">Do It Now</button>-->
                <h4 style="color:#7EC40E ;">COMPLETE<br/><br/>Score : 10/10</h4>
            </div>
            <div style="clear:both"></div>
            <div id="as-lesson"><h5>Lesson : Metrix</h5></div>
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>
            <div id="as-time-left"></div>
            <div style="clear:both"></div>
        </div>


        <div id="innerLeft-1" style="background-color:#F5F5F5;">
            <div id="as-name" style="background-color:#E2E3E1 ;"><h4>Determinant 2x2</h4></div>
            <div id="as-button" style="margin-top:-10px ;">
                <!--<button class="btn btn-success" type="button">Do It Now</button>-->
                <h4 style="color:#7EC40E ;">COMPLETE<br/><br/>Score : 8/10</h4>
            </div>
            <div style="clear:both"></div>
            <div id="as-lesson"><h5>Lesson : Metrix</h5></div>
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>
            <div id="as-time-left"></div>
            <div style="clear:both"></div>
        </div>





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
                <!--<ul>
                    <li>Supplementary Class</li>
                    <li>Fundamental Class</li>
                </ul>-->
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FCFCDC" ><td><strong><u>Supplementary Class<u></strong></td><td>2nd</td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>Fundamental Class</strong></td><td>23rd</td></tr>
                </table>
                <!--<div id="seemore">See more</div>-->
            </div>

            <div id="subRight">
                <div id="headerText"><h5><i class="icon-road"></i> Leader Board</h5></div>
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FBFBFB" ><td><strong>1. Worapol Ratanapan</strong></td></tr>
                    <tr bgcolor="#FCFCDC" ><td><strong><u>2. Weeratouch Pongruengkiat<u></strong></td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>3. Bun Suwanparsert</strong></td></tr>
                </table>
                <!-- <div id="seemore">See more</div>-->
            </div>
            <div style="clear:both"></div>

        </div>

        <div id="innerRight">
            <div style="width:190px ;float: left;">
                <span id="headerText"><h4><i class="icon-th-list"></i> Lesson Plan</h4></span>
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FBFBFB" ><td><strong>Next Week</strong> : Equation Systems</td></tr>
                    <tr bgcolor="#FCFCDC" ><td><strong><u>This Week</u></strong> : Linear Inequalities</td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>Last Week</strong> : Linear Equations</td></tr>
                </table>
            </div>

            <div style="width:50%;background-color:#FFF ;float: right;"><img src="c.png"></div>

            <div style="clear: both;"></div>
            <!--<div id="seemore">See more</div>-->
        </div>

    </div>
    <div style="clear:both"></div>



</div>
<!--
<h1>Blog posts</h1>
<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>


<?php foreach ($posts as $post): ?>
<div style="width:750px;margin-bottom:5px;background-color:#ebebeb;">

      <?php echo $post['Post']['id']; ?>
        
            <?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?>
        
            <?php echo $this->Form->postLink(
    'Delete',
    array('action' => 'delete', $post['Post']['id']),
    array('confirm' => 'Are you sure?'));
    ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
        
            <?php echo $post['Post']['created']; ?>
</div>        
<?php endforeach; ?>
-->
