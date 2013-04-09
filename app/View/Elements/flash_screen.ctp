<div id='loadingDiv' style="display:none;color: #FFF;">
    <div style="margin:0px auto;margin-top: 300px;"><h1><strong>Loading...</strong></h1></div>
</div>

<div id='finish_create_problemset' class="fullScreen" style="display:none;color: #333333;">
    <div style="margin:0px auto;margin-top: 200px; background-color: #ffffff;padding: 10px;width: 500px;opacity: 0.95">
        <h1><strong>Finish !!</strong></h1>
        <h3>You can go to Problem set manager <a href="<?php echo $this->Html->url(array(
            'controller' => 'teacher',
            'action'    => 'problemset_main'
        ));?>">here</a></h3>
    </div>
</div>


<div class="fullScreen" id="bg" style="display: none" onclick="close_bg()"></div>