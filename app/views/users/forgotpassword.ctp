<script type="text/javascript">
$(document).ready(function(){
    $("#UserForgotpasswordForm").validate({
        rules: {
            'data[User][email]':{	 required: true,
            email:true
            }
        },
        messages: {
            'data[User][email]':{ 
            required: "Please enter email"	,
            email:"Please enter valid email"
            }
        }	
    });
});

</script>

<div class="content">
    <div id="blueBox">
        <div class="top">
            <span class="left"><?php echo $html->image('blue-border-box-top-left.gif',array('alt'=>''));?></span>
            <span class="right"><?php echo $html->image('blue-border-box-top-right.gif',array('alt'=>''));?></span>
            <div class="clear"></div>
        </div>
        <div class="form_forgot content">
            <div style ="margin:auto; width:500px;line-height: 18px; text-align:left;">Follow the steps below and you will receive a temporary password by email. <br />Enter the email address registered on your uLink account</div>
            <div style="margin:auto; width:500px;">
				<?php echo $form->create('User', array('action' => 'forgotpassword'));?>

                <div class="enter-email"> 
                     <?php echo $form->text('email', array('class'=>'forgotemail'));?>
                    <span htmlfor="UserEmail" generated="true" class="error" style="display:block;"></span>
                </div>
                <br />
                    <div style="padding-top:20px;"><?php echo $form->submit('submit.gif');?></div>
                    
					  <?php echo $form->end(); ?>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div></div>
        </div>
        <div class="clear"></div>
        <div class="bottom">
            <span class="left"><?php echo $html->image('blue-border-box-bottom-left.gif',array('alt'=>''));?></span>
            <span class="right"><?php echo $html->image('blue-border-box-bottom-right.gif',array('alt'=>''));?></span>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>