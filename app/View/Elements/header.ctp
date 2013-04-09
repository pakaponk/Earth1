<?php

//pr($profile_data);

/*$data = $this->requestAction(array(
    'controller' => 'users',
    'action'    => 'index'
));*/

?>
<div id="header-warpper">
    <div id="header">
        <div id="MathBlink_Logo">
            <?php echo $this->Html->image('logo.png'); ?>
        </div>

        <?php if($profile_data){ ?>

        <div id="Profile">
            <div id="profile-pic" style="height:40px; padding:3px; width:40px; background-color:#FFF; float:left">
                <img src="http://sphotos-b.ak.fbcdn.net/hphotos-ak-snc6/230112_10151171609573813_436400646_n.jpg" width="40" />
            </div>
            <div id="profile-name" style="height:15px; width:70%; padding:5px; float:left; color:#FFF">
                <strong><?=$profile_data['first_name'];?> <?=$profile_data['last_name'];?></strong>
            </div>
            <div id="profile-status" style="height:14px; width:40%; padding:5px; float:left; color:#FFF;margin-top: -10px;">
                <strong><span class="muted"><?=ucfirst($profile_data['role']);?> Class</span></strong>
            </div>
            <div id="profile-button" style="height:14px; width:37%; margin-bottom:5px; float:left;text-align: right;">
                <a href="<?php echo $this->html->url('/users/logout'); ?>">
                    <button class="btn btn-mini btn-danger" type="button">Logout</button></a>
            </div>
            <div style="clear:both"></div>
        </div>
        <?php } ?>

        <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
</div>