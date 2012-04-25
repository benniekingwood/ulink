<div class="contentInner">
    <div id="leftContent">
        <div class="user-rating">
            <div class="userName">

                <?php
                if ($Review['User']['image_url'] == "" || !is_file($html->url('/app/webroot/img/files/users/' . $Review['User']['image_url']))) {
                    $Review['User']['image_url'] = "noImage.jpg";
                }
                ?> 

                <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/users/<?php echo $Review['User']['image_url']; ?>&w=50&h=50" />



                <a href="<?php e($html->url('/users/userinfo/' . $Review['User']['id'] . '')); ?>"><?php echo ucwords($Review['User']['firstname']); ?></a></div>

            <div class="rating">
                <span class="right"><?php echo $html->image('star-' . $Review['Review']['rating'] . '.gif', array('title' => $Review['Review']['rating'] . ' star')); ?></span>
                <span class="right">Rating</span>
            </div>
            <div class="clear"></div>
        </div>
        <div class="grayBox">
            <div class="top">
                <span class="right"><?php echo $html->image('gray-box-top-right.gif', array('alt' => '')); ?></span>
                <span class="left"><?php echo $html->image('gray-box-top-left.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <div class="content">
                <?php echo $Review['Review']['description']; ?>
            </div>
            <div class="bottom">
                <span class="left"><?php echo $html->image('gray-box-bottom-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $html->image('gray-box-bottom-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="boxBottom">


            <div class="date"><?php echo date("d M, Y ", strtotime($Review['Review']['created'])); ?></div>
            <div class="links">

                <a href="<?php e($html->url('/reviews/allvideoreview/' . $Review['School']['id'] . '')); ?>">

					Video Reviews</a>  |  <a href="<?php e($html->url('/schools/detail/' . $Review['School']['id'] . '')); ?>">School Information</a>
            </div>
            <div class="clear"></div>
        </div>
        <br />
        <div class="txtCenter"><?php echo $html->image('advertisement-hor.gif', array('alt' => '')); ?></div>
    </div>
    <div id="rightContent">
        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $html->image('recent-heading-left.gif', array('alt' => '')); ?></span>
                <h1>Other Written Reviews</h1>
                <span class="right"><?php echo $html->image('recent-heading-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <div class="content">
                <?php if (!empty($Othereview)) { ?>
                    <ul class="writtenReviews">

                        <?php
                        $z = 1;
                        $k = 0;
                        $e = 1;
                        foreach ($Othereview as $othereview) {
                            if ($z == count($Othereview)) {
                                $class = "no-border";
                            } else {
                                $class = " ";
                            }
                            ?>
                            <li class="<?php echo $class; ?>" >
                                <span class="left"><a href="<?php echo $othereview['Review']['id']; ?>"><?php echo $othereview['Review']['title']; ?></a></span>
                                <span class="right"><?php echo $html->image('review_star_' . $othereview['Review']['rating'] . '.png', array('title' => $othereview['Review']['rating'] . ' star')); ?></span>
                                <span class="content">
                                    <?php echo $showIntro = substr($othereview['Review']['description'], 0, 80); ?>...
                                </span>
                                <span class="right"><a href="<?php echo $othereview['Review']['id']; ?>" class="home_read"><div class="read_more">Read More</div></a></span>
                            </li>
                            <li class="clear"></li>
                            <?php
                            $z++;
                            $k++;
                            if ($k == 2)
                                break;
                        }
                        ?>
                    </ul>

<?php } else { ?>
                    <ul class="writtenReviews">

                        <span class="left">No Other Written Reviews Found</span>

                    </ul>
<?php } ?>
                <div class="clear"></div>
            </div>
            <div class="bottom">
                <span class="left"><?php echo $html->image('recent-bottom-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $html->image('recent-bottom-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <a href="<?php e($html->url('/reviews/alltextreview/' . $Review['School']['id'] . '')); ?>" class="viewAll">View All Reviews </a>
            <div class="clear"></div>
        </div>
        <br />


        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $html->image('recent-heading-left.gif', array('alt' => '')); ?></span>
                <h1>Other Video Reviews</h1>
                <span class="right"><?php echo $html->image('recent-heading-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
                <?php if (count($VideoReviewCaps)) { ?>	
                <div class="content">

    <?php for ($m = 0; $m < count($VideoReviewCaps); $m++) { ?>
                        <div class="videoListing">

                            <a href="<?php e($html->url('/reviews/videoreview/' . $OtheerVideoReview[$m]['Review']['id'] . '')); ?>"><?php echo $VideoReviewCaps[$m]['image_thumb'][0]; ?></a>
                            <span>
                                <a href="<?php e($html->url('/reviews/videoreview/' . $OtheerVideoReview[$m]['Review']['id'] . '')); ?>"><?php echo substr($OtheerVideoReview[$m]['Review']['title'], 0, 15); ?><?php if (strlen($OtheerVideoReview[$m]['Review']['title']) > 15)
                            echo "..."; ?></a><br />
        <?php echo number_format($VideoReviewCaps[$m]['count'][0]); ?> views<br />
        <?php echo $html->image('review_star_' . $OtheerVideoReview[$m]['Review']['rating'] . '.png', array('title' => $OtheerVideoReview[$m]['Review']['rating'] . ' star')); ?>
                            </span>
                            <div class="clear"></div>
                        </div>

                <?php } ?>	
                </div>
<?php } else { ?>
                <div class="content">
                    <ul class="writtenReviews">
                        <span class="left">No Other Video Reviews Found</span>
                    </ul>
                    <div class="clear"></div>
                </div>
<?php } ?>

            <div class="bottom">
                <span class="left"><?php echo $html->image('recent-bottom-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $html->image('recent-bottom-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <a href="<?php e($html->url('/reviews/allvideoreview/' . $Review['School']['id'] . '')); ?>" class="viewAll">View All Reviews </a>
            <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
</div>