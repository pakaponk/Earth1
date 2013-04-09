<div style="width: 750px;margin: 0px auto; margin-top: 20px;">

    <div style="margin-bottom: 10px;text-align: right;">
        <a class="btn btn-large btn-primary" href="<?=$this->Html->url('index');?>">
            Home
        </a>
        <a class="btn btn-large" href="<?=$this->Html->url('about_us');?>">
            About us
        </a>
        <a class="btn btn-large" href="<?=$this->Html->url('team');?>">
            MathBlink team
        </a>
    </div>

    <div class="hero-unit">
        <h3>MathBlink team</h3>
        <p>
            Online, Freemium platform for learning and teaching mathematics in traditional education systems.
        </p>
        <br/>
        <h3>Contact MathBlink team</h3>

        <?php echo $this->Form->create('ContactMessage'); ?>
        Name<br/>
        <?php echo $this->Form->input('name',array('label'=>false,'style'=>'width:300px')); ?>
        Email<br/>
        <?php echo $this->Form->input('email',array('label'=>false,'style'=>'width:300px')); ?>
        Message<br/>
        <?php echo $this->Form->textarea('message',array('style'=>'width:300px;height:70px')); ?>

        <?php
        echo $this->Form->submit('Send us message',array(
        'class' => 'btn btn-large btn-primary',
        'title' => 'Send message'
        ));
        ?>
        <?php echo $this->Form->end(); ?>


    </div>
</div>
