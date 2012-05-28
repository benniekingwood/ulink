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
        
        $e = count($TopRatedSchool) - 1;
        foreach ($TopRatedSchool as $topRatedSchool) {
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
            if ($topRatedSchool['School']['image_url'] == "" || 
                    !file_exists(WWW_ROOT . '/img/files/schools/' . $topRatedSchool['School']['image_url'])) {
                $topRatedSchool['School']['image_url'] = "noImage.jpg";
            } ?>
            <div class="sliderContent">
                <span class="sliderImage">
                    <a href="schools/detail/<?php echo $topRatedSchool['School']['id']; ?>">
                        <img alt="" border="0" src="<?php echo($this->Html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $topRatedSchool['School']['image_url']; ?>&w=50&h=50" /></a>
                </span>
                <span>
                    <a class="margin_right" href="schools/detail/<?php echo $topRatedSchool['School']['id']; ?>">
                    <strong><?php echo $i+1 . '. '.$topRatedSchool['School']['name']; ?></strong></a>
                    <?php 
                        if ($topRatedSchool['School']['rating'] > 0) {
                            echo $this->Html->image(('star-' . $topRatedSchool['School']['rating'] . '.gif', array('title' => $topRatedSchool['School']['rating'] . ' star')); 
                        }
                    ?> 
                </span>
                <span class="shoolDescription">
                <?php 

                    echo substr($topRatedSchool['School']['short_description'], 0, 75); 
                    if (strlen($topRatedSchool['School']['short_description']) > 75) {
                        echo "...";
                    }
                    
                ?>
                    <span style="float:right"><a href="schools/detail/<?php echo $topRatedSchool['School']['id']; ?>" class="home_read"><div class="read_more">Read More</div></a></span>


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