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

        $e = count($Review) - 1;
        foreach ($Review as $review) {
            if ($i == 0) {
                echo "<li>";
                $fli = "0";
            }
            if (($i % 4 == 0 && $i != 1 && $fli == "1") || ($li == "0")) {
                echo "<li>";
                $li = "1";
                $start = 0;
            }
            $start++;
            if ($review['School']['image_url'] == "" ||
                    !file_exists(WWW_ROOT . '/img/files/schools/' . $review['School']['image_url'])) {
                $review['School']['image_url'] = "noImage.jpg";
            }
            ?>
            <div class="sliderContent">
                <span class="sliderImage">
                    <a href="schools/detail/<?php echo $review['School']['id']; ?>">
                        <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $review['School']['image_url']; ?>&w=50&h=50" />
                    </a>				
                </span>
                <span>
                    <a class="margin_right" href="reviews/<?php echo $review['Review']['type']; ?>review/<?php echo $review['Review']['id']; ?>">
                        <strong><?php echo substr($review['Review']['title'], 0, 40); ?></strong>
                    </a>
    <?php echo $html->image('star-' . $review['School']['rating'] . '.gif', array('title' => $review['School']['rating'] . ' star')); ?>	
                    <span class="reviewDate">Posted on <?php echo date("d M, Y ", strtotime($review['Review']['created'])); ?> by <?php echo ucwords($review['User']['firstname']); ?></span>
                </span>
                <span class="reviewDescription">
                    <?php
                    echo strip_tags(substr($review['Review']['description'], 0, 75));
                    if (strlen($review['Review']['description']) > 75) {
                        echo "...";
                    }
                    ?>
                    <span style="float:right"><a href="reviews/<?php echo $review['Review']['type']; ?>review/<?php echo $review['Review']['id']; ?>" class="home_read"><div class="read_more">Read More</div></a></span>
                </span>
            </div>
            <?php
            if (($li == "1" && $start == "4") or ($i == 3) or ($i == $e)) {
                echo "</li>";
                $li = "0";
                $fli = "1";
            }
            $i++;
        }
        ?>
    </ul>
</div>