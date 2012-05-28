<script type="text/javascript">

	

		jQuery.validator.addMethod("checkcaptcha", function(value, element) {
            return checkcaptcha();
        });
         jQuery.validator.addMethod("rating", function(value, element) {
            return rating();
        });
        jQuery.validator.addMethod("settitlecookie", function(value, element) {
            return settitlecookiecho();
        });
        
        jQuery.validator.addMethod("setDescriptioncookie", function(value, element) {
            return setDescriptioncookiecho();
        });
        
        jQuery.validator.addMethod("checkDescription", function(value, element) {
            return checkDescription();
        });
        
        
        
        function checkDescription()
        {
			var description = tinyMCE.get('textarea2').getContent();

		
			
		//	alert(description);
			
			//alert(description);			
			
			if( description == "" )
			{
				return false;
			}
			else
			{		
				//alert(description);		
				$('#ReviewDescriptionpopUp').val(description);
				return true;
				
			}
		
			
			
		}
        
   
		   function setDescriptioncookiecho()
        {
			
			var description=$("#textarea2").val(); 
			document.cookie = 'reviewDescription'+"="+description+"; path=/";			
			return true;
			
		}

        
        function settitlecookiecho()
        {
			
			var title = $("#ReviewTitle");
			document.cookie = 'reviewTitle'+"="+title.val()+"; path=/";
			document.cookie = 'reviewUser'+"="+'<?php echo $loggedInName;?>'+"; path=/";
			return true;
			
		}
		
		function rating()
		{
			
			var rating = $("#ReviewRatingnew").val();
			
			
			if(rating=="")
			{
				return false;
			}
			return true;
			
		}
		
		
		
	function checkcaptcha()
	{
		var autovalnew = $("#autovalnew").val();
		var entervalnew = $("#entervalnew").val();
		
		
			if(autovalnew!=entervalnew)
			{
				return false
			}
                return true;
	}



$(document).ready(function(){
	

	document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name']?>'+"; path=/";
	$("#ReviewWritereviewForm").validatecho({
	
	rules: {
					'data[Review][title]'			:		{	required:true,
																settitlecookie:true
															},
					'data[Review][description]'		:	
															{
																checkDescription:true,
																minlength:10,
																setDescriptioncookie:true
															},
					
					'data[Review][ratingInfo]'			:	{
																rating:true
																
															},
					'data[Review][entervalnew]'			: 
															{
																required:true,
																checkcaptcha:true
															},
					
			   },
			   messages: {
					
					'data[Review][title]'			:		{ 
																required: "Please enter title"	,
														
															},
					'data[Review][description]'			:	
															{ 
																checkDescription: "Please enter description",
																minlength:"Must be atlest 10 characters long"
															},
												
					'data[Review][ratingInfo]'			:	
															{ 
																rating: "Please enter rating"
															
															},
					'data[Review][entervalnew]'			:  
															{
																required:"Please enter code",
																checkcaptcha:"Please enter correct code"
															},
				
					
					
												
				}	
	});

$('#ReviewWritereviewForm').ajaxForm({	beforeSubmit	:	function(){ 
	
													$('.add-textreview-response').html('<img src="'+hostname+'app/webroot/img/load_blu.gif" />')
														deleteCookiecho('reviewTitle');
														deleteCookiecho('reviewRating');
														deleteCookiecho('reviewUser');
														deleteCookiecho('reviewDescription');
														document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name'];?>'+"; path=/";
			
												function deleteCookiecho(name) {
			
																var expdate = new Datecho();
																expires=expdate.setTimecho(expdate.getTimecho() - 1);
																document.cookie = name += "=; expires=" +expires+"; path=/";
														}
													},
							success			:	function(response) {
								
														if(response == '1'){
															$('.add-textreview-response').html("<span class='success'>Thanks Your Review has been updated and sent for approval again</span>");
															
															setTimeout(function(){ parent.tb_removecho() }, 5000);

															
														}
														else if(response=="2")
														{
																$('.add-textreview-response').html("<span class='success'>Thanks Your Review has been submitted and sent for approval</span>");
															setTimeout(function(){ parent.tb_removecho() }, 5000);
															
														}
													}
 });
});



</script>
<script>
function preview(url_add){
	
			var description = tinyMCE.get('textarea2').getContent();
			document.cookie = 'reviewDescription'+"="+description+"; path=/";			
	   window.open(url_add,'preview', 'width=900,height=500,menubar=no,status=yes,left=200,top=300,toolbar=no,scrollbars=yes');
   }
</script>

<script type="text/javascript" language="javascript">
		function setDisplayRatingLevel(level) {
	
			for(i = 1; i <= 5; i++) {
			   var starImg2 = "img_rateMiniStarOff.gif";
				if( i <= level ) {
					
				
					starImg2 = "img_rateMiniStarOn.gif";
				}
				var imgName2 = 'starpp'+i;
				
				
				document.images[imgName2].src=hostname+"/app/webroot/img/"+starImg2;
			}
		}
		function resetRatingLevel() {
			
			//setDisplayRatingLevel(document.ReviewWritereviewForm.ReviewRating.value);
			
			var reviewRating	= $("#ReviewRatingnew").val();
			setDisplayRatingLevel(reviewRating);
		
		}
		
		function setRatingLevel(level) {
		   document.cookie = 'reviewRating'+"="+level+"; path=/";
		  // document.ReviewWritereviewForm.ReviewRating.value = level;
		   $("#ReviewRatingnew").val(level);
		}
</script>
<div id="writeReview" style="display:none;">
<?php if($loggedInId){
	if(!isset($ApprovalPending))
	{
	
	 ?>
 <div id="mainContainer" style="">
<div class='add-textreview-response'></div>
<div class="login">
<?php $sid=$_GET['itemId']; 
//echo $_SERVER['SERVER_NAME'];

?>
	
	<?php echo $form->create(('Review', array('action' => 'writereview','name'=>'ReviewWritereviewForm'));?>
	
	<div id="reviewResponse">	
		
		
		<div class="main-field-contianer">
		<h3 class="rate_it">Rate It</h3>
		<label class="rate_star"><?php for($i=1;$i<6;$i++){ ?>	

	<?php echo $this->Html->image(('img_rateMiniStarOff.gif' ,array('onclick'=>'setRatingLevel('.$i.')','onMouseOut'=>'resetRatingLevel()','onmouseover'=>'setDisplayRatingLevel('.$i.')','name'=>'starpp'.$i.''));?>

	<?php } ?>
	<?php echo $form->input('Review.ratingInfo', array('type'=>'hidden','label'=>false,'div'=>false,'hiddenField'=>false)) ?>
	<span id="ratingInfo"></span></label>	</div>
		
		<?php //echo "<pre>";print_r($usertextreview);exit; ?>
		<?php if($usertextreview[0]['Review']['title'] != ''){?>
		
		<h3>Review Title</h3>
		<div class="main-field-contianer">
		<?php echo $form->input('Review.title',array('value'=>$usertextreview[0]['Review']['title'],'label'=>false,'div'=>false));?><span id="titleInfo"></span>
		 </div>
		 <?php } else {?>
		<h3> Review Title</h3>
		<div class="main-field-contianer">
		<?php echo $form->input('Review.title',array('label'=>false,'div'=>false));?><span id="titleInfo"></span>
		</div>
		  <?php } ?>
		  <?php // echo "hhheleleo".$usertextreview[0]['Review']['description']; ?>
         
		<h3>Description</h3>
		<div class="main-field-contianer">
		<b>Please address the following topics in your review to better serve viewers.</b> <br />
                    What made you choose your school?<br />
                    How would you summarize your overall experience at the school?<br />
                    Any advice you would like to give to potential incoming freshman or transfer students.<br />
			
				<?php $kk=1; ?>
				<?php if($usertextreview[0]['Review']['rating'] != 0){?>
				<?php echo($form->input('Review.ratingnew', array( 'type'=>'hidden','value'=>$usertextreview[0]['Review']['rating']))); ?>
				<?php } else {?>
				<?php //echo "shakasasti"; ?>
				<?php echo($form->input('Review.ratingnew', array( 'type'=>'hidden') )); ?>
				<?php } ?> 
				<?php echo($form->input('Review.school_id', array( 'type'=>'hidden','value'=>''.$Shoolreview[0]['School']['id'].'') )); ?>
			
			<?php echo $form->input('Review.descriptionarea',array('id'=>'textarea2','label'=>false, 'width' => '200','height'=>'100', 'type'=>'textarea','value'=>$usertextreview[0]['Review']['description'],'class'=>'mceAdvanced'));?>
				<?php echo($form->input('Review.description', array( 'type'=>'hidden','id'=>'ReviewDescriptionpopUp') )); ?>
				  <?php //echo $form->input('Review.description2',array('id' => 'textarea2','label'=>false,'value'=>$usertextreview[0]['Review']['description']));?>
				<?php //echo($form->input('Review.description', array( 'type'=>'hidden','value'=>''.$usertextreview[0]['Review']['description'].'') )); ?>
				<?php echo($form->input('Review.user_id', array( 'type'=>'hidden','value'=>$loggedInId))); ?>
			</div>
	<h3>Enter the code below ho</h3>
	<div class="main-field-contianer">
	<?php  echo($form->input('Review.entervalnew',array('div'=>false,'id'=>'entervalnew','label'=>false))); ?>
	</div>
	<div class="clear"></div>
	<?php   echo($form->input('Review.autovalnew',array('id'=>'autovalnew','value'=>$RandCaptcha,'class'=>'captchaImage','disabled'=>'disabled','label'=>false)))?>	
	<?php echo($form->input('Review.type', array( 'type'=>'hidden','value'=>'text') )); ?> 
	<div class="clear"></div>
	<div class="pop_sub">
		<?php echo $form->submit('buttonSubmit.gif');?> 
		 <a class="preview_link" href="javascript:void(0)"  onclick="preview('<?php echo($this->Html->url('/text_preview.php')); ?>')"><?php echo $this->Html->image(('preview.gif',array('alt'=>''));?></a>
	</div>
	<?php echo $form->end(); ?>
	
	
	 <div class="clear"></div>
</div>
</div>
<?php } else {  ?>    

<div class="login">Your review is being reviewed by moderator</div>


<?php   }  } else { ?><div class="login">Please <a href="<?php echo $this->Html->url('/users/login'); ?>" class="login">Log In</a> to submit a review
                 or <a href="<?php echo($this->Html->url('/users/register')); ?>">Join uLInk</a> if not register yet
 </div><?php  } ?></div>

<script type="text/javascript">
setDisplayRatingLevel('<?php echo $usertextreview[0]['Review']['rating'];?>');
</script>

<?php if(!empty($usertextreview)){ ?>
<script type="text/javascript">
	document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name']?>'+"; path=/";
	document.cookie = 'reviewRating'+"="+'<?php echo $usertextreview[0]['Review']['rating']?>'+"; path=/";
	document.cookie = 'reviewTitle'+"="+'<?php echo $usertextreview[0]['Review']['title']?>'+"; path=/";
	document.cookie = 'reviewUser'+"="+'<?php echo $loggedInName?>'+"; path=/";
	document.cookie = 'reviewDescription'+"="+'<?php echo $usertextreview[0]['Review']['description']?>'+"; path=/";	
</script>
<?php } ?>

</div>
