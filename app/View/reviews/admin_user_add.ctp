<style "text/css">
/******* FORM *******/
#UserAdminUserAddForm{
	padding: 0 10px 10px;
}
#UserAdminUserAddForm label{
	display: block;
	color: #797979;
	font-weight: 700;
	line-height: 1.4em;
}
#UserAdminUserAddForm input{
	width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;
}
#UserAdminUserAddForm input.error{
	background: #f8dbdb;
	border-color: #e77776;
}
#UserAdminUserAddForm textarea{
	width: 550px;
	height: 80px;
	padding: 6px;
	color: #adaeae;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-style: italic;
	font-size: 12px;
	border: 1px solid #cecece;
}
#UserAdminUserAddForm textarea.error{
	background: #f8dbdb;
	border-color: #e77776;
}

.userSchoolSel{
   width:200px;	
}

.userSchoolSelError{
	background: #f8dbdb;
	width:200px;
	border-color: #e77776;
}


.userYearSel{
   width:200px;	
}

.userYearError{
	background: #f8dbdb;
	width:200px;
	border-color: #e77776;
}

.userStatusSel{
   width:200px;	
}

.userStatusError{
	background: #f8dbdb;
	width:200px;
	border-color: #e77776;
}


#UserAdminUserAddForm div{
	margin-bottom: 15px;
}
#UserAdminUserAddForm div span{
	margin-left: 10px;
	color: #b1b1b1;
	font-size: 11px;
	font-style: italic;
}
span.error{
	color: #e46c6e;
}
#UserAdminUserAddForm #send{
	background: #6f9ff1;
	color: #fff;
	font-weight: 700;
	font-style: normal;
	border: 0;
	cursor: pointer;
}
#UserAdminUserAddForm #send:hover{
	background: #79a7f1;
}
#error{
	margin-bottom: 20px;
	border: 1px solid #efefef;
}
#error ul{
	list-style: square;
	padding: 5px;
	font-size: 11px;
}
#error ul li{
	list-style-position: inside;
	line-height: 1.6em;
}
#error ul li strong{
	color: #e46c6d;
}
#error.valid ul li strong{
	color: #93d72e;
}
/******* /FORM *******/
</style>
<script type="text/javascript">



function getStatecho(countryId) {
        var ko = '<?php echo $_SESSION['admin_id']; ?>';
		if(!ko){ alert('<?php echo $_SESSION['admin_id']; ?>');}
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
function getschoolId(){
		var s = $("#UserSchoolId").val();
		document.UserAdminUserAddForm.UserSelectedSchool.value=s;
		}

$(document).ready(function(){
	//global vars
	var form = $("#UserAdminUserAddForm");
	var name = $("#UserFirstname");
	var lastName = $("#UserLastname");
	var nameInfo = $("#nameInfo");
	var lastNameInfo = $("#lastNameInfo");
	var userName = $("#UserUsername");
	var userNameInfo = $("#userNameInfo");
	var email = $("#UserEmail");
	var emailInfo = $("#emailInfo");
	var pass1 = $("#pass1");
	var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");
	var pass2Info = $("#pass2Info");
	
	var UserSchoolId = $("#UserSchoolId");
	var UserYear = $("#UserYear");
	var UserSchoolStatus = $("#UserSchoolStatus");
	
	
	var major = $("#UserMajor");
	var majorInfo = $("#majorInfo");
	
	var hometown = $("#UserHometown");
	var hometownInfo = $("#hometownInfo");
	
	var schooldomainCheck = $("#schooldomainCheck");

	//On blur
	name.blur(validateName);
	lastName.blur(validateLastName);
	email.blur(validateEmail);
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
	
    major.blur(validateMajor);
	hometown.blur(validateHometown);
	
	//On Change
	UserSchoolId.changecho(validateSchoolSel);
	UserYear.changecho(validateYearSel);
	UserSchoolStatus.changecho(validateStatusSel);
		
	
	//selCountry.blur(validateCountry);
	//On key press
	name.keyup(validateName);
	lastName.keyup(validateLastName);
	pass1.keyup(validatePass1);
	pass2.keyup(validatePass2);
	
	//On Submitting
	form.submit(function(){
	  
		if(validateNamecho() & validateLastNamecho() & validateEmail() & validatePass1() & validatePass2() & validateUserNamecho() & validateHometown() & validateMajor() & validateSchoolSel() & validateYearSel() & validateStatusSel() & validatedomainCheck())
			return true;
		else
			return false;
	});
	
	//validation functions
	function validateEmail(){
		//testing regular expression
		 var a = $("#UserEmail").val();
		 if(document.UserAdminUserAddForm.UserSelectedSchool.value==0){ 
		   email.addClass("error");
		   emailInfo.text("Please Select Your School first");
		   emailInfo.addClass("error");
		   return false;}
		   else if(a=="") {
		    email.addClass("error");
			emailInfo.text("Enter your valid emain that has the school domain in it");
			emailInfo.removeClass("error");
			return false;
		   }
		   else {
		    email.removeClass("error");
			emailInfo.text("Please wait...");
			emailInfo.removeClass("error");
			chkschooldomainByAdmin();
			return true;
		   }
		
	}
	
	function validateSchool(){
		
		 if(document.UserAdminUserAddForma.UserSelectedSchool.value==0){ 
		   schoolInfo.text("Please Select Your School first");
		   schoolInfo.addClass("error");
		   return false;
		    }
		   else {
		    schoolInfo.text("Now enter your school email");
			schoolInfo.removeClass("error");
			return false;
		   }
	}
	
	function validateNamecho(){
		//if it's NOT valid
		if(name.val().length < 3){
			name.addClass("error");
			nameInfo.text("Firstname should be at least 3 characters");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("What's your First name?");
			nameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateLastNamecho(){
		//if it's NOT valid
		if(lastName.val().length < 2){
			lastName.addClass("error");
			lastNameInfo.text("Lastname should be at least 2 characters");
			lastNameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			lastName.removeClass("error");
			lastNameInfo.text("What's your Last name?");
			lastNameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateUserNamecho(){
		//if it's NOT valid
		if(userName.val().length < 3){
			userName.addClass("error");
			userNameInfo.text("More then two chatacters required");
			userNameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			userName.removeClass("error");
			userNameInfo.text("Done");
			userNameInfo.removeClass("error");
			return true;
		}
	}
	
	
	function validatePass1(){
		var a = $("#pass1");
		var b = $("#pass2");

		//it's NOT valid
		if(pass1.val().length <5){
			pass1.addClass("error");
			pass1Info.text("Ey! Remember: At least 5 characters: letters, numbers and '_'");
			pass1Info.addClass("error");
			return false;
		}
		//it's valid
		else{			
			pass1.removeClass("error");
			pass1Info.text("At least 5 characters: letters, numbers and '_'");
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
	function validateMessagecho(){
		//it's NOT valid
		if(message.val().length < 10){
			message.addClass("error");
			return false;
		}
		//it's valid
		else{			
			message.removeClass("error");
			return true;
		}
	}
	
	
	function validateHometown(){
		//if it's NOT valid
		if(hometown.val().length < 3){
			hometown.addClass("error");
			hometownInfo.text("We want names with more than 3 letters!");
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
		if(major.val().length < 2){
			major.addClass("error");
			majorInfo.text("We want names with more than 3 letters!");
			majorInfo.addClass("error");
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
	
	
	function validateSchoolSel(){
		//it's NOT valid
		if(document.getElementById('UserSchoolId').selectedIndex== 0){
 		UserSchoolId.addClass("userSchoolSelError");
		return false;
		}
		//it's valid
		else{	
            UserSchoolId.removeClass("userSchoolSelError");
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
	
	function validatedomainCheck(){
		//if it's NOT valid
		if(schooldomainCheck.val()==0){
			email.addClass("error");
			return false;
		}
		//if it's valid
		else{
			email.removeClass("error");
			return true;
		}
	}
	
	
	
});
</script>

<?php echo $this->Form->create(('User', array('action' => 'admin_user_add','name'=>'UserAdminUserAddForm','type'=>'file'));?>
	
		<?php echo $this->Form->input('firstname');?> 
         <span id="nameInfo" class="error">Required more than three characters!</span>
		 
		 
		 <?php echo $this->Form->input('lastname');?>
		 <span id="lastNameInfo" class="error">Required more than three characters!</span>
		 
		 <?php echo $this->Form->input('username',array('onKeyup'=>'return chkemailByAdmin();'));?>
		  <div id="searchResult_username"></div>
		  
		  <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">
		 
		 <?php echo $this->Form->input('password',array('id'=>'pass1'));?>
		 <span id="pass1Info">At least 5 characters: letters</span>
		 <div class="bad" id="pass-strength-result"></div>
		 
		 
		 Confirm Password<br/>
		 <?php echo $this->Form->text('confirm_password',array( 'type'=>'password','id'=>'pass2')); ?><br/>
		 <span id="pass2Info" class="error">Passwords doesn't match!</span>
		 
		 <br/><br/>
		 Country <?php echo $this->Form->select('country_id',$countries,'',array('onchange'=>'getStatecho(this.value)'),'Please Select');?>							<br/>
	
	  State <div id="statediv">
	  <select name="state" >
	  <option>Select Country First</option>
	  </select></div><br/>
	  
	  City <div id="citydiv">
	  <select name="city" >
	  <option>Select State First</option>
	  </select></div><br/>
		
		 School 
		 <?php echo $this->Form->select('school_id',$schools,'',array('onchange'=>'getschoolId(this.value)'),'Please Select');?><br/>
		 <?php echo $this->Form->error('User.school_id');?>
		 
		 <?php echo $this->Form->input('selectedSchool',array('type'=>'hidden'));?><br/>
		  <span id="schoolInfo" class="error">Please Select your school</span>
		  
		  <br/>
		  School email
		 <?php echo $this->Form->input('email',array('label'=>false));?>
		 <div id="searchResult_email">
		 <br/>
		 <span id="emailInfo" class="error">Required for registration confirmation</span>
		 </div>
		 <br/>
		 
		 <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
		 
		 
		 Major <?php echo $this->Form->text('major');?> <?php echo $this->Form->error('User.major');?>
		  <span id="majorInfo" class="error">Required more than three characters!</span> <br/>
		 
		 Year<?php echo $this->Form->select('year',$years,'','','Please Select');?><br/>
		 
		 Hometown* <?php echo $this->Form->text('hometown');?><?php echo $this->Form->error('User.hometown');?>
		  <span id="hometownInfo" class="error">Required more than three characters!</span> <br/>
		 
		 School Status 
		 
		 <?php echo $this->Form->select('school_status',array( 'Current Student' => 'Current Student','Alumni' => 'Alumni' ),'','','Please Select');?>
		  <?php echo $this->Form->input('file', array('type'=>'file')); ?>
		   
		  
		  <?php echo $this->Form->submit('Submit');?> <div><a href="<?php echo($this->Html->url('/admin/users/index')); ?>"><b>Cancel</b></a></div>
		 
		 
	    <?php echo $this->Form->end(); ?>
<script type="text/javascript" charset="utf-8">
	if (window.location.hash == '#password') {
		document.getElementById('pass1').focus();
	}
</script>

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