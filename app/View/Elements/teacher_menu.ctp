<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="#">MathBlink</a>

            <ul class="nav">
                <li class="divider-vertical"></li>
                <li <?php if($this->action == 'index' && $this->params['controller'] == 'Teacher') {?>class="active" <?php } ?>>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'Teacher',
                        'action' => 'index'
                    ));?>"><strong>Home</strong></a>
                </li>
                <li class="divider-vertical"></li>
                <li <?php if($this->action == 'problemset_main') {?>class="active" <?php } ?>>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'Teacher',
                        'action' => 'problemset_main'
                    ));?>"><strong>Problem Set</strong></a>
                </li>
                <li class="divider-vertical"></li>
                <li <?php if($this->action == 'class_report') {?>class="active" <?php } ?>>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'Teacher',
                        'action' => 'class_report'
                    ));?>"><strong>Class Report</strong></a>
                </li>
                <li class="divider-vertical"></li>
                <li <?php if($this->action == 'index' && $this->params["controller"] == "lesson_plan") {?>class="active" <?php } ?>>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'lesson_plan',
                        'action' => 'index'
                    ));?>"><strong>Lesson Plan</strong></a>
                </li>
                <li class="divider-vertical"></li>
                <li <?php if($this->action == 'index' && $this->params["controller"] == "leader_board") {?>class="active" <?php } ?>>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'leader_board',
                        'action' => 'index'
                    ));?>"><strong>Leader Board</strong></a>
                </li>
                <li class="divider-vertical"></li>

            </ul>


            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse">
                <div style="width: 170px;float: right;height:40px;color: #666666">
                    Welcome <strong>Teacher</strong><br/>
                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'Users',
                        'action' => 'logout'
                    ));?>">Logout</a>
                </div>
                <!-- .nav, .navbar-search, .navbar-form, etc -->
            </div>

        </div>
    </div>
</div><br/>


