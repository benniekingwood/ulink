<div class="container-fluid">
    <div id="help-content" class="well well-white">
        <h1>Get uLink Help.</h1>
        <hr />
        <div class="row-fluid">
            <div id="help-nav" class="span3 well well-nopadding">
                <ul class="nav nav-list">
                    <li class="active"><a href="#signup-login-help-content" data-toggle="tab"><i class="icon-user"></i>Signup & Login Problems</a></li>
                    <li><a href="#account-help-content" data-toggle="tab"><i class="icon-cog"></i>My Profile & Account Settings</a></li>
                    <li><a href="#ucampus-help-content" data-toggle="tab"><i class="icon-home"></i>uCampus</a></li>
                </ul>
            </div>
            <div class="span8">
                <div class="tab-content">
                    <div class="tab-pane" id="account-help-content">
                        <h3>My Profile & Account Settings</h3>
                        <ul>
                            <li>
                                <a id="account-1-help-question" href="#">I can't upload my profile picture</a>
                                <div id="account-1-help-question-text" style="display: none">
                                    Make sure your photo matches the requirements.  The file type must be .png, .gif, or .jpg with a size no greater than 700k.
                                </div>
                            </li>
                            <li>
                                <a id="account-2-help-question" href="#">Why can't I change my password?</a>
                                <div id="account-2-help-question-text" style="display: none">
                                    You must know your current password in order to change your password.  If you do not know your password, you can reset it back via the <a href="<?php echo $this->Html->url('/users/forgotpassword'); ?>">forgotten password page</a>.
                                </div>
                            </li>
                            <li>
                                <a id="account-3-help-question" href="#">How do I deactivate my account?</a>
                                <div id="account-3-help-question-text" style="display: none">
                                    Once logged in to uLink, navigate to the My Profile page by clicking the Manage My Profile link at the top right of the page.  Click the "deactivate my account" link next to your profile photo.
                                </div>
                            </li>
                            <li>
                                <a id="account-4-help-question" href="#">How do I reactivate my account?</a>
                                <div id="account-4-help-question-text" style="display: none">
                                    All you have to do is simply log back into uLink, and you're reactivated!
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane active" id="signup-login-help-content">
                        <h3>Signup & Login Problems</h3>
                        <ul>
                            <li>
                                <a id="signup-login-1-help-question" href="#">I can't create an account because my school is not available, what can I do?</a>
                                <div id="signup-login-1-help-question-text" style="display: none">
                                    uLink will continue to add schools on a weekly basis, if your school is not available you can utilize the suggest of a school feature on the uLink <a href="<?php echo $this->Html->url('/'); ?>">homepage</a>. Once we have enough requests for a school, we will add it to uLink.
                                </div>
                            </li>
                            <li>
                                <a id="signup-login-2-help-question" href="#">I am having trouble activating my account</a>
                                <div id="signup-login-2-help-question-text" style="display: none">
                                    If you are not receiving an activation email after your initial signup, please contact <a href="mailto:help@theulink.com">help@theulink.com</a>.  If you do receive the activation email, please click the "Activate My Account" link, and your account will be activated.
                                </div>
                            </li>
                            <li>
                                <a id="signup-login-3-help-question" href="#">I can't remember the email I used for my account</a>
                                <div id="signup-login-3-help-question-text" style="display: none">
                                    If you cannot remember your email, please contact <a href="mailto:help@theulink.com">help@theulink.com</a>, providing your username and concerns in the message.
                                </div>
                            </li>
                            <li>
                                <a id="signup-login-4-help-question" href="#">I have lost access to my account's email address</a>
                                <div id="signup-login-4-help-question-text" style="display: none">
                                    If you've lost access to the email address that's linked to your uLink account, please contact your email service provider to work to regain access.
                                </div>
                            </li>
                            <li>
                                <a id="signup-login-5-help-question" href="#">Why can't I register certain usernames?</a>
                                <div id="signup-login-5-help-question-text" style="display: none">
                                    uLink has requirements for usernames, and does not allow duplicate usernames for accounts.
                                </div>
                            </li>
                            <li>
                                <a id="signup-login-6-help-question" href="#">My account has been hacked, help!</a>
                                <div id="signup-login-6-help-question-text" style="display: none">
                                    If you believe your account has been compromised/hacked, you can do the following:
                                    <ul class="unstyled">
                                        <li>
                                            Reset your password via the <a href="<?php echo $this->Html->url('/users/forgotpassword'); ?>">forgotten password page</a>.
                                        </li>
                                        <li>
                                            Contact help@theulink.com with "Compromised Account" as the subject, with your username and account email in the message body.
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="ucampus-help-content">
                        <h3>uCampus Problems</h3>
                        <ul>
                            <li>
                                <a id="ucampus-1-help-question" href="#">I have submitted my event, why can't I see it on my uCampus homepage?</a>
                                <div id="ucampus-1-help-question-text" style="display: none">
                                    Your event will initially be reviewed by a uLink moderator, in which once it is approved will be available on your uCampus page.  The wait period is up to 24 hours for your event to display.
                                </div>
                            </li>
                            <li>
                                <a id="ucampus-2-help-question" href="#">I have enabled my Twitter account, why are my tweets not showing up on my uCampus homepage?</a>
                                <div id="ucampus-2-help-question-text" style="display: none">
                                    Verify that you have correctly entered and enabled your Twitter username from the Manage Profile section.  Your Twitter account must be public (not protected) in Twitter in order for uLink to successfully retrieve your tweets.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> <!-- /tab-content -->
            </div>
        </div> <!-- /row-fluid -->
    </div><!-- /well well-white -->
</div><!--/container -->
<script>
    $('a[id$="help-question"]').click(function(event) {
        $('#'+event.target.id+'-text').slideToggle("fast");
    });

</script>