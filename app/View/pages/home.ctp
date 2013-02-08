<script type="text/javascript">
    $(document).ready(function () {
        // randomly choose between 1-5 for the background image
        var random = Math.ceil(Math.random()*5);
        var bgClass =  'splash-hero-bg-' + random;
        $('#splash-hero').addClass(bgClass);
    });
</script>
<div class="container">
    <div class="row splash-container">
        <div id="splash-hero" class="hero-unit span7 splash-hero-container">
            <h1>Welcome to uLink.</h1>
            <p>Find out what's happening on your campus, right now.</p>
            <p>
                <?php if (!isset($loggedInId)) { ?>
                <a class="btn btn-warning btn-xlarge" href="<?php echo($this->Html->url('/users/register'));?>">
                    Sign up for uLink »
                </a>
                <?php } ?>
                <a class="btn btn-warning btn-xlarge" href="<?php echo($this->Html->url('/pages/about'));?>">
                    Learn More »
                </a>
            </p>
        </div>
        <div class="span3 well well-white schools-supported-container">
            <h3>Schools Supported</h3>
            <ul class="unstyled schools-supported-list">
                <li>Old Dominion University</li>
                <li>Virginia Tech</li>
                <li>University of Virginia</li>
                <li>George Mason University</li>
                <li>James Madison University</li>
                <li>UCLA</li>
                <li>Maryland</li>
            </ul>
            <p><i>Don't see your school?</i></p>
            <p><a class="btn btn-warning" data-toggle="modal" href="#suggestComponent">Suggest Here</a></p>
        </div>
    </div>
</div> <!-- /container -->
<!-- components section -->
<?php echo $this->element('suggest_school'); ?>
<!-- /components section -->