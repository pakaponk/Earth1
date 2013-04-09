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
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
    <!--<script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>-->
    <!--<script type='text/javascript' src="https://raw.github.com/bigspotteddog/ScrollToFixed/master/jquery-scrolltofixed.js"></script>-->

    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap-responsive.css');
    echo $this->Html->css('bootstrap.css');
    echo $this->Html->css('main.css');
    echo $this->Html->css('zebra_datepicker.css');

    echo $this->Javascript->link('jquery-1.4.2.min');
    echo $this->Javascript->link('ajax');
    echo $this->Javascript->link('jquery.jslatex');
    echo $this->Javascript->link('zebra_datepicker');
    echo $this->Javascript->link('jquery-scrolltofixed');
    //echo $this->Javascript->link('jquery.min-1.3.2');
    echo $this->Javascript->link('MathJax.js?config=default');

    echo $this->Html->css('fullcalendar.css');
    echo $this->Html->css('fullcalendar.print.css');

    echo $this->Javascript->link('jquery-ui-1.10.2.custom.min');
    echo $this->Javascript->link('fullcalendar.min');

    ?>
   <!-- <script type="text/javascript" src="http://localhost:8888/mathblink/app/webroot/js/MathJax.js?config=TeX-AMS_HTML-full"></script>-->

    <!--<script type="text/javascript"
            src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script>-->
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
        <!--MathJax.Hub.Typeset();-->
    </script>


    <script type='text/javascript'>
        $(window).load(function(){
        $(document).ready(function() {
            //$('#problemset_queue').scrollToFixed({ marginTop: 50 , marginBottom : -20  });
            //alert("hey");
            jQuery.ajaxSetup({
                beforeSend: function() {
                    $('#loadingDiv').show();
                },
                complete: function(){
                    $('#loadingDiv').hide();
                },
                success: function() {}
            });
        });

        });
    </script>
    <!--<script>
        //
        //  Use a closure to hide the local variables from the
        //  global namespace
        //
        (function () {
            var QUEUE = MathJax.Hub.queue;  // shorthand for the queue
            var math = null;                // the element jax for the math output.

            //
            //  Get the element jax when MathJax has produced it.
            //
            QUEUE.Push(function () {
                math = MathJax.Hub.getAllJax("MathOutput")[0];
            });

            //
            //  The onchange event handler that typesets the
            //  math entered by the user
            //
            window.UpdateMath = function (TeX) {
                QUEUE.Push(["Text",math,"\\displaystyle{"+TeX+"}"]);
            }
        })();
    </script>-->
    <!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->


    <!--<script type="text/javascript"
            src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script>-->
</head>
<body>
<?php echo $this->element('flash_screen') ; ?>
<?php echo $this->element('teacher_menu') ; ?>
<div id="wrapper">
    <?php echo $this->Session->flash(); ?>
    <br/>
    <!--<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>-->


    <?php echo $this->fetch('content'); ?>
    <?php //echo $this->element('sql_dump'); ?>

</div>



<?php echo $this->element('footer') ; ?>
<!--
	<div style="width:700px;padding:5px;margin:auto;background-color:#999">
	</div>
	-->
<!--<div class="latex">
    $$\int_{0}^{\pi}\frac{x^{4}\left(1-x\right)^{4}}{1+x^{2}}dx =\frac{22}{7}-\pi$$
</div>-->

</body>
</html>
