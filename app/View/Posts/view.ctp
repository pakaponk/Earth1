<!-- File: /app/View/Posts/view.ctp -->


<h3><?php echo $this->Html->link("Home", '/posts'); ?></h3>

<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>