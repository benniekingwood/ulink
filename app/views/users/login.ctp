<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">
    //FB_RequireFeatures(["XFBML"], function(){
			
    FB.init("cf0266cbd11fc7749378c8069b3543c3","/ulink/app/webroot/xd_receiver.htm");
    
</script>
<script language="javascript">
    //  Developed by Roshan Bhattarai 
    //  Visit http://roshanbh.com.np for this script and more.
    //  This notice MUST stay intact for legal use
    //cvv
    $(document).ready(function()
    {
	
        $("#login_form").submit(function()
        {
            //remove all the class add the messagebox classes and start fading
            $("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
            //check the username exists or not from ajax
            //alert(hostname+"users/login");
            $.post(hostname+"users/login",{ username:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
            {
                if(data=='yes') //if correct login detail
                {
                    $("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
                    { 
                        //add message and change the class of the box and start fading
                        $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
                        function()
                        { 
                            //redirect to secure page
                            //document.location=hostname;
                            window.location.reload();
                        });
			  
                    });
                }
		 
                else if(data=='std')
                {
                    $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                    { 
                        //add message and change the class of the box and start fading
                        $(this).html('Your account is inactive, please contact help@theulink.com.').addClass('messageboxerror').fadeTo(900,1);
                    });		
                }
		 
                else 
                {
                    $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                    { 
                        //add message and change the class of the box and start fading
                        $(this).html('Invalid Login...').addClass('messageboxerror').fadeTo(900,1);
                    });		
                }
				
            });
            return false; //not to post the  form physically
        });
	
        //now call the ajax also focus move from 
        $("#password").blur(function()
        {
            $("#login_form").trigger('submit');
        });
    });
</script>

<style type="text/css">
    .buttondiv {
        margin-top: 10px;
    }
    .messagebox{
        position:absolute;
        width:87px;
        border:1px solid #c93;
        background:#ffc;
        padding:3px;
        margin-left:87px;
    }
    .messageboxok{
        position:absolute;
        width:auto;
        margin-left:87px;
        border:1px solid #349534;
        background:#C9FFCA;
        padding:3px;
        font-weight:bold;
        color:#008000;

    }
    .messageboxerror{
        margin-left:87px;
        position:absolute;
        width:auto;
        border:1px solid #CC0000;
        background:#F7CBCA;
        padding:3px;
        font-weight:bold;
        color:#CC0000;
    }

    .checkboxclass input {
        float:left;
        width:18px !important;
    }

</style>
<div id="fb-root"></div>
<script type="text/javascript" language="javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId  : '213400365339060',
            status : true, // check login status
            cookie : true, // enable cookies to allow the server to access the session
            xfbml  : true  // parse XFBML
        });
    };

    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/de_DE/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
<div class="content">

    <div class="loginBox">

        <div class="loginHeading">Login with your uLink account</div>
        <div class="noaccountHeading"><a href="<?php e($html->url('/users/register')); ?>">No Account? Click Here!</a></div>

        <div class="clear"></div>
        <div>&nbsp;</div>
        <div><span id="msgbox" style="display:none"></span></div>
        <div>&nbsp;</div> 
        <?php //echo $session->flash('auth'); ?>
        <div class="clear"></div>
        <?php echo $form->create('User', array('action' => '#', 'id' => 'login_form')); ?>
        <?php echo $form->input('username', array('id' => 'username')); ?>
        <?php echo $form->input('password', array('id' => 'password')); ?>
        <div class="clear"></div>
        <div class ="checkboxclass"><?php e($form->checkbox('remember_me')) ?><span align="left">Remember Me</span>
            <span align="left">| <a href="<?php e($html->url('/users/forgotpassword')); ?>">Forgot Password?</a></span>
        </div>
        <div class="clear"></div>
        <div class="buttonLogin"><?php echo $form->submit('buttonLogin.gif', array('id' => 'loginButton', 'div' => false, 'class' => 'login_button')); ?></div>



        <div class="facebookIconBox"><span>or login with facebook</span>

            <?php
            if (isset($loggedInId)):
                if ($loggedInFacebookId > 0):
                    echo $html->link('logout', 'javascript:void(0);', array('onclick' => 'FB.Connect.logout(function() { document.location = hostname + \'users/logout/\'; }); return false;'));
                else:
                    echo $html->link('logout', array('controller' => 'members', 'action' => 'logout'));
                endif;
            else:
                echo '<fb:login-button onlogin="window.location.reload();"></fb:login-button>';
            endif;
            ?>
        </div>	   
        <?php echo $form->end(); ?>

        <div class="clear"></div>

    </div>

    <div class="clear"></div>
</div>



<div class="clear"></div>

<div class="clear"></div>