<script type="text/javascript">
$(document).ready(function(){
$("#forgotPassword").validate({
	
	rules: {
					'data[Admin][email]'			:{	 required: true,
														email:true
													}
																						
					
					
			   },
			   messages: {
					
					'data[Admin][email]':			{ 
														required: "Please enter email"	,
														email:"Please enter valid email"
													}
					
				
												
				}	
	});
	});

</script>
<div class="forget_main">
	<div class="forgot_pass">
		<?php 
			if( $msg == "" || $msg == "This email address does not exist" ) { ?> 
			<form method="post" id="forgotPassword" action="<?php e($html->url('/admin/admins/forgot_password/')) ?>">
			<div class="forgot_label">
			<?php if( $msg != "" ) { ?>
			<div class="error-message forgot_error">
			<?php echo $msg; ?>
			</div>
			<?php } ?>
				<label class="left">Please enter your email</label>
				<div class="left"><?php e($form->input('Admin.email', array('label'=>false,'div'=>false))); ?> </div>
				</div>
				<div class="forgot-submit-button"><input type="submit" value="Submit" /></div> 
			
			</form>
			<div class="clear"></div>
		<?php } else {
			
			echo "<br/><br/>".$msg;
			
		 } ?>
	</div>
	<div class="clear"></div>
</div>