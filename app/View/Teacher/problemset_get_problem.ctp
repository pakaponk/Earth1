<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/20/13 AD
 * Time: 1:11 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($problemArr["Problem"]);

$salt = rand()%1000;
?>



    <script>
        MathJax.Hub.Typeset();
        for(var i=0;i<problemCount;i++){
            if(problemStatus[i] == "add"){
                changeStatus('$$'+ $('#latexTemp'+problemId[i]).html()+'$$' , problemId[i] );
            }
        }
    </script>

<!--<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
</script>
-->
<!--<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
</script>-->





<!--<script>
    $(function () {
        $(".latex").latex();
    });
</script>-->
<div style="width: 330px;float: left" id="problem_header">
<h3>Problem</h3>
<?php
if($problemArr == array()){
    echo "<h4 style='color: #999999'>empty problem</h4>";
}
$i=1;
?>
<table class="table table-hover" style="padding: 10px;margin-bottom: 5px">
<?php foreach($problemArr as $pbs): ?>
        <tr style="background-color: #efefef"><td><span><strong><h4><?php echo $i++ ?></h4></strong></span></td></tr>
        <?php foreach($pbs as $pb_level): ?>
            <tr><td>
                <h4>Level <?php echo $pb_level["level_id"] ; ?></h4>
            <!--<div style="font-size: 15px;text-align: left;padding: 5px;margin-bottom: 3px">-->
            <?php
                $latexTemp = str_replace("$$","",$pb_level["main_text"]);
                //pr($latexTemp);
                $arg = $pb_level["main_text"];
                $id = $pb_level["problem_level_id"];
                echo '<div class="latex">'.$pb_level["main_text"]."</div>" ;
            ?>
                <div style="visibility: hidden" id="latexTemp<?php echo $pb_level['problem_level_id'] ;?>"><?php echo $latexTemp ; ?></div>
                <span style="float: right" id="button<?php echo $id ; ?>"><a class="btn" href="javascript:addProblem('<?php echo $arg ;?>','<?php echo $id ; ?>')">Add</a></span>
            <!--</div>-->
            </td></tr>
        <?php endforeach ?>
    </div>
<?php endforeach ?>
</table>
</div>


    <div style="clear: both"></div>