<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Mathblink.com');
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap-responsive.css');
    echo $this->Html->css('bootstrap.css');
    echo $this->Html->css('main.css');
    ?>
    <script type="text/javascript"
src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
<script type="text/x-mathjax-config">
MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
</script>
</head>
<body>
<?php echo $this->element('student_menu') ; ?>
<div id="wrapper">
    <!--<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>-->

    <?php echo $this->Session->flash(); ?>

    <?php echo $this->fetch('content'); ?>

</div>



<?php echo $this->element('footer') ; ?>
<!--
	<div style="width:700px;padding:5px;margin:auto;background-color:#999">
		<?php echo $this->element('sql_dump'); ?>
	</div>
	-->

</body>
</html>
