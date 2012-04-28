<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" >

<head>
    <?php echo $html->charset(); ?>
    <title>
        <?php __('uLink | '); ?>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
        // print meta tags
        echo $html->meta('icon');
        echo $html->meta('viewport','width=device-width, initial-scale=1.0');
        echo $html->meta('description','uLink, Inc.');
        echo $html->meta('author','');

        // print styles
        echo $html->css(array('bootstrap.css', 'ulink.css','bootstrap-responsive.css'));
    ?>

    <!--  HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- facebook scripts -->
    <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
    <script type="text/javascript">
        FB.init( "<?php echo FACEBOOK_APP_ID; ?>","<?php echo FACEBOOK_APP_URL; ?>");
    </script>

    <!--  favicon and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php e($html->url('/')); ?>">
                <?php echo $html->image('logouLink_7539.png', array('alt' => 'ulinklogo')); ?>
            </a>
            <div class="nav-collapse">
                <ul class="nav span3">
                    <li id="ucampus-module"><a class="module" href="./ucampus_home.html"><i class="ulink-icon-ucampus"></i>uCampus</a></li>
                </ul>

                <div class="span2">&nbsp;
                </div><!-- /nav middle spacer -->
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user icon-white"></i>
                            <span id="profile-mgmt-username">deanVT</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu profile-mgmt">
                            <li>
                                <div class="span3">
                                    <?php echo $html->image('jack.png', array('alt' => 'myprofilepicture')); ?>
                                    <span id="profile-mgmt-name">Jack Dean</span>
                                </div>
                                <a href="#">Manage my profile</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#">Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div> <!-- /navbar -->

<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>

<footer>
    <div class="container">
        <div class="row">
            <div class="span5">
                <a href="<?php e($html->url('/pages/about')); ?>">About</a>&nbsp;
                <a href="<?php e($html->url('/pages/help')); ?>">Help</a>&nbsp;
                <a href="<?php e($html->url('/pages/terms')); ?>">Terms</a>&nbsp;
                <a href="<?php e($html->url('/pages/advertise')); ?>">Advertise</a>
            </div>
            <div class="social span7">
                Find Us On:
                <a href="#">
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
<?php echo $javascript->link(array('jquery.min.js', 'ulink.js','var.js','validate.js','form-submit.js', 'ajax.js','jquery.form.js')); ?>
</body>
</html>
