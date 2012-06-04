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
							This will be the answer to question 1
						</div>
					</li>
					<li>
						<a id="account-2-help-question" href="#">Why can't I change my password?</a>
						<div id="account-2-help-question-text" style="display: none">
							This will be the answer to question 2
						</div>
					</li>
					<li>
						<a id="account-3-help-question" href="#">How do I deactivate my account?</a>
						<div id="account-3-help-question-text" style="display: none">
							This will be the answer to question 2
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
								uLink will continue to add schools on a daily basis, but if your school is not on the site yet
							you can submit a suggestion of a school. Once we have enough demand for a school, we will add it to uLink.
						</div>
					</li>
					<li>
						<a id="signup-login-2-help-question" href="#">I am having trouble confirming my account</a>
						<div id="signup-login-2-help-question-text" style="display: none">
							This will be the answer to question 2
						</div>
					</li>
					<li>
						<a id="signup-login-3-help-question" href="#">I can't remember the email I used for my account</a>
						<div id="signup-login-3-help-question-text" style="display: none">
							This will be the answer to question 3
						</div>
					</li>
					<li>
						<a id="signup-login-4-help-question" href="#">My email address is already taken</a>
						<div id="signup-login-4-help-question-text" style="display: none">
							This will be the answer to question 4
						</div>
					</li>
					<li>
						<a id="signup-login-5-help-question" href="#">Why can't I register certain usernames?</a>
						<div id="signup-login-5-help-question-text" style="display: none">
							This will be the answer to question 5
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
								The is an answer....
						</div>
					</li>
					<li>
						<a id="ucampus-2-help-question" href="#">I have enabled my Twitter account, why are my tweets not showing up on my uCampus homepage?</a>
						<div id="ucampus-2-help-question-text" style="display: none">
							This is an answer for the question.
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
 $('a[id$="help-question"]').click(function() {
 	$('#'+event.target.id+'-text').slideToggle("slow");
 });
</script>