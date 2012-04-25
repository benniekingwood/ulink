<style type="text/css">
    #slider{ width:85% !important; }
    #slider ul{ width:460px; !important; list-style:none; line-height:18px; }
    #slider, #slider li{ width:460px; height:100% !important; overflow:hidden; text-align:justify; margin-bottom:10px;}
    span#nextBtn, span#nextBtn a {
        background: url("../../img/nextBtn.gif") no-repeat scroll 0 0 transparent !important;
        float: left;
        font-size: 0;
        height: 27px;
        text-decoration: none;
        width: 32px;
    }

    span#prevBtn, span#prevBtn a {
        background: url("../../img/backBtn.gif") no-repeat scroll 0 0 transparent !important;
        float: left;
        font-size: 0;
        height: 27px;
        text-decoration: none;
        width: 32px;
    }
</style>

<script type="text/javascript">
        $(document).ready(function(){
                $("#slider").easySlider({
                        prevText:'UP',
                        nextText:'DOWN',
                        orientation:'horizontal'
                });
        });
</script>

<div class="contentInner">
    <div id="leftContent">
        <div class="rating">
            <span class="right"><?php
						
						
						if($School['School']['cityother']=="")
						{
							$city=$School['City']['name'];
						}
						else
						{
							$city=$School['School']['cityother'];
							
						}
						
						
						if($School['School']['stateother']=="")
						{
							$state=$School['State']['name'];
						}
						else
						{
							$state=$School['School']['stateother'];
							
						}
						
						
					if(empty($School['School']['rating'])){
						echo ": No rating yet";
						} else {?><?php 
						echo $html->image('star-'.$School['School']['rating'].'.gif',array('title'=>$School['School']['rating'].' star'));?><?php }?></span>
            <span class="right">Rating</span>
        </div>
        <div class="clear"></div>
        <div class="info">
            <div class="inner">
                <div class="innerContent"><?php echo $School['School']['description']; ?>

                    <div class="links">
                        <a href="<?php e($html->url('/reviews/allvideoreview/'.$School['School']['id'].'')); ?>">Video Reviews </a>
								 |  <a href="<?php e($html->url('/reviews/alltextreview/'.$School['School']['id'].'')); ?>">Written Reviews</a>
								  |<a href="<?php e($html->url('/maps/map_index/'.$School['School']['id'])); ?>">&nbsp;View Map</a>
                    </div>
                    <div class="clear"></div>
                    <br />
                    <div class="txtCenter"><?php echo $html->image('advertisement-hor.gif',array('alt'=>''));?></div>
                </div>
            </div>
        </div>
    </div>

    <div id="rightContent">
				<?php if($img_count=count($School['Image'])) { ?>
        <div class="picGallery">
            <div id="slider">
                <ul>
					 	<?php  for($j=0;$j<count($School['Image']);$j++){ ?>
                    <li style="float:none;">
                        <div class="selectedPic">
                            <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/test/<?php echo $School['Image'][$j]['url'];?>&w=283&h=283" />
                        </div>
                    </li>
						<?php }  ?>
                </ul>
            </div>	
            <div class="nav">
                <div class="right">(  <?php echo $img_count; ?> Pictures )</div>
                <div class="clear"></div>
            </div>
        </div>
				<?php } ?>


        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $html->image('recent-heading-left.gif',array('alt'=>''));?></span>
                <h1>School Details</h1>
                <span class="right"><?php echo $html->image('recent-heading-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>

            <div class="content">


                <div class="videoListing">
                                                                        <?php 
                                                                            if ($School['School']['image_url'] == "" || !is_file($html->url('/app/webroot/img/files/users/'.$School['School']['image_url'])) ) {
                                                                                $School['School']['image_url'] = "noImage.jpg";
                                                                            }
                                                                        ?>  
                    <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $School['School']['image_url'];?>&w=68&h=50" />
                    <span>
                        <label class="detail_desp">Address:</label><label class="detail_school"><?php echo $School['School']['address']; ?> <br /> <?php echo "".$city.",".$state." ".$School['School']['zipcode']?> <br />
                                                                                                <?php echo $School['Country']['countries_name'];?></label>
                        <div class="clear"></div>
                        <label class="detail_desp">Foundation Year:</label><label class="detail_school"><?php echo $School['School']['year'];?></label>
                        <div class="clear"></div>
                        <label class="detail_desp">Attendence:</label><label class="detail_school"><?php echo $School['School']['attendence'];?></label>
                    </span> 
                    <div class="clear"></div>
                </div>

            </div>


            <div class="bottom">
                <span class="left"><?php echo $html->image('recent-bottom-left.gif',array('alt'=>''));?></span>
                <span class="right"><?php echo $html->image('recent-bottom-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>

        </div>

        <div class="clear"></div>
        <div>&nbsp;</div>

        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $html->image('recent-heading-left.gif',array('alt'=>''));?></span>
                <h1>Recent Video Reviews</h1>
                <span class="right"><?php echo $html->image('recent-heading-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>

            <div class="content">
						<?php if(count($VideoReviewCaps) != 0) {?>
							<?php  for($m=0;$m<count($VideoReviewCaps); $m++){  ?>
                <div class="videoListing">

                    <a href="<?php e($html->url('/reviews/videoreview/'.$RecentVideoReview[$m]['Review']['id'].'')); ?>"><?php echo $VideoReviewCaps[$m]['image_thumb'][0]; ?></a>
                    <span>
                        <a href="<?php e($html->url('/reviews/videoreview/'.$RecentVideoReview[$m]['Review']['id'].'')); ?>"><?php echo substr($RecentVideoReview[$m]['Review']['title'],0,15); ?><?php if(strlen($RecentVideoReview[$m]['Review']['title'])>15 ) echo "..."; ?></a><br />
									<?php echo number_format($VideoReviewCaps[$m]['count'][0]); ?> views<br />
									<?php 
									
									if($RecentVideoReview[$m]['Review']['rating'] == 0){
						            echo "No rating yet";
						            } else {
									echo $html->image('review_star_'.$RecentVideoReview[$m]['Review']['rating'].'.png',array('title'=>$RecentVideoReview[$m]['Review']['rating'].' star')); }?>
                    </span>
                    <div class="clear"></div>
                </div>

						<?php } ?>	
						<?php } else {?>
                <div class="videoListing"><span>No video reviews yet</span></div>
						<?php } ?>	
            </div>

            <div class="bottom">
                <span class="left"><?php echo $html->image('recent-bottom-left.gif',array('alt'=>''));?></span>
                <span class="right"><?php echo $html->image('recent-bottom-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>
					<?php if(count($VideoReviewCaps) != 0) {?>	<a href="<?php e($html->url('/reviews/allvideoreview/'.$School['School']['id'].'')); ?>" class="viewAll">View All Listings</a>
					<?php } ?>
        </div>

        <div class="clear"></div>
        <div>&nbsp;</div>

        <!--Recent text reviews-->
        <div class="recent">
            <div class="heading">
                <span class="left"><?php echo $html->image('recent-heading-left.gif',array('alt'=>''));?></span>
                <h1>Recent Written Reviews</h1>
                <span class="right"><?php echo $html->image('recent-heading-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>

            <div class="content">
							<?php if(count($OtherWrittenReview) != 0) {      // to show message count ?>
                <ul class="writtenReviews">
								<?php  $i=1;foreach($OtherWrittenReview as $otherWrittenReview){
									
									if($i==count($OtherWrittenReview))
									{
										$class="no-border";
									}
									else 
									{
										$class=" ";
										
									}
									
									  ?>
                    <li class="<?php echo $class; ?>">
                        <span class="left"><a href="<?php e($html->url('/reviews/textreview/'.$otherWrittenReview['Review']['id'].'')); ?>"><?php echo substr($otherWrittenReview['Review']['title'],0,15); ?>
							<?php if(strlen($otherWrittenReview['Review']['title'])>15 ) echo "..."; ?></a></span>
                        <span class="right"><?php $i++;
							
							if($otherWrittenReview['Review']['rating'] == 0){
						            echo "No rating yet";
						            } else {
							
							echo $html->image('review_star_'.$otherWrittenReview['Review']['rating'].'.png',array('title'=>$otherWrittenReview['Review']['rating'].' star')); }?></span>
                        <span class="content">
								<?php echo substr($otherWrittenReview['Review']['description'],0,40); ?>...
                        </span>
                        <span class="right"><a href="<?php e($html->url('/reviews/textreview/'.$otherWrittenReview['Review']['id'].'')); ?>"  class="home_read"><div class="read_more">Read More</div></a></span>
                    </li>                                                                                                                  
								<?php } ?>
                    <li class="clear"></li>
                </ul>
							<?php } else { ?>
                <div class="videoListing"><span>No text reviews yet</span></div>
								 <?php }  ?>

                <div class="clear"></div>
            </div>

            <div class="bottom">
                <span class="left"><?php echo $html->image('recent-bottom-left.gif',array('alt'=>''));?></span>
                <span class="right"><?php echo $html->image('recent-bottom-right.gif',array('alt'=>''));?></span>
                <div class="clear"></div>
            </div>
						<?php if(count($OtherWrittenReview) != 0) { ?> <a href="<?php e($html->url('/reviews/alltextreview/'.$School['School']['id'].'')); ?>" class="viewAll">View All Reviews</a> <?php } ?>
        </div>

        <!--ends-->

    </div>
    <div class="clear"></div>
</div>