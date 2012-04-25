<script type="text/javascript">
	$(document).ready(function(){
		$("#slider").easySlider({
			controlsBefore:	'<div id="autoControlsButtons">',
			controlsAfter:	'</div>',
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
<script type="text/javascript">
deleteCookie('reviewTitle');
deleteCookie('reviewRating');
deleteCookie('reviewUser');
deleteCookie('reviewDescription');

function deleteCookie(name) {

var expdate = new Date();
expires=expdate.setTime(expdate.getTime() - 1);
document.cookie = name += "=; expires=" +expires+"; path=/";
}
</script>
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
	
	<div class="textReviewdetails left"><strong>Address:</strong><?php echo $SchoolImage[0]['School']['address'] ?></div>
	<div class="textReviewdetails left"><strong>Rating:</strong>
        <?php 
if($SchoolImage[0]['School']['rating'] == 0){
						     echo "No rating yet";
					       	} else {
echo $html->image('star-'.$SchoolImage[0]['School']['rating'].'.gif',array('alt'=>''));}?></div>
	<div class="textReviewdetails left"><strong>Total Review:</strong><?php echo $Firstreview ?></div>
	
	<?php /*?><?php if(isset($loggedInId)) {?>
	
	<div class="textReviewdetails left"><a href="<?php e($html->url('/reviews/uploadvideoreview'));?>/<?php echo $SchoolImage[0]['School']['id']; ?>"><?php echo $html->image('button.gif',array('alt'=>'')); ?></a></div>
	
	<?php } else { ?>
	
	<div class="textReviewdetails left"><a href="javascript:void(0);" class="loginBoxPopup"><?php echo $html->image('button.gif',array('alt'=>'')); ?></a></div>
		
	<?php } ?><?php */?>
	
	<?php if(isset($loggedInId)) {?>
	    <?php if(!isset($MyReview)){ ?>
			<?php if(isset($MySchool)){ ?>	
			<div class="textReviewdetails noBorder"><a href="<?php e($html->url('/reviews/uploadreview_step'));?>/<?php echo $SchoolImage[0]['School']['id']; ?>"><?php echo $html->image('write-a-review.gif',array('alt'=>'')); ?></a></div>
			<?php } ?>
	<?php } else { ?>
		<?php if (isset($ApprovalPending)) {?> 
			<div class="textReviewdetails noBorder">Your review is being reviewed by a moderator</div>
		<?php } else { ?>
		<div class="textReviewdetails left"><a href="<?php e($html->url('/reviews/uploadreview_step'));?>/<?php echo $SchoolImage[0]['School']['id']; ?>"><?php echo $html->image('modify.gif',array('alt'=>'')); ?></a></div>
			<?php } ?>
	<?php }  ?>
	<?php } else { ?>
			<div class="textReviewdetails noBorder"><a href="javascript:void(0)" class="loginBoxPopup"><?php  echo $html->image('write-a-review.gif',array('alt'=>''));?></a></div>	
	<?php } ?>
	
	<div class="clear"></div>
	
		<?php
		
			if(!empty($Allvideoreview))
			{
		 if($img_count=count($Allvideoreview)) { ?>		
					<div class="reviewSlider"><span class="showing">Showing total <?php echo $Firstreview; ?></span><span id="prevBtn"><a href="javascript:void(0);"></a></span><span id="nextBtn"><a href="javascript:void(0);"></a></span></div>
					<div class="clear"></div>
					<div id="slider">
						<ul>
							<?php 	$i=0;
									$e=count($Allvideoreview)-1;
									foreach($Allvideoreview as $allvideoreview){  ?>
		
									<?php if($i==0){echo "<li>"; $fli="0";} 
												if(($i%3==0 && $i!=1 && $fli=="1") || ($li=="0")){ echo "<li>"; $li="1"; $start=0; } $start++; ?>    
									  
							<div class="sliderContent">
		<div class="allreviewContainer">
		<div class="reviewHeading"><?php echo $allvideoreview['Review']['title']; ?></div>
		<div class="clear"></div>
		<div class="info">
			<div class="inner">
				<div class="innerContent">
				 <span class="videoThumb"><a href="<?php e($html->url('/reviews/videoreview/'.$allvideoreview['Review']['id'].'')); ?>"><?php echo $VideoReviewCaps[$i]['image_thumb'][0]; ?></a></span>
				<p><?php echo $showIntro=substr($allvideoreview['Review']['description'],0,150); ?>...</p>
				<div class="clear"></div>
				<span class="reviewDate"><a href="<?php e($html->url('/reviews/videoreview/'.$allvideoreview['Review']['id'].'')); ?>" class="home_read"><div class="read_more left">Read more</div></a> &nbsp;|  Posted on <?php echo date("d M, Y ", strtotime($allvideoreview['Review']['created'])); ?> by <?php echo ucwords($allvideoreview['User']['firstname']); ?></span>
				</div>                                                                                                                
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	    <?php if(($li=="1" && $start=="3") or ($i==2) or ($i==$e)){ echo "</li>"; $li="0"; $fli="1";} 
									  $i++; } ?>
	
	</ul>
	</div>
  <div class="clear"></div>
  <?php } }else { ?>
  <div class="sliderContent">
	<div class="allreviewContainer">
<div class="innerContent">	<strong>No Video Reviews Found</strong></div></div></div>
  <?php  } ?>	
 
  </div>
  <div class="clear"></div>

<div class="bottom">
		<!--<span class="left"><?php //echo $html->image('blue-border-box-bottom-left.gif',array('alt'=>''));?></span>
		<span class="right"><?php //echo $html->image('blue-border-box-bottom-right.gif',array('alt'=>''));?></span>-->
		<div class="clear"></div>
	</div>
</div>
</div>
