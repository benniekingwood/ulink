<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>uLink</title>

        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('style_admin.css'));
        echo $javascript->link(array());
        echo $scripts_for_layout;
        ?>
    </head>
    <body>

        <div id="mainContainer">
            <div id="header">
                <div class="left"><?php echo $this->Html->image(('logouLinkv2.png', array('alt' => '')); ?></div>
                <div class="topLinks">

                </div>
                <div class="clear"></div>
                <div class="searchPanel">
                    <div class="left">
                        <a href="index.html"><?php echo $this->Html->image(('home-icon.gif', array('alt' => '')); ?></a>
                        <a href="map.html"><?php echo $this->Html->image(('map-icon.gif', array('alt' => '')); ?></a>
                    </div>
                    <div class="right"></div>
                    <div class="search">

                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div id="whiteContentBox">
                <div class="top">
                    <span class="left"><?php echo $this->Html->image(('white-box-top-left.gif', array('alt' => '')); ?></span>
                    <span class="right"><?php echo $this->Html->image(('white-box-top-right.gif', array('alt' => '')); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="content">
                    <div id="blueBox">
                        <div class="top">
                            <span class="left"><?php echo $this->Html->image(('blue-border-box-top-left.gif', array('alt' => '')); ?></span>
                            <span class="right"><?php echo $this->Html->image(('blue-border-box-top-right.gif', array('alt' => '')); ?></span>
                            <div class="clear"></div>
                        </div>
                        <div class="content">
                            <div class="leftPanel">							
                            </div>
                            <div class="homeContent">
                                <?php $session->flash(); ?>
                                <?php echo $content_for_layout; ?>

                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="bottom">
                            <span class="left"><?php echo $this->Html->image(('blue-border-box-bottom-left.gif', array('alt' => '')); ?></span>
                            <span class="right"><?php echo $this->Html->image(('blue-border-box-bottom-right.gif', array('alt' => '')); ?></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <span class="left"><?php echo $this->Html->image(('white-box-bottom-left.gif', array('alt' => '')); ?></span>
                    <span class="right"><?php echo $this->Html->image(('white-box-bottom-right.gif', array('alt' => '')); ?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="share">
                <div class="left"><?php echo $this->Html->image(('find-us.gif', array('alt' => 'Find us on')); ?></div>
                <a href="javascript:void(0)" class="facebook"></a>
                <a href="javascript:void(0)" class="twitter"></a>
                <a href="javascript:void(0)" class="stumble"></a>
                <a href="javascript:void(0)" class="delicious"></a>
                <a href="javascript:void(0)" class="yahoo"></a>
                <div class="clear"></div>
            </div>
            <div id="footer">
                <div class="left"><a href="javascript:void(0);">Home</a> | <a href="javascript:void(0);">Join uMap</a> | <a href="javascript:void(0);">FAQs</a> | <a href="javascript:void(0);">Legal</a> | <a href="javascript:void(0);">Advertise</a></div>
                <div class="right">&copy;2011-2012 uLink, Inc. All rights reserved.</div>
                <div class="clear"></div>
            </div>
        </div>
    </body>
</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('uLink Administration | '); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array('admin'));

        echo $javascript->link(array('var.js', 'jquery.js', 'citystates.js', 'thickbox.js', 'ajax.js', 'check_user_script.js', 'multiple-image-upload.js', 'jquery-common'));

        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <?php 
            echo $javascript->link(array('wz_tooltip')); 
            $session->flash(); 
            echo $content_for_layout; 
        ?>
    </body>
</html>