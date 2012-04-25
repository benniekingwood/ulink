<script type="text/javascript">
    function getState(countryId) {
      
       // getCity();
        var strURL=hostname+"/users/state/"+countryId;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {						
                        document.getElementById('statediv').innerHTML=req.responseText;						
                    } else {
                        //alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }				
            }			
            req.open("GET", strURL, true);
            req.send(null);
        }		
    }
    function getCity(stateId) {		
        var strURL=hostname+"/users/city/"+stateId;
        var req = getXMLHTTP();
        if (req) {
			
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {						
                        document.getElementById('citydiv').innerHTML=req.responseText;						
                    } else {
                        //alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }				
            }			
            req.open("GET", strURL, true);
            req.send(null);
        }
				
    }
</script>
<script type="text/javascript">
    jQuery.validator.addMethod("noSpecialChars", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_\s]+$/i.test(value);
    });

    $(document).ready(function(){
        $("#UserIndexForm").validate({
            invalidHandler: function () {
                $('.error').each(function(a,b){
                    $(this).remove();
                });
            },
            rules: {
                'data[User][firstname]'	: {
                    required: true,
                    noSpecialChars:true
                },
                'data[User][lastname]'			:{
                    required: true,
                    noSpecialChars:true
                },
					
                'data[User][username]'			:	"required",
                'data[User][major]'				: {
                    required: true
															
                },
													  
                'data[User][country_id]'				: {
                    required: true
															
                },
													  

                'data[User][newpass]'			:	{
                    minlength:5
                },
                'data[User][newconfirmpass]'	:	{
                    equalTo: "#pass1"
                },
                'data[User][year]'				:	"required",
                'data[User][hometown]'			:	{ 
                    required:true
															
                },
                'data[User][school_status]'		:	"required",
					
                'data[User][file]'				:	{ accept:"png|jpeg|jpg|gif" }				
				
					
					
            },
            messages: {
					
                'data[User][firstname]'			:	{ 
                    required: "Please enter first name",
                    noSpecialChars: "Please enter valid data"
                },
                'data[User][lastname]'			:	{ 
                    required: "Please enter last name",
                    noSpecialChars: "Please enter valid data"
                },
												
                'data[User][newpass]'			:	{ 
														
                    minlength: "Please enter at least 5 characters"	
                },
                'data[User][newconfirmpass]'	:	{ 
													
                    equalTo:"Two password doesn't match"
                },	
				
                'data[User][major]'				:	{ 
                    required: "Please enter major"
														
                },	
                'data[User][country_id]'				:	{ 
                    required: "Please select country"
														
                },	
                'data[User][year]'				:	{ 
                    required: "Please select year"	
                },				
                'data[User][hometown]'			:	{ 
                    required: "Please enter hometown"
													
                },	
                'data[User][school_status]'		:	{ 
                    required: "Please select school status"	
                },
                'data[User][file]'		:			{ 
                    accept: "Image format is not valid"	
                }
												
            }	
        });

	
	
    });


</script>



<?php echo $javascript->link(array('jqurey-removeImg.js')); ?>
<?php echo $form->create('User', array('action' => 'index', 'name' => 'UserIndexForm', 'type' => 'file')); ?>
<?php echo $form->input('User.username', array('type' => 'hidden')); ?>	   
<input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">

<div class="profile_image">

    <?php if ($this->data['User']['image_url'] != '' && file_exists(WWW_ROOT . '/img/files/users/' . $this->data['User']['image_url'])) {
        ?>
        <div class="userProfileimage" id="checkImage"><?php echo $html->image('files/users/' . $this->data['User']['image_url'] . '', array('alt' => '', 'height' => '225', 'width' => '225')); ?><br/>
            <?php echo $html->link('Remove Image', array('action' => 'delimage', $this->data['User']['image_url']), array('class' => 'confirm_delete', 'id' => $this->data['User']['id'], 'image_url' => $this->data['User']['image_url'])); ?></div>

    <?php } else { ?>
        <div class="userProfileimage">
            <?php echo $html->image('files/users/noImage.jpg', array('alt' => '', 'height' => '225', 'width' => '225')); ?>
        </div>
    <?php } ?>



</div>
<!--profile container starts-->
<div class="profilecontainer">

    <div class="profileheading">

        <div id="ajax_msg_image_response"></div>
        <div class="headingTitle">Account Details</div>
        <div class="registerRequried"><span>&nbsp;</span>&nbsp;</div>
    </div>
    <div class="profile_form_fields">
        <div class="profilecontent">

            <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />

            <?php echo $form->input('User.username', array('type' => 'text', 'label'=>'Username','disabled'=>'disabled')); ?>
            
            <?php echo $form->input('User.oldpass', array('type' => 'password', 'id' => 'oldPass1', 'maxlength' => '14', 'label' => 'Old Password')); ?>

            <div class="input password">
                <?php echo $form->input('User.newpass', array('type' => 'password', 'id' => 'pass1', 'maxlength' => '14', 'label' => 'New Password', 'div' => false)); ?>

                <div class="pwd-strength">
                    <div class="bad" id="pass-strength-result">Strength indicator</div>
                </div>
                <div htmlfor="pass1" generated="true" class="error" style="display:none;">Please enter at least 5 characters: letters</div>
            </div>
            <?php echo $form->input('User.newconfirmpass', array('type' => 'password', 'id' => 'pass2', 'maxlength' => '14', 'label' => 'Confirm Password')); ?>
            <?php echo $form->input('User.firstname', array('maxlength' => '20', 'label' => 'First Name')); ?>
            <?php echo $form->input('User.lastname', array('maxlength' => '20', 'label' => 'Last Name')); ?>
            <?php
                /**
                 * Note: hiding Country select for now, users will default to US until we go International
                 */
                 echo $form->input('User.country_id', array('onchange' => 'getState(this.value)', 'value'=> '223', 'disabled' => 'true',  'type' => 'hidden', 'options' => $countries, 'empty' => 'Please Select', 'selected' => $countries_id, 'label' => 'Country'));

            ?>
            <div id="statediv">
                <?php echo $form->input('User.state_id', array('onchange' => 'getCity(this.value)', 'type' => 'select', 'options' => $states, 'empty' => 'Please Select', 'selected' => $states_id)); ?>
            </div>
            <div id="citydiv">
                <?php echo $form->input('User.city_id', array('type' => 'select', 'label' => 'City', 'options' => $cities, 'selected' => $cities_id, 'empty' => 'Please Select')); ?></div>
                <?php echo $form->input('User.hometown'); ?>
            <?php echo $form->input('User.school_id', array('type' => 'select', 'label' => 'School', 'disabled' => 'true', 'options' => $schools, 'selected' => $schools_id)); ?>
            <?php echo $form->input('User.email', array('type' => 'text', 'label'=>'School Email','disabled'=>'disabled')); ?>

             <?php echo $form->input('User.major'); ?>
            <?php echo $form->input('User.year', array('type' => 'select', 'options' => $years, 'selected' => $years_id, 'label' => 'Graduation Year', 'empty' => 'Please Select')); ?>
            <?php echo $form->input('User.school_status', array('options' => array('Current Student' => 'Current Student', 'Alumni' => 'Alumni'), 'type' => 'select', 'label' => 'School Status', 'selected' => $school_status, 'empty' => 'Please Select')); ?>
            <?php echo $form->input('file', array('type' => 'file', 'label' => 'Update Image ')); ?>
            <?php e($form->input('User.id', array('type' => 'hidden'))); ?>
            <?php e($form->input('User.image_url', array('type' => 'hidden'))); ?>

            <div class="profile_buttons">
                <?php echo $form->submit('buttonUpdate.gif'); ?>
                <?php if ($this->data['User']['autopass'] == 0) { ?>
                    <a href="<?php e($html->url('/')); ?>">
                        <?php echo $html->image('buttonCancel.gif', array('alt' => 'cancel')); ?>
                    </a>
                <?php } ?>
            </div>
            <?php echo $form->end(); ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="profilebottom"><div><span></span></div></div>
    <div class="clear"></div>
</div>
<!--profile container ENDS-->

<?php echo $form->end(); ?>
<script type="text/javascript">
    /* <![CDATA[ */

    try{convertEntities(commonL10n);}catch(e){};
    var pwsL10n = {
        empty: "Strength indicator",
        short: "Very weak",
        bad: "Weak",
        good: "Medium",
        strong: "Strong",
        mismatch: "Mismatch"
    };
    try{convertEntities(pwsL10n);}catch(e){};
    /* ]]> */
</script>
<?php echo $javascript->link(array('password-strength.js')); ?>