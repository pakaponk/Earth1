<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Edit Date Classroom<h3>

    <div style="padding: 10px;width: 700px;margin: 0px auto;">

        <?php
        echo $this->Form->create();
        echo $this->Form->input('start_date');
        echo $this->Form->input('end_date');


        echo $this->Form->submit('Edit',array(
            'class' => 'btn btn-large btn-primary',
            'title' => 'Send message'
        ));
        ?>

        <?php
        echo $this->Form->end();
        ?>

    </div>