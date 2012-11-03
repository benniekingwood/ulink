<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>uLink | Your college everything</title>
    <?php
     // print meta tags
        echo $this->Html->meta('icon');
        echo $this->Html->meta('viewport','width=device-width, initial-scale=1.0');
        echo $this->Html->meta('description','Handle your everyday college activities with uLink.');
        echo $this->Html->meta('author','uLink, Inc.');

        // print styles
        echo $this->Html->css(array('bootstrap.css', 'ulink.css','bootstrap-responsive.css'));
        echo $this->Html->script(array('jquery.min.js','var.js', 'validate.js','ulink-browser-check.js'));
    ?>

    <!--  HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--  favicon and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

<div id="ulink-nav" class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo $this->Html->url('/'); ?>">
                <?php echo $this->Html->image('logouLink_7539.png', array('alt' => 'ulinklogo')); ?>
            </a>
            <div class="nav-collapse">
                <ul class="nav span3">
                    <li id="ucampus-module">
                        <a class="module" href="<?php echo($this->Html->url('/ucampus')); ?>">
                        <i class="ulink-icon-ucampus"></i>uCampus
                        </a>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div><!-- /navbar -->

<!-- additional subnav -->
<?php echo $this->element('ucampus_subnav');?>
<!-- /additional subnav -->


<div id="page-content">
<!-- page content -->
<div class="container">
    <div class=" well well-white span9 offset1">
        <div class="not-found">
            <ul class="unstyled">
                <li>We're sorry, the webpage you are looking for could not be found.</li>
                <li>Please check the web address and try again. You may also return to our <a href="<?php echo $this->Html->url('/'); ?>">Home Page.</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- /page content -->
</div>

<!-- global components -->
<?php echo $this->element('login'); echo $this->element('browser');?>
<!-- /global components -->
<footer>
    <div class="container">
        <div class="row">
            <div class="span5">
                <a href="<?php echo($this->Html->url('/pages/about')); ?>">About</a>&nbsp;
                <a href="<?php echo($this->Html->url('/pages/help')); ?>">Help</a>&nbsp;
                <a href="<?php echo($this->Html->url('/pages/terms')); ?>">Terms</a>&nbsp;
                <!--<a href="<?php echo($this->Html->url('/pages/advertise')); ?>">Advertise</a>-->
            </div>
            <div class="social span7">
                Find Us On:
                <a href="http://www.facebook.com/ulinkinc">
                    <i class="ulink-social-icon-fb"></i>
                </a>
                <a href="http://www.twitter.com/ulinkinc">
                    <i class="ulink-social-icon-twitter"></i>
                </a>
                <span class="pull-right">
                    &copy 2012 uLink, Inc. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer> <!-- /footer -->

<!-- Placed at the end of the document so the pages load faster -->

<?php echo $this->Html->script(array('ulink.js','var.js','validate.js','form-submit.js','ajax.js', 'jquery-ui.js'));?>

<!-- facebook scripts
<script type="text/javascript"
        src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">
    FB.init("<?php echo FACEBOOK_APP_ID; ?>", "<?php echo FACEBOOK_APP_URL; ?>");
</script>   -->

</body>
</html>
