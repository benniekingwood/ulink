<?php
echo $this->Html->script(array('jquery_004.js', 'jquery_013.js', 'global_fn.js'));
echo $this->Html->css(array('jquery_thumbs.css'));
?>
<script type="text/javascript">
    /* <![CDATA[ */
    $(document).ready(function() {
        var numSlides = $('#features').find('li').not('li ul li').length;
	
        $('#features').jcarousel({
            scroll: 1,
            auto: 8,
            easing: 'easeOutCirc',
            //animation: 'fast',
            //indicator_label: 'Features',
            skin: '.jcarousel-skin-widefeature',
            //size: numSlides,
            visible: 1,
            wrap: 'both',
            //initCallback: jcarousel_initCallback,
            itemFirstInCallback: jcarousel_itemFirstInCallback
            /*itemVisibleInCallback: {onBeforeAnimation: jcarousel_itemVisibleInCallback},
                        itemVisibleOutCallback: {onAfterAnimation: jcarousel_itemVisibleOutCallback}*/
        });
        //searchbox init
        $('#searchterms2').autocompletecho( birdnames, { minChars:2, width:250, matchContains:true, matchSubset:true, max:50, cacheLength:20
        });
        $("#searchterms2").keypress(function (e) {  
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {  
                e.preventDefault();
                $("#searchbutton2").trigger("click");
            }
        });
		
    });
    function BirdGuideSearch(div) {
        var name = $("#"+div).val();
        goToBird(name);
    }
    /* ]]> */
</script>

<div class="contentInner">
    <!-- html of player and slider starts here -->

    <div id="playerListing">
        <div class="player">
            <object width="958" height="403">
                <param name="movie" value="http://www.youtube.com/v/<?php echo $VideoReview[0]['Review']['link']; ?>?fs=1&autoplay=1&rel=0"</param>
                <param name="allowFullScreen" value="true"></param>
                <param name="wmode" value="transparent">
                <param name="allowScriptAccess" value="always"></param>
                <embed src="http://www.youtube.com/v/<?php echo $VideoReview[0]['Review']['link']; ?>?fs=1&autoplay=1&rel=0"
                       type="application/x-shockwave-flash"
                       allowfullscreen="true"
                       allowscriptaccess="always"
                       wmode="transparent" 
                       width="958" height="403">
                </embed>
            </object>
        </div>

        <div class="videoThumbs">
            <div class="totalVideos"><span>Total no. of videos: <?php echo $e = count($VideoReviewCaps); ?></span></div>
            <div class="clear"></div>
            <div class="jcarousel-skin-widefeature">
                <div class="jcarousel-clip jcarousel-clip-horizontal">
                    <ul id="features" class="jcarousel-list jcarousel-list-horizontal">
                        <?php $j = 0;
                        for ($j = 0; $j < count($VideoReviewCaps); $j++) { ?>
                            <?php
                            if ($j == 0) {
                                echo "<li jcarouselindex='1' class='jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal'>";
                                $fli = "0";
                            }
                            ?>
                            <?php
                            if (($j % 6 == 0 && $j != 1 && $fli == "1") || ($li == "0")) {
                                echo "<li>";
                                $li = "1";
                                $start = 0;
                            } $start++;
                            ?>
                            <a class="videoListingThumbs" href="<?php echo($this->Html->url('/reviews/videoreview/' . $OtherVideoReview[$j]['Review']['id'] . '')); ?>"><?php echo $VideoReviewCaps[$j]['image_thumb'][0]; ?><br /><strong><?php echo substr($OtherVideoReview[$j]['Review']['title'], 0, 15); ?></strong><br /><?php echo substr($OtherVideoReview[$j]['Review']['description'], 0, 12); ?></a>
                            <?php
                            if (($li == "1" && $start == "6") or ($j == 5) or ($i == $e)) {
                                echo "</li>";
                                $li = "0";
                                $fli = "1";
                            }
                            ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- html of player and slider ends here -->

    <div id="leftContent">
        <div class="user-rating">

            <div class="userName">

                <?php
                if ($VideoReview[0]['User']['image_url'] == "" || !is_filecho($this->Html->url('/app/webroot/img/files/users/' . $VideoReview[0]['User']['image_url']))) {
                    $VideoReview[0]['User']['image_url'] = "noImage.jpg";
                }
                ?>  
                <img alt="profile picture" border="0" src="<?php echo($this->Html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/users/<?php echo $VideoReview[0]['User']['image_url']; ?>&w=50&h=50" />

                <a href="<?php echo($this->Html->url('/users/userinfo/' . $VideoReview[0]['User']['id'] . '')); ?>"><?php echo ucwords($VideoReview[0]['User']['firstname']); ?></a></div>
            <div class="rating">
                <span class="right"><?php
                if ($VideoReview[0]['Review']['rating'] == 0) {
                    echo ": No rating yet";
                } else {
                    echo $this->Html->image(('star-' . $VideoReview[0]['Review']['rating'] . '.gif', array('title' => $VideoReview[0]['Review']['rating'] . ' star'));
                }
                ?></span>
                <span class="right">Rating</span>
            </div>
            <div class="clear"></div>
        </div>
        <div class="grayBox">
            <div class="top">
                <span class="left"><?php echo $this->Html->image(('gray-box-top-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $this->Html->image(('gray-box-top-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <div class="content">
                <?php echo $VideoReview[0]['Review']['description']; ?>
            </div>
            <div class="bottom">
                <span class="left"><?php echo $this->Html->image(('gray-box-bottom-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $this->Html->image(('gray-box-bottom-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="boxBottom">
            <div class="date"><?php echo datecho("d M, Y ", strtotimecho($VideoReview[0]['Review']['created'])); ?></div>
            <div class="links">
                <a href="<?php echo($this->Html->url('/reviews/alltextreview/' . $VideoReview[0]['School']['id'] . '')); ?>">Written Reviews</a>  |  <a href="<?php echo($this->Html->url('/schools/detail/' . $VideoReview[0]['School']['id'] . '')); ?>">School Information</a>
            </div>
            <div class="clear"></div>
        </div>
        <br />
        <div class="txtCenter"><?php echo $this->Html->image(('advertisement-hor.gif', array('alt' => '')); ?></div>
    </div>



    <div id="rightContent">
        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $this->Html->image(('recent-heading-left.gif', array('alt' => '')); ?></span>
                <h1>Other Written Reviews</h1>
                <span class="right"><?php echo $this->Html->image(('recent-heading-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <div class="content">
                <ul class="writtenReviews">

                    <?php
                    $i = 1;
                    foreach ($OtherWrittenReview as $otherWrittenReview) {

                        if ($i == count($OtherWrittenReview)) {
                            $class = "no-border";
                        } else {
                            $class = " ";
                        }
                        ?>
                        <li class="<?php echo $class; ?>">
                            <span class="left"><a href="<?php echo($this->Html->url('/reviews/textreview/' . $otherWrittenReview['Review']['id'] . '')); ?>"><?php echo substr($otherWrittenReview['Review']['title'], 0, 15); ?>
                                    <?php if (strlen($otherWrittenReview['Review']['title']) > 15)
                                        echo "..."; ?></a></span>
                            <span class="right"><?php
                                if ($otherWrittenReview['Review']['rating'] == 0) {
                                    echo "No rating yet";
                                } else {
                                    echo $this->Html->image(('review_star_' . $otherWrittenReview['Review']['rating'] . '.png', array('title' => $otherWrittenReview['Review']['rating'] . ' star'));
                                }
                                    ?></span>
                            <span class="content">
                                <?php echo substr($otherWrittenReview['Review']['description'], 0, 40); ?>...
                            </span>
                            <span class="right"><a href="<?php echo($this->Html->url('/reviews/textreview/' . $otherWrittenReview['Review']['id'] . '')); ?>" class="home_read"><div class="read_more left">Read More</div></a> &nbsp;</a></span>
                        </li>                                                                                                                  
                        <?php $i++;
                    } ?>
                    <li class="clear"></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="bottom">
                <span class="left"><?php echo $this->Html->image(('recent-bottom-left.gif', array('alt' => '')); ?></span>
                <span class="right"><?php echo $this->Html->image(('recent-bottom-right.gif', array('alt' => '')); ?></span>
                <div class="clear"></div>
            </div>
            <a href="<?php echo($this->Html->url('/reviews/alltextreview/' . $otherWrittenReview['School']['id'] . '')); ?>" class="viewAll">View All Reviews </a>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>