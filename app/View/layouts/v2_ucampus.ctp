<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo 'uLink | '.$title_for_layout; ?>
    </title>
    <?php
       // print meta tags
        echo $this->Html->meta('icon');
        echo $this->Html->meta('viewport','width=device-width, initial-scale=1.0');
        echo $this->Html->meta('description','Handle your everyday college activities with uLink.');
        echo $this->Html->meta('author','uLink, Inc.');

        // print styles
        echo $this->Html->css(array('bootstrap.css', 'ulink.css','bootstrap-responsive.css'));
        echo $this->Html->script(array('jquery.min.js','validate.js', 'var.js', 'ulink-browser-check.js'));
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
            <a class="brand" href="<?php echo($this->Html->url('/')); ?>">
                <?php echo $this->Html->image('logouLink_7539.png', array('alt' => 'ulinklogo')); ?>
            </a>
            <div class="nav-collapse">
                <ul class="nav span3">
                    <li id="ucampus-module" class="active">
                        <a class="module" href="<?php echo($this->Html->url('/ucampus')); ?>">
                            <i class="ulink-icon-ucampus-active"></i>uCampus
                        </a>
                    </li>
                </ul>
                <div class="span2">&nbsp;</div><!-- /nav middle spacer -->
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>

                    <?php if (!isset($loggedInId)) { ?>
                    <li>
                        <a href="<?php echo($this->Html->url('/users/register'));?>">Join</a>
                    </li>
                    <li>
                        <a data-toggle="modal" href="#loginComponent">Log In</a>
                    </li>
                    <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user icon-white"></i>
                            <span id="profile-mgmt-username"><?php echo $loggedInUserName ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu profile-mgmt">
                            <li>
                                <div class="span3">
                                    <?php
                                            if ($profileImgURL != '' && getimagesize(URL_USER_IMAGE_MEDIUM . $profileImgURL)) { ?>
                                            <img alt="profile image" src="<?php echo URL_USER_IMAGE_MEDIUM . $profileImgURL ?>"/>
                                           <?php } else { ?>
                                                <img alt="profile image" src="<?php echo URL_DEFAULT_USER_IMAGE ?>"/>
                                            <?php }
                                        ?>
                                    <span id="profile-mgmt-name"><?php echo $loggedInName?></span>
                                </div>
                                <a href="<?php echo($this->Html->url('/users/'));?>">Manage my profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <?php
                                    if ($loggedInFacebookId > 0):
                                echo $this->Html->link('Sign Out', '#', array('class' => 'login', 'onclick' =>
                                'FB.Connect.logout(function() { document.location = "' . $this->Html->url('/users/logout/') .
                                '"; });return false;'));
                                else:
                                ?>
                                <a href="<?php echo $this->Html->url('/users/logout');?>">Sign Out</a>
                                <?php endif; }?>
                            </li>
                        </ul>
                    </li> <!-- /dropdown -->
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
<?php echo $content_for_layout; ?>
<!-- /page content -->
</div>
<!-- global components -->
<?php echo $this->element('login'); echo $this->element('view_profile'); echo $this->element('browser');?>
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
                    &copy 2013 uLink, Inc. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer> <!-- /footer -->

<!-- Placed at the end of the document so the pages load faster -->
<?php echo $this->Html->script(array('bootstrap.min.js','jquery.form.js','ulink.js','form-submit.js','ajax.js', 'jquery-ui.js'));?>

<!-- facebook scripts
<script type="text/javascript"
        src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">
    FB.init("<?php echo FACEBOOK_APP_ID; ?>", "<?php echo FACEBOOK_APP_URL; ?>");
</script>    -->
<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-8Kz1_e3f51S6g"
});
</script>

<noscript>
<div style="display:none;">
<img src="//pixel.quantserve.com/pixel/p-8Kz1_e3f51S6g.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->
</body>
</html>
