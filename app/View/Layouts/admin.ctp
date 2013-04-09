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

    //echo $this->Html->css('cake.generic');
    echo $this->Html->css('bootstrap-responsive.css');
    echo $this->Html->css('bootstrap.css');
    echo $this->Html->css('main.css');

    //echo $this->fetch('meta');
    //echo $this->fetch('css');
    //echo $this->fetch('script');
    ?>
</head>
<body style="background-color: #f9f9f9">

<div style="width: 800px;margin: 0px auto;background-color: #ffffff;padding: 10px;margin-top: 10px">
    <div style="float: left ;width: 50%"><h3>MathBlink Administrator System</h3></div>
    <div style="float: right;width:50%; border-bottom: 1px solid #d9d9d9;"><h5>
        <a href="<?php echo $this->html->url('/users/logout'); ?>">logout</a>
        <a href="<?php echo $this->html->url('/users/edit_profile')?>">edit_profile</a>
    </h5></div>

    <div style="clear: both"></div>
    <?php echo $this->Session->flash(); ?>

    <?php echo $this->fetch('content'); ?>
</div>


<?php //echo $this->element('sql_dump'); ?>

</body>
</html>