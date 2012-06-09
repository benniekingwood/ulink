<style>.video_sub {padding:0px !important; background:none !important;}</style>
<?php echo ( $this->Html->script(array('jquery.form.js')) ); //includes .JS files ?>

<script>
    jQuery.validator.addMethod("checkcaptchaNew", function(value, element) {
        return checkcaptchaNew();
    });
    jQuery.validator.addMethod("ratingNew", function(value, element) {
        return ratingNew();
    });
    jQuery.validator.addMethod("settitlecookieNew", function(value, element) {
        return settitlecookieNew();
    });
        
    jQuery.validator.addMethod("setDescriptioncookieNew", function(value, element) {
        return setDescriptioncookieNew();
    });
        
    jQuery.validator.addMethod("checkDescriptionnew", function(value, element) {
        return checkDescriptionnew();
    });
        
        
    function checkDescriptionnew()
    {
			
        //var description1=$("#textarea1").val(); 
			
        var description1 = tinyMCE.get('textarea1').getContent();
			
        if(description1=="")
        {
            return false;
				
        }
        else
        {
				
            $('#ReviewDescription').val(description1);
            return true;
				
        }
		
			
			
    }
        
        
    function settitlecookieNew()
    {
        var title = $("#ReviewTitle");
        document.cookie = 'reviewTitle'+"="+title.val()+"; path=/";
        document.cookie = 'reviewUser'+"="+'<?php echo $loggedInName; ?>'+"; path=/";
        return true;
			
    }
		
    function ratingNew()
    {
        var ratingnew = $("#ReviewRating").val();
			
			
        if(ratingnew=="")
        {
            return false;
        }
        return true;
			
    }
		
		
    function setDescriptioncookieNew()
    {
			
        var description1 = tinyMCE.get('textarea1').getContent();
        document.cookie = 'reviewDescription'+"="+description1+"; path=/";			
        return true;
			
    }

    function checkcaptchaNew()
    {
        var autoval = $("#autoval").val();
        var enterval = $("#enterval").val();
        if(autoval!=enterval)
        {
            return false
        }
        return true;
    }

    $(document).ready(function(){
	
        $("#VideoReviewWritereviewForm").validatecho({
            errorPlacement: function(error, element) {
                element.after(error);
               
            },
            invalidHandler: function () {
                if ($(this).prev().hasClass('error')) $(this).prev().removecho();
            },
            rules: {
                'data[Review][title]':	{required:true,
                    settitlecookieNew:true
                },
                'data[Review][description]':	
                    {
                    checkDescriptionnew:true,
                    minlength:10,
                    setDescriptioncookieNew:true
                },
					
                'data[Review][ratingInfonew]':{
                    ratingNew:true
                },
                'data[Review][enterval]': 
                    {
                    required:true,
                    checkcaptchaNew:true
                }		
            },
            messages: {
					
                'data[Review][title]':{ 
                    required: "Please enter title"
														
                },
                'data[Review][description]':	
                    { 
                    checkDescriptionnew: "Please enter description",
                    minlength:"Must be atlest 10 characters long"
                },
												
                'data[Review][ratingInfonew]':	
                    { 
                    ratingNew: "Please enter rating"
															
                },
                'data[Review][enterval]':  
                    {
                    required:"Please enter code",
                    checkcaptchaNew:"Please enter correct code"
                }										
            }	
        });

    });
  
    function check(){
	  
        alert('hellllo');
    }

</script>

<script type="text/javascript" language="javascript">
    function setDisplayRatingLevelVideo(level) {
			
			
        for(j = 1; j <= 5; j++) {
            var starImg1 = "img_rateMiniStarOff.gif";
            if( j <= level ) {
				
                starImg1 = "img_rateMiniStarOn.gif";
            }
            var imgName1 = 'starkk'+j;
            document.images[imgName1].src=hostname+"/app/webroot/img/"+starImg1;
        }
    }
    function resetRatingLevelVideo() {
				
        var reviewRating	= $("#ReviewRating").val();
        setDisplayRatingLevel(reviewRating);
		
    }
		
    function setRatingLevelVideo(level) {
		  
        document.cookie = 'reviewRating'+"="+level+"; path=/";
        $("#ReviewRating").val(level);
		  
    }
		
	

</script>
<?php echo $this->Html->script(array('image_validation.js')); ?>
<div class="profile_image">

    <?php if ($Shoolreview[0]['School']['image_url'] != '' && file_exists(WWW_ROOT . '/img/files/schools/' . $Shoolreview[0]['School']['image_url'])) {
        ?>
        <div class="userProfileimage" id="checkImage"><?php echo $this->Html->image(('files/schools/' . $Shoolreview[0]['School']['image_url'] . '', array('alt' => '', 'height' => '100', 'width' => '100')); ?><br/>

        <?php } else { ?>
            <div class="userProfileimage">
                <img alt="" border="0" src="<?php echo($this->Html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/users/noImage.jpg&w=225&h=225" /></div>
        <?php } ?>



    </div>
    <div id="video_review_upload">
        <!--profile container starts-->


        <div class="profilecontainer">

            <div class="profileheading">

                <div id="ajax_msg_image_response"></div>
                <div class="headingTitle">Video review</div>
                <div class="registerRequried"><span>&nbsp;</span>&nbsp;</div>
            </div>
            <div class="profile_form_fields">
                <div class="clear"></div>
                <div class="videocontent">

                    <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
                    <label>School Name:</label> <?php echo $Shoolreview[0]['School']['name']; ?>

                    <?php echo $this->Form->create((null, array('id' => 'VideoReviewWritereviewForm', 'action' => 'uploadreview_step/' . $Shoolreview[0]['School']['id'], 'name' => 'ReviewWritereviewForm')); ?>
                    <div class="clear"></div>
                    <div class="videocontent"><label>Rate School</label>

                        <?php for ($j = 1; $j < 6; $j++) { ?>	

                            <?php echo $this->Html->image(('img_rateMiniStarOff.gif', array('onclick' => 'setRatingLevelVideo(' . $j . ')', 'onMouseOut' => 'resetRatingLevelVideo()', 'onmouseover' => 'setDisplayRatingLevelVideo(' . $j . ')', 'name' => 'starkk' . $j . '')); ?>

                        <?php } ?>


                        <?php $kk = 1; ?>
                        <?php if ($reviews[0]['Review']['rating'] != 0) { ?>
                            <?php echo($this->Form->input('Review.rating', array('type' => 'hidden', 'value' => $reviews[0]['Review']['rating']))); ?>
                        <?php } else { ?>
                            <?php //echo "shakasasti"; ?>
                            <?php echo($this->Form->input('Review.rating', array('type' => 'hidden'))); ?>
                        <?php } ?> 

                        <?php echo $this->Form->input('Review.ratingInfonew', array('type' => 'hidden', 'label' => false, 'div' => false, 'hiddenField' => false)) ?>
                    </div>
                    <?php echo $this->Form->input('Review.title', array('onkeyup' => 'setTitleCookiecho(this.value)', 'value' => $reviews[0]['Review']['title'], 'label' => 'Title')); ?>
                    <?php //echo $this->Form->input('Review.description',array('onkeyup'=>'setDescriptionCookiecho(this.value)','value'=>$reviews[0]['Review']['description'],'label'=>'Comment','type'=>'textarea'));?>			      

                    <?php if (!empty($reviews[0]['Review']['description'])) { ?>
                        <?php echo $this->Form->input('Review.descriptionnew', array('id' => 'textarea1', 'label' => 'Description', 'type' => 'textarea', 'value' => $reviews[0]['Review']['description'], 'class' => 'mceAdvanced')); ?>

                    <?php } else { ?>
                        <?php echo $this->Form->input('Review.descriptionnew', array('id' => 'textarea1', 'label' => 'Description', 'type' => 'textarea', 'value' => '', 'class' => 'mceAdvanced')); ?>
                    <?php } ?>
                    <?php // echo $this->Form->input('Review.description',array('id'=>'textarea2','label'=>'Description*','type'=>'textarea','value'=>$reviews[0]['Review']['description'],'class'=>'mceAdvanced'));?>
                    <?php echo $this->Form->input('Review.description', array('type' => 'hidden')); ?>


                    <?php echo $this->Form->input('Review.enterval', array('id' => 'enterval', 'value' => '', 'label' => 'Enter the code below')); ?>		

                    <?php echo($this->Form->input('Review.autoval', array('id' => 'autoval', 'value' => $RandCaptcha, 'class' => 'captchaImagevideo', 'disabled' => 'disabled', 'label' => '&nbsp;'))) ?>



                    <div class="profile_buttons">
                        <?php echo $this->Form->submit('next_b.gif', array('id' => 'reviewFormSubmit', 'value' => 'Submit', 'class' => 'video_sub', 'style' => 'padding:0px!important;')); ?>

                        <a href="<?php echo($this->Html->url('/reviews/allvideoreview/' . $MyShoolID)); ?>">
                            <?php echo $this->Html->image(('buttonCancel.gif', array('alt' => 'cancel')); ?>
                        </a>

                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="profilebottom"><div><span></span></div></div>
            <div class="clear"></div>
        </div>
        <!--profile container ENDS-->
    </div>

    <script type="text/javascript">
        setDisplayRatingLevelVideo('<?php echo $reviews[0]['Review']['rating'] ?>');
    </script>
    <script type="text/javascript">
        document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name'] ?>'+"; path=/";
        document.cookie = 'reviewRating'+"="+'<?php echo $reviews[0]['Review']['rating'] ?>'+"; path=/";
        document.cookie = 'reviewTitle'+"="+'<?php echo $reviews[0]['Review']['title'] ?>'+"; path=/";
        document.cookie = 'reviewUser'+"="+'<?php echo $loggedInName ?>'+"; path=/";
        document.cookie = 'reviewDescription'+"="+'<?php echo $reviews[0]['Review']['description'] ?>'+"; path=/";	
    </script>
