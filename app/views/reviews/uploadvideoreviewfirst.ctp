<?php echo $javascript->link(array('image_validation.js')); ?>
<script type="text/javascript" language="javascript">
    function setDisplayRatingLevel(level) {
        for(i = 1; i <= 5; i++) {
            var starImg = "img_rateMiniStarOff.gif";
            if( i <= level ) {
                starImg = "img_rateMiniStarOn.gif";
            }
            var imgName = 'star'+i;
            document.images[imgName].src=hostname+"/app/webroot/img/"+starImg;
        }
    }
    function resetRatingLevel() {
			
        setDisplayRatingLevel(document.ReviewWritereviewForm.ReviewRating.value);
		
    }
		
    function setRatingLevel(level) {
        document.cookie = 'reviewRating'+"="+level+"; path=/";
        document.ReviewWritereviewForm.ReviewRating.value = level;
    }
		
    function setDescriptionCookie(description){
        document.cookie = 'reviewDescription'+"="+description+"; path=/";
    }
    function setTitleCookie(title){
        document.cookie = 'reviewTitle'+"="+title+"; path=/";
    }

</script>
<script>
    $(document).ready(function(){
        //global vars
        var form = $("#ReviewWritereviewForm");
	
        var video = $("#ReviewVideo");
        var videoInfo = $("#videoInfo");
        var videolink = $("#ReviewLink");
        var reviewid = $("#ReviewId");
        var hiddenFile=$("#h1");
	
        var title = $("#ReviewTitle");
        var titleInfo = $("#titleInfo");
	
        var description=$("#ReviewDescription"); 
        var descriptionInfo=$("#descriptionInfo");	
	
        var rating = $("#ReviewRating");
        var ratingInfo = $("#ratingInfo");
	
        var autoval = $("#autoval");
        var enterval = $("#enterval");
        var entervalInfo = $("#entervalInfo");
	
	
	
        //On blur
        title.blur(validateTitle);
        description.blur(validateMessage);
	
        //On key press
        title.keyup(validateTitle);
        description.keyup(validateMessage);
	
        //On Submitting
        $('#reviewFormSubmit').click(function(){
            if(validateTitle() & validateMessage() & validateRating() & validateCaptcha() ){
		   
                //deleteCookie('reviewTitle');
                //deleteCookie('reviewRating');
                //deleteCookie('reviewUser');
                //deleteCookie('reviewDescription');
                document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name']; ?>'+"; path=/";
			
                function deleteCookie(name) {
			
                    var expdate = new Date();
                    expires=expdate.setTime(expdate.getTime() - 1);
                    document.cookie = name += "=; expires=" +expires+"; path=/";
                }
                formObj.submit();
            }	 
		
            else 
                return false; 
		
        });
	
	
        //validation functions
	
        function validateVideo(){
            //if it's NOT valid
            if((video.val().length < 1  || hiddenFile.val()=="0") && (videolink.val() == '')){
                video.addClass("error");
                videoInfo.text("Please Choose a valid video file to upload");
                videoInfo.addClass("error");
                return false;
            }
            //if it's valid
            else{ 
		
                video.removeClass("error");
                videoInfo.text("");
                videoInfo.removeClass("error");
                return true;
            }
        }
	
	
	
        function validateTitle(){
            //if it's NOT valid
            if(title.val().length < 1 ){
                title.addClass("error");
                titleInfo.text("Can't empty");
                titleInfo.addClass("error");
                return false;
            }
            //if it's valid
            else{ 
		    
                document.cookie = 'reviewTitle'+"="+title.val()+"; path=/";
                document.cookie = 'reviewTitle'+"="+title.val()+"; path=/";
                document.cookie = 'reviewUser'+"="+'<?php echo $loggedInName; ?>'+"; path=/";
                document.cookie = 'reviewid'+"="+reviewid.val()+"; path=/";


                title.removeClass("error");
                titleInfo.text("Done");
                titleInfo.removeClass("error");
                return true;
            }
        }
	
        function validateRating(){
            //if it's NOT valid
            if(rating.val() ==""){
                ratingInfo.text("Please Rate the school");
                ratingInfo.addClass("error");
                return false;
            }
            //if it's valid
            else{
		    
			
                ratingInfo.text("");
                ratingInfo.removeClass("error");
                return true;
            }
        }
	
        function validateMessage(){
            //it's NOT valid
            if(description.val().length < 5){
                description.addClass("error");
                descriptionInfo.text("Can't empty and must be atlest 10 characters long");
                descriptionInfo.addClass("error");
                return false;
            }
            //it's valid
            else{
                document.cookie = 'reviewDescription'+"="+description.val()+"; path=/";			
			
                description.removeClass("error");
                descriptionInfo.text("");
                descriptionInfo.removeClass("error");
                return true;
            }
        }
	
        function validateCaptcha(){
            //it's NOT valid
            if(autoval.val() !=enterval.val()){
                enterval.addClass("error");
                entervalInfo.text("Please verify the code");
                entervalInfo.addClass("error");
                return false;
            }
            //it's valid
            else{			
                enterval.removeClass("error");
                entervalInfo.text("");
                entervalInfo.removeClass("error");
                return true;
            }
        }
	
	
	
    });
</script>	
<div class="content">
    <div class="form">
        <div class="info">
            <div class="inner">
                <div class="innerContent">
                    <div class="userProfileimage"><?php echo $html->image('files/schools/' . $Shoolreview[0]['School']['image_url'], array('alt' => '', 'title' => '', 'height' => '100', 'width' => '100')); ?></div>
                    <div class="registerContainter">
                        <div class="registerContent"><label>School name:</label><strong><?php echo $Shoolreview[0]['School']['name']; ?></strong></div>

                        <form action="<?php echo $html->url('/reviews/uploadvideoreview/' . $this->params['pass'][0]); ?>" method="post" enctype="multipart/form-data" name="ReviewWritereviewForm" >

                            <div class="registerContent"><label>Rate School</label>

                                <?php for ($i = 1; $i < 6; $i++) { ?>	

                                    <?php echo $html->image('img_rateMiniStarOff.gif', array('onclick' => 'setRatingLevel(' . $i . ')', 'onMouseOut' => 'resetRatingLevel()', 'onmouseover' => 'setDisplayRatingLevel(' . $i . ')', 'name' => 'star' . $i . '')); ?>
                                    </a>	
                                <?php } ?><span id="ratingInfo"></span>	
                            </div>

                            <div class="registerContent"><label>Review Title</label><?php echo $form->text('Review.title', array('onkeyup' => 'setTitleCookie(this.value)', 'name' => 'videoTitle', 'value' => $reviews[0]['Review']['title'])); ?><span id="titleInfo"></span></div>

                            <div class="registerContent"><label>Comments</label><?php echo $form->textarea('Review.description', array('onkeyup' => 'setDescriptionCookie(this.value)', 'name' => 'videoDescription', 'value' => $reviews[0]['Review']['description'])); ?><span id="descriptionInfo"></span></div>


                            <div class="registerContent"><label>Enter the code below</label><input type="text" name="enterval" id="enterval" value=""><span id="entervalInfo"></span></div>

                            <div class="registerContent"><label>&nbsp;</label><input type="text" disabled="disabled" class="captchaImage" name="autoval" id="autoval" value="<?php echo $RandCaptcha; ?>"></div>

                            <input type="hidden" id="h1" name="hiddenvideo" value="0" />  

                            <?php e($form->text('Review.rating', array('type' => 'hidden', 'onkeyup' => 'setTitleCookie()'))); ?>
                            <?php e($form->text('Review.school_id', array('type' => 'hidden', 'value' => '' . $Shoolreview[0]['School']['id'] . ''))); ?>
                            <?php e($form->text('Review.user_id', array('type' => 'hidden', 'value' => $loggedInId))); ?>
                            <?php e($form->text('Review.type', array('type' => 'hidden', 'value' => 'video'))); ?> 
                            <?php
                            if (isset($reviews[0]['Review']['id'])) {
                                e($form->text('Review.id', array('type' => 'hidden', 'value' => $reviews[0]['Review']['id'])));
                                e($form->text('Review.link', array('type' => 'hidden', 'value' => $reviews[0]['Review']['link'])));
                            }
                            ?> 

                            <input type="hidden" name="id" value="<?php echo $this->params['pass'][0]; ?>">

                            <div id="searchResult_file"></div>

                            <div style="padding-left:186px;">
<?php echo $form->submit('buttonSubmit.gif', array('id' => 'reviewFormSubmit', 'value' => 'Submit')); ?>
                                <div><a href="<?php e($html->url('/reviews/allvideoreview/' . $MyShoolID)); ?>">Cancel</a></div>

                            </div>
                        </form>
                    </div>
                </div><div class="clear"></div></div><div class="clear"></div></div><div class="clear"></div></div>
    <div class="clear"></div></div>
<div class="clear"></div>

<script type="text/javascript">
    setDisplayRatingLevel('<?php echo $reviews[0]['Review']['rating'] ?>');
</script>