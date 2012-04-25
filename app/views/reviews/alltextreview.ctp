<script type="text/javascript">
	$(document).ready(function(){
		$("#slider").easySlider({
			controlsBefore:	'<div id="autoControlsButtons">',
			controlsAfter:	'</div>',
			//prevText:'UP',
			//nextText:'DOWN',
			vertical:'true'
		});
	});
</script>

	

<style type="text/css">
#slider{ width:100% !important; }
#slider ul{ width:100% !important; list-style:none; line-height:18px; }
#slider, #slider li{ width:100%; height:350px; overflow:hidden; text-align:justify; }
.sliderContent{ float:left; width:100%; padding-bottom:10px;}
</style>
<div class="content">
<div id="blueBox">
					<div class="top">
						<span class="left"><?php echo $html->image('blue-border-box-top-left.gif',array('alt'=>''));?></span>
						<span class="right"><?php echo $html->image('blue-border-box-top-right.gif',array('alt'=>''));?></span>
						<div class="clear"></div>
					</div>
<div class="content">
	
	<div class="userProfileimage">
  <?php 
        if ($SchoolImage[0]['School']['image_url'] == "" || !is_file($html->url('/app/webroot/img/files/users/'.$SchoolImage[0]['School']['image_url'])) ) {
            $SchoolImage[0]['School']['image_url'] = "noImage.jpg";
        }
    ?>  
    <a href="<?php e($html->url('/schools/detail/'.$SchoolImage[0]['School']['id'])); ?>"><img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $SchoolImage[0]['School']['image_url'];?>&w=150&h=150" /></a>

	</div>
	
	<div class="textReviewdetails "><strong>Address:</strong><?php echo $SchoolImage[0]['School']['address'] ?></div>
	<div class="textReviewdetails "><strong>Rating:</strong><?php 
	
	 if($SchoolImage[0]['School']['rating'] == 0){
						     echo "No rating yet";
					       	} else {
	echo $html->image('star-'.$SchoolImage[0]['School']['rating'].'.gif',array('alt'=>'')); }?></div>
	<div class="textReviewdetails "><strong>Total Reviews:</strong><?php echo $Firstreview ?></div>
		
		<?php  if(isset($loggedInId)) {?>
		
	    <?php if(!isset($MyReview)){ ?>
	
			<?php if(isset($MySchool)){ ?>	
		
		
			<div class="textReviewdetails noBorder">
			<a href="javascript:void(0);" id="writeAreviewNew" class="poplight suggestSchool">
			
			
			<?php echo $html->image('write-a-review.gif',array('alt'=>'')); ?></a></div>
			<?php } ?>

	<?php } else { ?>
	
		<?php if (isset($ApprovalPending)) {?> 
			<div class="textReviewdetails noBorder">Your review is being reviewed by moderator</div>
		<?php } else { ?>
		
			<div class="textReviewdetails left">
				<a href="javascript:void(0);" id="writeAreviewNew" class="poplight suggestSchool">
		
			<?php echo $html->image('modify.gif',array('alt'=>'')); ?></a>
			</div>
			
			<?php } ?>
	
	<?php }  ?>
	
	<?php } else { ?>
			<div class="textReviewdetails noBorder"><a href="javascript:void(0)" class="loginBoxPopup"><?php  echo $html->image('write-a-review.gif',array('alt'=>''));?></a></div>	
	<?php } ?>
	
	
	<div class="clear"></div>
	
		<?php 
		if(!empty($Alltextreview))
		{
		if($img_count=count($Alltextreview)) { ?>
	
		<div class="reviewSlider"><span class="showing">Showing total <?php echo $Firstreview; ?></span><span id="prevBtn"><a href="javascript:void(0);"></a></span><span id="nextBtn"><a href="javascript:void(0);"></a></span></div>
	<div class="clear"></div>
	
	
	<div id="slider">
				<ul>
					<?php $i=0;
						$e=count($Alltextreview)-1;
		     foreach($Alltextreview as $alltextreview){  ?>
		
		  <?php if($i==0){echo "<li>"; $fli="0";} 
									  if(($i%3==0 && $i!=1 && $fli=="1") || ($li=="0")){ echo "<li>"; $li="1"; $start=0; } $start++; ?>    
									  
		<div class="sliderContent">
		<div class="allreviewContainer">
		<div class="reviewHeading"><?php echo $alltextreview['Review']['title']; ?></div>
		<div class="clear"></div>
		<div class="info">
			<div class="inner">
				<div class="innerContent">
				<p><?php echo $showIntro=substr($alltextreview['Review']['description'],0,150); ?>...</p>
				
				<span class="reviewDate"><a href="<?php e($html->url('/reviews/textreview/'.$alltextreview['Review']['id'].'')); ?>" class="home_read"><div class="read_more left">Read More</div></a> &nbsp; |  Posted on <?php echo date("d M, Y ", strtotime($alltextreview['Review']['created'])); ?> by <?php echo ucwords($alltextreview['User']['firstname']); ?></span>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
		<div class="clear"></div>
	</div>
	    <?php if(($li=="1" && $start=="3") or ($i==2) or ($i==$e)){ echo "</li>"; $li="0"; $fli="1";} 
									  $i++; } ?>
	
	</ul>
		 </div>
		<div class="clear"></div>
	<?php }  } else {?>
	<div class="sliderContent">
	<div class="allreviewContainer">
<div class="innerContent">	<strong>No Text Reviews Found</strong></div></div></div>
	<?php } ?>	
		</div>
	<div class="clear"></div>

<div class="bottom">
		<span class="left"><?php echo $html->image('blue-border-box-bottom-left.gif',array('alt'=>''));?></span>
		<span class="right"><?php echo $html->image('blue-border-box-bottom-right.gif',array('alt'=>''));?></span>
		<div class="clear"></div>
	</div>
</div>
</div>
