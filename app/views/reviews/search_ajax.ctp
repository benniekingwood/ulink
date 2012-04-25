<div class="content">
    <h1 style="float:left">Reviews</h1>
    <div class="clear"></div>
    <?php
    $total = count($serchResultsReviews);
    if ($total) {
        ?>
        <?php
        for ($i = 0; $i < $total; $i++) {
            if ($serchResultsReviews[$i]['School']['image_url'] == "") {
                $serchResultsReviews[$i]['School']['image_url'] = "noImage.jpg";
            }
            ?>

            <div class="content">
                <div class="info">
                    <div class="inner">
                        <div class="innerContent">

                            <div class="userProfileimage">
                            <?php echo $html->image('files/schools/' . $serchResultsReviews[$i]['School']['image_url'] . '', array('alt' => '', 'height' => '112', 'width' => '112')); ?>


                            </div>
        <?php if ($serchResultsReviews[$i]['Review']['type'] == 'text') { ?>
                                <div class="searchresult"><strong>Title :</strong><a href="textreview/<?php echo $serchResultsReviews[$i]['Review']['id']; ?>"><?php echo $serchResultsReviews[$i]['Review']['title']; ?></a></div> <?php } else { ?>
                                <div class="searchresult"><strong>Title :</strong><a href="videoreview/<?php echo $serchResultsReviews[$i]['Review']['id']; ?>"><?php echo $serchResultsReviews[$i]['Review']['title']; ?></a></div>
        <?php } ?>
                            <div class="searchresult"><strong>Rating :</strong><?php echo $html->image('star-' . $serchResultsReviews[$i]['Review']['rating'] . '.gif', array('alt' => '')); ?></div>
                            <div class="searchresult"><strong>School :</strong><a href="<?php e($html->url('/schools/detail/' . $serchResultsReviews[$i]['School']['id'] . '')); ?>"><?php echo $serchResultsReviews[$i]['School']['name']; ?></a></div>
                            <div class="searchresult">
                                <span class="top_padd"><a href="<?php e($html->url('/reviews/' . $serchResultsReviews[$i]['Review']['type'] . 'review/' . $serchResultsReviews[$i]['Review']['id'])); ?>"><?php echo $html->image('buttonViewdetails.gif') ?></a></div>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear" style="height:20px;"></div>
        <?php
        }
    } else {

        echo "<h3>Sorry no reviews found with " . $search_srting . "</h3>";
    }
    ?>
    <div class="clear"></div>
    <div class="pagination"><span class="left"><?php
            echo $paginator->counter(array(
                'format' => 'Displaying  %start% to %end% out of %count% Reviews'
            ));
    ?></span>
        <span class="right"><div id="pagination">		
                <div >		
                    <?php
                    echo $paginator->first("<<First", array('class' => 'footer_nav', 'url' => $search_srting));
                    echo '&nbsp;&nbsp;';
                    echo $paginator->numbers(array('separator' => ' | ', 'url' => $search_srting));
                    echo '&nbsp;&nbsp;';
                    echo $paginator->last("Last>>", array('class' => 'footer_nav', 'url' => $search_srting));
                    ?>
                </div>
            </div>
        </span>
    </div>
    <div class="clear"></div>
</div>