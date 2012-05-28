<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
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
        echo $this->Html->css(array('style_admin.css', 'pop_thickbox.css'));
        echo $javascript->link(array('var.js', 'jquery.js', 'citystates.js', 'thickbox.js', 'ajax.js', 'check_user_script.js', 'multiple-image-upload.js', 'jquery-common', 'validate.js'));
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <?php echo $javascript->link(array('wz_tooltip')); ?>
        <div id="mainContainer">
            <div id="header">
                <div class="left"><?php echo $this->Html->image(('logouLinkv2.png', array('alt' => 'uLink Logo')); ?></div>

                <?php echo $this->element('admin_login_tab'); ?>

                <div class="searchPanel">
                    <div class="left">
                        <a href="<?php echo($this->Html->url('/admin')); ?>">
                            <?php echo $this->Html->image(('home-icon.gif', array('alt' => '')); ?>
                        </a>

                    </div>
                    <div class="right">
                        <?php echo $this->Html->image(('search-bar-right.gif', array('alt' => '')); ?>
                    </div>
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
                            <div class="z">	
                                <?php if (isset($_SESSION['admin_id'])) { ?>						
                                    <?php echo $this->element('admin_left_panel'); ?>
                                <?php } ?>
                            </div>
                            <div class="homeContentn">
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
            <!--<div class="share">
			<div class="left"><?php echo $this->Html->image(('find-us.gif', array('alt' => 'Find us on')); ?></div>
			<a href="javascript:void(0)" class="facebook"></a>
			<a href="javascript:void(0)" class="twitter"></a>
			<a href="javascript:void(0)" class="stumble"></a>
			<a href="javascript:void(0)" class="delicious"></a>
			<a href="javascript:void(0)" class="yahoo"></a>
			<div class="clear"></div>
		</div>-->
            <div id="footer">
                <div class="left">&nbsp;</div>
                <div class="right">&copy;2011-2012 uLink, Inc. All rights reserved.</div>
                <div class="clear"></div>
            </div>
        </div>
    </body>
</html>