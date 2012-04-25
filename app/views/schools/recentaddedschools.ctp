<script type="text/javascript">
    $(document).ready(function(){
        $("#slider").easySlider({
            prevText:'UP',
            nextText:'DOWN',
            vertical:'true'
        });
    });
</script>

<div id="slider">
    <ul>
        <?php
        $i = 0;
        $start = 0;
        $li = "";

        $e = count($School) - 1;
        foreach ($School as $school) {
            if ($i == 0) {
                echo "<li>";
                $fli = "0";
            }
            if (($i % 5 == 0 && $i != 1 && $fli == "1") || ($li == "0")) {
                echo "<li>";
                $li = "1";
                $start = 0;
            } 
            $start++; 
            if ($school['School']['image_url'] == "" || 
                    !file_exists(WWW_ROOT . 'img/files/schools/' . $school['School']['image_url'])) {
                    $school['School']['image_url'] = "noImage.jpg";
            } ?>
            <div class="sliderContent">
                <span class="sliderImage">
                    <a href="schools/detail/<?php echo $school['School']['id']; ?>">
                        <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $school['School']['image_url']; ?>&w=50&h=50" /></a></span>
                <span>
                    <a class="margin_right" href="schools/detail/<?php echo $school['School']['id']; ?>">
                        <strong><?php echo $school['School']['name']; ?></strong></a>
                    <?php
                    if ($school['School']['rating'] > 0) {
                        echo $html->image('star-' . $school['School']['rating'] . '.gif', array('title' => $school['School']['rating'] . ' star'));
                    }
                    ?>
                </span>

                <span class="shoolDescription">

            <?php
            echo substr($school['School']['short_description'], 0, 75);
            if (strlen($school['School']['short_description']) > 75) {
                echo "...";
            }
            ?>

                    <span style="float:right"><a href="schools/detail/<?php echo $school['School']['id']; ?>" class="home_read"><div class="read_more">Read More</div></a></span>
                </span>
            </div>
    <?php 
  
    if (($li == "1" && $start == "5") or ($i == 4) or ($i == $e)) {
        echo "</li>";
        $li = "0";
        $fli = "1";
    }
    $i++;
} ?>
    </ul>
</div>