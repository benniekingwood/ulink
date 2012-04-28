<div class="container">
    <div class="hero-unit span7">
        <h1>Welcome to uLink.</h1>
        <p>Find out what's happening on your campus, right now.</p>
        <p>
            <a class="btn btn-warning btn-xlarge">
                Sign up for uLink
            </a>
        </p>
    </div>
    <div class="span3 well">
        <h3>Schools Supported</h3>
        <ul class="unstyled">
            <li>Old Dominion University</li>
            <li>Virginia Tech</li>
            <li>University of Virginia</li>
            <li>George Mason University</li>
            <li>James Madison University</li>
        </ul>
        <p>Don't see your school?</p>
        <p><a class="btn btn-warning" data-toggle="modal" href="#suggestComponent">Suggest Here</a></p>
    </div>
</div> <!-- /container -->
<!-- components section -->
<?php echo $this->element('suggest_school'); ?>
<!-- /components section -->