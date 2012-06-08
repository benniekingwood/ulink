<script type="text/javascript">
function getStatecho(countryId) {		
		getCity();
		var strURL=hostname+"/admin/users/user_state/"+countryId;
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
		var strURL=hostname+"/admin/users/user_city/"+stateId;
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
$(document).ready(function(){
	
	//global vars
	var form = $("#UserAdminUserEditForm");
	var name = $("#UserFirstname");
	var lastName = $("#UserLastname");
	
	var nameInfo = $("#nameInfo");
	var lastNameInfo = $("#lastNameInfo");
	
	var major = $("#UserMajor");
	var majorInfo = $("#majorInfo");
	
	var hometown = $("#UserHometown");
	var hometownInfo = $("#hometownInfo");
	
	var oldPass1 = $("#oldPass1");
	var pass1 = $("#pass1");
	var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");
	var pass2Info = $("#pass2Info");
	
	var UserYear = $("#UserYear");
	var UserSchoolStatus = $("#UserSchoolStatus");

	//On blur
	name.blur(validateName);
	lastName.blur(validateLastName);
	
	major.blur(validateMajor);
	hometown.blur(validateHometown);
	
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
	
	//selCountry.blur(validateCountry);
	//On key press
	name.keyup(validateName);
	lastName.keyup(validateLastName);
	//pass1.keyup(validatePass1);
	//pass2.keyup(validatePass2);
	
	//OnChange
	
	UserYear.changecho(validateYearSel);
	UserSchoolStatus.changecho(validateStatusSel);
	
	//On Submitting
	form.submit(function(){
	  
		if(validateNamecho() & validateLastNamecho() & validateHometown() & validateMajor() & validateYearSel() & validateStatusSel() & changePassWord()){
			return true;
			}
		else{
		 	return false;
			}
	});
	
	function changePassWord(){
	if(oldPass1.val().length>0) {
	    if(validatePass1() & validatePass2())
		  return true;
	     else 
		  return false;
   	   }
	
	else 
	    return true;
    
	} 
	
	
	function validatePass1(){
		var a = $("#pass1");
		var b = $("#pass2");

		//it's NOT valid
		if(pass1.val().length <5){
			pass1.addClass("error");
			pass1Info.text("Remember: At least 5 characters");
			pass1Info.addClass("error");
			return false;
		}
		//it's valid
		else{			
			pass1.removeClass("error");
			pass1Info.text("");
			pass1Info.removeClass("error");
			validatePass2();
			return true;
		}
	}
	function validatePass2(){
		var a = $("#pass1");
		var b = $("#pass2");
		//are NOT valid
		if( pass1.val() != pass2.val() ){
			pass2.addClass("error");
			pass2Info.text("Passwords doesn't match!");
			pass2Info.addClass("error");
			return false;
		}
		//are valid
		else{
			pass2.removeClass("error");
			pass2Info.text("Confirm password");
			pass2Info.removeClass("error");
			return true;
		}
	}
	
	
	function validateNamecho(){
		//if it's NOT valid
		if(name.val().length < 4){
			name.addClass("error");
			nameInfo.text("We want names with more than 3 letters!");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("Done");
			nameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateLastNamecho(){
		//if it's NOT valid
		if(lastName.val().length < 4){
			lastName.addClass("error");
			lastNameInfo.text("We want names with more than 3 letters!");
			lastNameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			lastName.removeClass("error");
			lastNameInfo.text("Done");
			lastNameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateHometown(){
		//if it's NOT valid
		if(hometown.val().length < 1){
			hometown.addClass("error");
			hometownInfo.text("Required");
		    hometownInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			hometown.removeClass("error");
			hometownInfo.text("Done");
			hometownInfo.removeClass("error");
			return true;
		}
	}
	
	function validateMajor(){
		//if it's NOT valid
		if(major.val().length < 1){
			major.addClass("error");
			majorInfo.addClass("error");
			majorInfo.text("Required");
			
			return false;
		}
		//if it's valid
		else{
			major.removeClass("error");
			majorInfo.text("Done");
			majorInfo.removeClass("error");
			return true;
		}
	}
	
	function validateYearSel(){
		//it's NOT valid
		if(document.getElementById('UserYear').selectedIndex== 0){
 		UserYear.addClass("userYearError");
		return false;
		}
		//it's valid
		else{	
            UserYear.removeClass("userYearError");
			return true;
		}
	}
	
	
	function validateStatusSel(){
		//it's NOT valid
		if(document.getElementById('UserSchoolStatus').selectedIndex== 0){
 		UserSchoolStatus.addClass("userStatusError");
		return false;
		}
		//it's valid
		else{	
            UserSchoolStatus.removeClass("userStatusError");
			return true;
		}
	}
	
	
	
});z
</script>

<?php echo $this->Html->script(array('jqurey-removeImg.js')); ?>
<div class="login">
        	
	     <?php echo $this->Form->create(('User', array('action' => 'admin_user_edit','type'=>'file'));?>
	
		 <?php echo $this->Form->input('User.username', array('type'=>'hidden'));?><br/>
		 
		 <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">
		 
                <div class="form_input_box">
			<label>Username:</label>
			<?php echo($this->Form->text('User.username', array('label'=>false,'div'=>false,'disabled'=>'disabled'))); ?>
		</div>

		 <div class="form_input_box">
			<label>Old Password:</label>
			<?php echo($this->Form->password('User.oldpass', array('label'=>false,'div'=>false,'id'=>'oldPass1','maxlength'=>'14'))); ?>
		</div>
		  
		
		 <div class="form_input_box">
			<label>New Password:</label>
			<?php echo($this->Form->password('User.newpass', array('label'=>false,'div'=>false,'id'=>'pass1','maxlength'=>'14'))); ?>
			<div class="bad" id="pass-strength-result"></div>
		</div>
		 
		 <div class="form_input_box">
			<label>Confirm Password:</label>
			<?php echo($this->Form->password('User.newconfirmpass', array('label'=>false,'div'=>false,'id'=>'pass2','maxlength'=>'14'))); ?>
			<span id="pass2Info" class="error"></span>
		</div>
		 
		  <div class="form_input_box">
			<label>First Name:</label>
			<?php echo($this->Form->text('User.firstname', array('label'=>false,'div'=>false))); ?>
			<span id="nameInfo" class="error"></span>
		</div>
		 <div class="form_input_box">
			<label>Last Name:</label>
			<?php echo($this->Form->text('User.lastname', array('label'=>false,'div'=>false))); ?>
			<span id="lastNameInfo" class="error"></span>
		</div>
		  

		  <div class="form_input_box">
			<label>Country:</label>
			<?php echo $this->Form->select('User.country_id',$countries,$countries_id,array('onchange'=>'getStatecho(this.value)','label'=>false,'div'=>false),'Please Select');?>
			
		</div>
		
		 <div class="form_input_box">
			<label>State:</label>
			<div id="statediv" class="left"> 
		 <?php echo $this->Form->select('User.state_id',$states,$states_id,array('onchange'=>'getCity(this.value)','div'=>false,'label'=>false),'Please Select');?>
		</div>
		</div>
		
		  <div class="form_input_box">
			<label>City:</label>
			<div id="citydiv" class="left"> 
		 <?php echo $this->Form->select('User.state_id',$cities,$cities_id,array('div'=>false,'label'=>false),'Please Select');?>
		</div>
		</div>
		 
	
		  <div class="form_input_box">
			<label>Major:</label>
			<?php echo $this->Form->text('User.major',array('label'=>false,'div'=>false));?>
			<span id="majorInfo" class="error"></span>
			
		</div>
		 
		 
		 <div class="form_input_box">
			<label>Year:</label>
		<?php echo $this->Form->select('User.year',$years,$years_id,'','Please Select',array('label'=>false,'div'=>false));?>
			
			
		</div>
		
		<div class="form_input_box">
			<label>HomeTown:</label>
		<?php echo $this->Form->text('User.hometown',array('label'=>false,'div'=>false));?>
			</div>
		
				<div class="form_input_box">
			<label> School Status:</label>
		<?php echo $this->Form->select('User.school_status',array( 'Current Student' => 'Current Student','Alumni' => 'Alumni' ),$school_status,'','Please Select',array('div'=>false,'div'=>false));?>

		 	</div>

		 	<div class="form_input_box">
				<label> File:</label>
				<?php echo $this->Form->input('file', array('type'=>'file','label'=>false,'div'=>false)); ?>
		 	</div>
	
		  

		   <?php if($this->data['User']['image_url']){ ?>
		   <div id="imageshow"><?php echo $this->Html->image(('files/users/'.$this->data['User']['image_url'].'',array('alt'=>'','height'=>'100','width'=>'100'));?>
		   <?php echo $this->Html->link('Remove Image',array('action'=>'delimage',$this->data['User']['image_url']),array('class'=>'confirm_delete','id'=>$this->data['User']['id'],'image_url'=>$this->data['User']['image_url']));?></div>
		
		<?php } ?>
		  
		  <?php echo($this->Form->text('User.id', array( 'type'=>'hidden') )); ?><br/>
		  
		  	<div class="form_input_box">
				<label>&nbsp;</label>
				<?php echo $this->Form->submit('Update',array('class'=>left,'div'=>false));?>
				<a href="<?php echo($this->Html->url('/admin/users/index')); ?>"><b>Cancel</b></a>
		 </div>
		 
	    <?php echo $this->Form->end(); ?>
	
</div>

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
<?php echo $this->Html->script(array('password-strength.js')); ?>

