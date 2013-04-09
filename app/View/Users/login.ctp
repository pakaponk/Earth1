<div style="clear:both"></div>

<div id="main_login_form">


        <div class="hero-unit">

        <?php //echo $this->Session->flash('auth'); ?>
        <?php echo $this->Form->create('User'); ?>
        <?php //echo __('Please enter your username and password'); ?>

       <div id="login_field">Username</div>
        <?php
        echo $this->Form->input('username',array('label' => false));
        ?>
        <br/>
        <div id="login_field">Password</div>
        <?php
        echo $this->Form->input('password',array('label' => false));
        ?>
        <br/>
        <?php

        echo $this->Form->submit('Login',array(
            'class' => 'btn btn-large',
            'title' => 'Login'
        ));
        ?>
        <?php echo $this->Form->end(); ?>
    </div>

</div>