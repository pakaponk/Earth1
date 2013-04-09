<!-- File: /app/View/Posts/index.ctp -->

<?php 
	//echo $refer;
	//debug($posts);
?>
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
