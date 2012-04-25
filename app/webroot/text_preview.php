<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>uLink | Your college everything</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/sliding/jquery-1.js"></script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function() {
		$(".topMenuAction").click( function() {
			if ($("#openCloseIdentifier").is(":hidden")) {
				$("#sliderLeft").animate({ 
					marginLeft: "-76px"
					}, 500 );
				$("#topMenuImage").html('<img src="img/openLeftPanel.png" class="start" />');
				$("#openCloseIdentifier").show();
			} else {
				$("#sliderLeft").animate({ 
					marginLeft: "0px"
					}, 500 );
				$("#topMenuImage").html('<img src="img/closeLeftPanel.png" />');
				$("#openCloseIdentifier").hide();
			}
		});  
	});
	</script>
	<?php  ?>
	<div id="leftSliderWrap">
		<div style="display: block;" id="openCloseIdentifier"></div>
		<div style="margin-left:-76px;" id="sliderLeft">
			<div id="sliderContent">
				<a href="javascript:void(0);"><img src="img/reviews-icon.gif" alt="" /></a>
				<a href="javascript:void(0);"><img src="img/added-icon.gif" alt="" /></a>
				<a href="javascript:void(0);"><img src="img/rated-icon.gif" alt="" /></a>
				<a href="javascript:void(0);"><img src="img/suggest-icon.gif" alt="" class="last" /></a>
				<a href="javascript:void(0);"><img src="img/left-panel-bottom.png" alt="" class="last" /></a>
			</div>
			<div id="openCloseWrap"><a href="javascript:void(0);" class="topMenuAction" id="topMenuImage"><img src="img/openLeftPanel.png" class="start" /></a></div>
		</div>
	</div>
 	<div id="mainContainer">
	
		<div id="header">
			<div class="left"><img src="img/logouLinkv2.png" alt="" /></div>
			<div class="topLinks">
				<a href="javascript:void(0);">Join uLInk</a>
				<a href="javascript:void(0);" class="login">Log In</a>
			</div>
			<div class="clear"></div>
			<div class="searchPanel">
				<div class="left">
					<a href="javascript:void(0);"><img src="img/home-icon.gif" alt="" /></a>
					<a href="javascript:void(0);"><img src="img/map-icon.gif" alt="" /></a>
				</div>
				<div class="right"><img src="img/search-bar-right.gif" alt="" /></div>
				<div class="search">
					<input type="text" /><input type="button" class="btn" value="Search" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="pageHeading">
		
		<?php  
		

		 if(isset($_COOKIE['reviewSchoolName']))
		{
		
		echo $_COOKIE['reviewSchoolName'];
		
	}
		?>
		

	
		</div>
		<div id="whiteContentBox" class="clear">
		
			<div class="top">
			
				<span class="left"><img src="img/white-box-top-left-inner.gif" alt="" /></span>
				<span class="right"><img src="img/white-box-top-right-inner.gif" alt="" /></span>
				<div class="clear"></div>
			</div>
			<div class="contentInner">
			
				<div id="leftContent">
					<div class="user-rating">
						<div class="userName"><?php 
						
						if(isset($_COOKIE['reviewUser']))
						{
						echo $_COOKIE['reviewUser']; 
						
						
						}?></div>
						<div class="rating">
							<span class="right">
                                                            <?php if($_COOKIE['reviewRating'] != '') { ?>
                                                            <img src="img/star-<?php echo $_COOKIE['reviewRating']; ?>.gif" alt="No star" />
                                                            <?php } else { 
                                                                echo 'None';
                                                                } 
                                                            ?>
                                                        </span>
							<span class="right">Rating</span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="grayBox">
						<div class="top">
							<span class="left"><img src="img/gray-box-top-left.gif" alt="" /></span>
							<span class="right"><img src="img/gray-box-top-right.gif" alt="" /></span>
							<div class="clear"></div>
						</div>
						<div class="content">
							<?php 
							if(isset($_COOKIE['reviewDescription']))
							{
							
							echo html_entity_decode(stripcslashes($_COOKIE['reviewDescription']), ENT_NOQUOTES); 
							
							}
							?>
						</div>
						<div class="bottom">
							<span class="left"><img src="img/gray-box-bottom-left.gif" alt="" /></span>
							<span class="right"><img src="img/gray-box-bottom-right.gif" alt="" /></span>
							<div class="clear"></div>
						</div>
					</div>
					<div class="boxBottom">
						<div class="date"><?php echo date("d M, Y",time());
												?></div>
						<div class="links">
							<a href="#">Video Reviews</a>  |  <a href="#">School Information</a>  |  <a href="#">View Map</a>
						</div>
						<div class="clear"></div>
					</div>
					<br />
					
				</div>
				<div id="rightContent">
					<div class="recent">
						<div class="heading">
							<span class="left"><img src="img/recent-heading-left.gif" alt="" /></span>
							<h1>Other Written Reviews</h1>
							<span class="right"><img src="img/recent-heading-right.gif" alt="" /></span>
							<div class="clear"></div>
						</div>
						<div class="content">
							<ul class="writtenReviews">
								<li>
									<span class="left"><a href="#">Fusce rhoncus viverra</a></span>
									<span class="right"><img src="img/rating-star.gif" alt="" /></span>
									<span class="content">
										Cras massa neque, tristique in ullamcorper sit amet, pellentesque sit amet enim...
									</span>
									<span class="right"><a href="#">Read more...</a></span>
								</li>
								<li class="last">
									<span class="left"><a href="#">Fusce rhoncus viverra</a></span>
									<span class="right"><img src="img/rating-star.gif" alt="" /></span>
									<span class="content">
										Cras massa neque, tristique in ullamcorper sit amet, pellentesque sit amet enim...
									</span>
									<span class="right"><a href="#">Read more...</a></span>
								</li>
								<li class="clear"></li>
							</ul>
							<div class="clear"></div>
						</div>
						<div class="bottom">
							<span class="left"><img src="img/recent-bottom-left.gif" alt="" /></span>
							<span class="right"><img src="img/recent-bottom-right.gif" /></span>
							<div class="clear"></div>
						</div>
						<a href="javascript:void(0);" class="viewAll">View All Reviews </a>
						<div class="clear"></div>
					</div>
					<br />
					<div class="recent">
						<div class="heading">
							<span class="left"><img src="img/recent-heading-left.gif" alt="" /></span>
							<h1>Other Video Reviews</h1>
							<span class="right"><img src="img/recent-heading-right.gif" alt="" /></span>
							<div class="clear"></div>
						</div>
						<div class="content">
							<div class="videoListing">
								<img src="img/small-pic.jpg" />
								<span>
									<a href="javascript:void(0);">Fusce rhoncus viverra...</a><br />
									98,220 views<br />
									<img src="img/rating-star.gif" alt="" />
								</span>
								<div class="clear"></div>
							</div>
							<div class="videoListing">
								<img src="img/small-pic.jpg" />
								<span>
									<a href="javascript:void(0);">Fusce rhoncus viverra...</a><br />
									98,220 views<br />
									<img src="img/rating-star.gif" alt="" />
								</span>
								<div class="clear"></div>
							</div>
						</div>
						<div class="bottom">
							<span class="left"><img src="img/recent-bottom-left.gif" alt="" /></span>
							<span class="right"><img src="img/recent-bottom-right.gif" /></span>
							<div class="clear"></div>
						</div>
						<a href="javascript:void(0);" class="viewAll">View All Reviews </a>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="bottom">
				<span class="left"><img src="img/white-box-bottom-left-inner.gif" alt="" /></span>
				<span class="right"><img src="img/white-box-bottom-right-inner.gif" alt="" /></span>
				<div class="clear"></div>
			</div>
		</div>
		<div class="share">
			<div class="left"><img src="img/find-us.gif" alt="Find us on" /></div>
			<a href="javascript:void(0)" class="facebook"></a>
			<a href="javascript:void(0)" class="twitter"></a>
			<a href="javascript:void(0)" class="stumble"></a>
			<a href="javascript:void(0)" class="delicious"></a>
			<a href="javascript:void(0)" class="yahoo"></a>
			<div class="clear"></div>
		</div>
		<div id="footer">
			<div class="left"><a href="javascript:void(0);">Home</a> | <a href="javascript:void(0);">Join uLink</a> | <a href="javascript:void(0);">FAQs</a> | <a href="javascript:void(0);">Legal</a> | <a href="javascript:void(0);">Advertise</a></div>
			<div class="right"> &copy; 2011 uLink, Inc. All rights reserved.</div>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>
