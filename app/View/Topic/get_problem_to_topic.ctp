<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/29/13 AD
 * Time: 2:43 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($problem);
?>

<script>
    var latex_data = new Array();
</script>


<?php foreach($problem as $pb): ?>
    <div style="padding: 10px;font-size: 15px" class="hero-unit">
    <span style="font-weight: bold" class="muted">#<?php echo $pb["problem_id"] ; ?></span>
    <?php
        $arg = "";
        foreach($pb["ProblemLevel"] as $level) : ?>
        <?php echo $level["main_text"];?>
        <?php $arg .= $level["main_text"]." " ;?>
    <?php endforeach ;?>
        <?php $id = $pb["problem_id"]; ?>
        <script>
            var index = <?php echo $pb["problem_id"];?> ;
            latex_data[index] = <?php echo $arg ;?>;
        </script>
            <span id="button<?php echo $id ;?>">
            <a class="btn" href="javascript:add_problem_to_topic('<?php echo $arg ;?>','<?php echo $id ; ?>');">Add</a>
            </span>
            <script>
                var index = getProblemIndex(<?php echo $id ; ?>);
                if(problemStatus[index] == "add"){
                    changeStatus2('<?php echo $arg ;?>',<?php echo $id ; ?>);
                }
            </script>
    </div>
<?php endforeach ;?>

<script>
    //alert(latex_data.join('\n'));
    MathJax.Hub.Typeset();
</script>
