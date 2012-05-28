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
		
    function setDescriptionCookiecho(description){
        document.cookie = 'reviewDescription'+"="+description+"; path=/";
    }
    function setTitleCookiecho(title){
        document.cookie = 'reviewTitle'+"="+title+"; path=/";
    }

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
            if(validateVideo()){
		   
                deleteCookiecho('reviewTitle');
                deleteCookiecho('reviewRating');
                deleteCookiecho('reviewUser');
                deleteCookiecho('reviewDescription');
                document.cookie = 'reviewSchoolName'+"="+'<?php echo $Shoolreview[0]['School']['name']; ?>'+"; path=/";
			
                function deleteCookiecho(name) {
			
                    var expdate = new Datecho();
                    expires=expdate.setTimecho(expdate.getTimecho() - 1);
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
	
	
	
        function validateTitlecho(){
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
	
        function validateMessagecho(){
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
                    <div class="userProfileimage" style="margin-right: 25px;"><?php echo $this->Html->image(('files/schools/' . $Shoolreview[0]['School']['image_url'], array('alt' => '', 'title' => '', 'height' => '100', 'width' => '100')); ?></div>
                    <div class="registerContainter">
                        <div class="registerContent" style="padding-left: 15px">

                            <b>Please address the following topics in your review to better serve viewers.</b><br />
                            What made you choose your school?<br />
                            How would you summarize your overall experience at the school?<br />
                            Any advice you would like to give to potential incoming freshman or transfer students.<br /><br />
                            <label>School name:</label><strong><?php echo $Shoolreview[0]['School']['name']; ?></strong><br />

                            <form action="<?php echo $ActionToupload; ?>" method="post" enctype="multipart/form-data" name="ReviewWritereviewForm" >

                                <input type="hidden" id="h1" name="hiddenvideo" value="0" />  


                                <?php echo($form->text('Review.school_id', array('type' => 'hidden', 'value' => '' . $Shoolreview[0]['School']['id'] . ''))); ?>
                                <?php echo($form->text('Review.user_id', array('type' => 'hidden', 'value' => $loggedInId))); ?>
                                <?php echo($form->text('Review.type', array('type' => 'hidden', 'value' => 'video'))); ?> 
                                <?php
                                if (isset($reviews[0]['Review']['id'])) {
                                    echo($form->text('Review.id', array('type' => 'hidden', 'value' => $reviews[0]['Review']['id'])));
                                    echo($form->text('Review.link', array('type' => 'hidden', 'value' => $reviews[0]['Review']['link'])));
                                }
                                ?> 
                                <input name="token" type="hidden" value="<?php echo $Token; ?>" />
                                <label>Your video: </label>
                                <input name="file" id="ReviewVideo" type="file" onchange="check_filecho();"/> 
                                <input type="hidden" name="id" value="<?php echo $this->params['pass'][0]; ?>">
                                <span id="videoInfo"></span>

                                <div id="searchResult_file"></div>

                                <div style="width: 300px;">
                                    <br /><br /><br />
                                    <?php echo $form->submit('buttonSubmit.gif', array('id' => 'reviewFormSubmit', 'value' => 'Submit', 'alt' => 'submit', 'style' => 'padding:0px!important;')); ?>
                                    <a href="<?php echo($this->Html->url('/reviews/allvideoreview/' . $MyShoolID)); ?>">
                                        <?php echo $this->Html->image(('buttonCancel.gif', array('alt' => 'cancel')); ?>
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div><div class="clear"></div></div><div class="clear"></div></div><div class="clear"></div></div>
        <div class="clear"></div></div>
    <div class="clear"></div>
</div> 
<script type="text/javascript">
    setDisplayRatingLevel('<?php echo $reviews[0]['Review']['rating'] ?>');
</script>