<script type="text/javascript">


$(document).ready(function(){
 
	$("#UserAdminUserAddForm").validate({
	rules: {
					'data[User][firstname]'			:	"required",
					'data[User][lastname]'			:	"required",
					
					'data[User][username]'			:	"required",
					'data[User][Major]'				: {
															required: true,
															minlength:3
													  },
													  
					'data[User][email]'				: {
															required: true,
															email:true
													  },
					'data[User][school_id]'			:	"required",
					'data[User][password]'			:	{
															required: true,
															minlength:5
														},
					'data[User][confirm_password]'	:	{
															required: true,
															equalTo: "#pass1"
														},
					'data[User][year]'				:	"required",
					'data[User][hometown]'			:	{ 
															required:true,
															minlength:3
														},
					'data[User][school_status]'		:	"required",
			   },
			   messages: {
					
					'data[User][firstname]'			:	{ 
														required: "Please enter first name"	
														},
					'data[User][lastname]'			:	{ 
														required: "Please enter last name"	
														},
												
					'data[User][password]'			:	{ 
														required: "Please enter password",
														minlength: "Please enter at least 5 characters: letters"	
														},
					'data[User][confirm_password]'	:	{ 
														required: "Please enter password",
														equalTo:"Two password doesn't match"
														},	
					'data[User][school_id]'			:	{ 
														required: "Please select school"	
														},
					'data[User][Major]'				:	{ 
														required: "Please enter major",
														minlength: "We want names with more than 3 letters! "		
														},	
					'data[User][year]'				:	{ 
														required: "Please select year"	
														},				
					'data[User][hometown]'			:	{ 
														required: "Please enter hometown",
														minlength: "We want names with more than 3 letters! "			
														},	
					'data[User][school_status]'		:	{ 
														required: "Please select school status"	
														},									
					'data[User][email]'			:	{ 
														required: "Please enter school email",
														email: "Please enter valid email "			
														},	
					
					
												
				}	
	});
		 
}); 


function getState(countryId) {
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
	
	function getschoolId(){
		var s = $("#UserSchoolId").val();
		document.UserAdminUserAddForm.UserSelectedSchool.value=s;
		}
</script>

<?php echo $form->create('User', array('action' => 'admin_user_add','name'=>'UserAdminUserAddForm','type'=>'file'));?>
	
	
		 <div class="form_input_box">
		 <label for="UserFirstname">First Name</label>
		<?php echo $form->input('User.firstname',array('div'=>false,'label'=>false));?>
		</div> 
         <div class="form_input_box">
		 
		 <label for="UserLastname">Last Name</label>
		 <?php echo $form->input('User.lastname',array('div'=>false,'label'=>false));?>
	</div>	
	 <div class="form_input_box">
	 <label for="UserUsername">User Name</label>
		 <?php echo $form->input('User.username',array('onKeyup'=>'return chkemailByAdmin();','div'=>false,'label'=>false));?>
		  <div id="searchResult_username"></div>
		  </div>
		  <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">
		  <div class="form_input_box">
		 <?php echo $form->input('User.password',array('id'=>'pass1','div'=>false));?>
		
		 <div class="bad" id="pass-strength-result"></div>
		 </div>
		  <div class="form_input_box">
		
		 <?php echo $form->input('User.confirm_password',array( 'type'=>'password','id'=>'pass2','label'=>'Confirm Password','div'=>false)); ?><br/>
		</div>
		  <div class="form_input_box">
		<label>Country</label>
		  <?php echo $form->select('User.country_id',$countries,'',array('onchange'=>'getState(this.value)','label'=>'Country','div'=>false),'Please Select');?>							<br/>
	</div>
	
	 <div class="form_input_box">
	  <label>State</label>
		<div id="statediv">
			<select name="state" >
			<option>Select Country First</option>
			</select>
		</div><br/>
	  </div>
	  <div class="form_input_box">
	  <label>City </label><div id="citydiv">
	  <select name="city" >
	  <option>Select State First</option>
	  </select></div><br/>
		</div>
		<div class="form_input_box">
		 <label>School</label> 
		 <?php echo $form->select('User.school_id',$schools,'',array('onchange'=>'getschoolId(this.value)','div'=>false),'Please Select');?><br/>
		</div>
		 
		 <?php echo $form->input('User.selectedSchool',array('type'=>'hidden'));?><br/>
		 
		  
		<div class="form_input_box">
		 <label for="UserEmail">School email</label> 
		 <?php echo $form->input('User.email',array('label'=>false,'div'=>false));?>
		 <div id="searchResult_email">
		
		
		 </div>
		</div>
		 
		 <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
		 
		 <div class="form_input_box">
		 <label for="UserMajor">Major</label> <?php echo $form->input('User.major',array('div'=>false,'label'=>false));?> 
		</div>
		 <div class="form_input_box">
		<label > Year</label><?php echo $form->input('User.year',array('type'=>'select','div'=>false,'empty'=>'Please select','options'=>$years,'label'=>false));?>
		 </div>
		 <div class="form_input_box">
		 <label for="UserHometown">Hometown*</label> <?php echo $form->input('User.hometown',array('div'=>false,'label'=>false));?>
		</div>
		 <div class="form_input_box">
		<label>School Status</label>  
		 
		 <?php echo $form->input('User.school_status',array('options'=>array('Current Student' => 'Current Student','Alumni' => 'Alumni'),'div'=>false,'label'=>false));?>
		  </div>
		  
		  <div class="form_input_box">
		 <label for="UserFile">File</label>
		  <?php echo $form->input('User.file', array('type'=>'file','label'=>false,'div'=>false)); ?>
		   
		  </div>
		   <div class="form_input_box">
		   <label for="UserFile">&nbsp;</label>
		  <?php echo $form->submit('Submit');?> 
		  <div><a href="<?php e($html->url('/admin/users/index')); ?>"><b>Cancel</b></a></div>
		 
		 </div>
	    <?php echo $form->end(); ?>
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
<?php echo $javascript->link(array('password-strength.js')); ?>		
