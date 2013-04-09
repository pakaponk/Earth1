

<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Show all Classroom
    <span style="float: right">
            <a class="btn btn-primary" href="<?php echo $this->Html->url(array(
                'controller' => 'classrooms',
                'action'     => 'create'
            ));?>">Create new classroom</a>
</span>
</h3>

<div style="padding: 10px;width: 700px;margin: 0px auto">

<table class=" table table-bordered"  style="text-align: center;">
    <tr>
        <th>Grade</th>
        <th>Room</th>
        <th>Start date</th>
        <th>End date</th>
        <th>Modify</th>
    </tr>

    <?php foreach($classrooms as $classroom): ?>
         <tr>
                <td><?php echo $classroom['Classroom']['grade']; ?></td>
                <td><?php echo $classroom['Classroom']['room']; ?></td>
                <td><?php echo $classroom['Classroom']['start_date']; ?></td>
                <td><?php echo $classroom['Classroom']['end_date']; ?></td>
                <td><?php echo $this->Html->link("Edit Date", array('controller' => 'classrooms','action'=> 'edit',$classroom['Classroom']['id']), array( 'class' => 'btn btn-mini')); ?>
                <?php echo $this->Html->link("Add Student", array('controller' => 'student','action'=> 'add',$classroom['Classroom']['id']), array ( 'class' => 'btn btn-mini')); ?>
                <?php echo $this->Html->link("Add Teacher", array('controller' => 'teacher','action'=> 'add',$classroom['Classroom']['id']), array ( 'class' => 'btn btn-mini')); ?></td>
         </tr>
    <?php endforeach ?>
</table>



</div>