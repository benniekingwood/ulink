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
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" >

    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php __('uLink | '); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $html->meta('icon');

        echo $html->css(array('style.css', 'pop_thickbox.css', 'thickbox.css', 'autofill.css', 'bootstrap.css'));

        echo $javascript->link(array('var.js', 'jquery.js', 'citystates.js', 'thickbox.js', 'form-submit.js', 'ajax.js', 'check_user_script.js', 'autofill.js', 'easySlider.packed.js', 'multiple-image-upload.js', 'validate.js', 'jquery.form.js', 'tiny_mce/tiny_mce.js', 'jquery.tools.min.js', 'bootstrap-tab.js'));

        echo $scripts_for_layout;
        ?>



        <script type="text/javascript">



            function hidesuggestionstext()
            {
	
                $("#suggestionstext").hide();
            }


            function blank(a) {

		 
                hideViewOption();
            }

            function blankDefault() {
                var myTextField = document.getElementById('inputString');
                hideViewOption();

            }

	
        </script>


        <script>

            var configArray = [{
                    theme : "advanced",
                    mode : "textareas",
                    language : "en",
                    height:"200",
                    width:"450",

                    theme_advanced_layout_manager : "SimpleLayout",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
                    theme_advanced_buttons2 : "",
                    theme_advanced_buttons3 : ""
                },{
                    theme : "advanced",
                    mode : "none",
                    language : "en",
                    width:"100px",
                    theme_advanced_layout_manager : "SimpleLayout",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left"
                }]
            tinyMCE.settings = configArray[0];
            tinyMCE.execCommand('mceAddControl', true, "textarea1");

 



        </script>
        <script type="text/javascript">
            $(document).ready(function() {
		
              /*  $('.search_text').focus(function(){
                    var entredtext = $(this).val();
                    var defaultText = $(this).attr('title');
                    if( entredtext == defaultText){
                        $(this).val('');
                    }
                });

                $('.search_text').blur(function(){
                    var defaultText = $(this).attr('title');
                    var entredtext = $(this).val();

                    if( entredtext == ''){
                        $(this).val(defaultText);
                    }

                }); */

		
		
                $(".topMenuAction").click( function() {
                    if ($("#openCloseIdentifier").is(":hidden")) {
                        $("#sliderLeft").animate({ 
                            marginLeft: "-76px"
                        }, 500 );
                        $("#topMenuImage").html('<?php echo $html->image('openLeftPanel.png', array('alt' => '')); ?>');
                        $("#openCloseIdentifier").show();
                    } else {
                        $("#sliderLeft").animate({ 
                            marginLeft: "0px"
                        }, 500 );
                        $("#topMenuImage").html('<?php echo $html->image('closeLeftPanel.png', array('alt' => '')); ?>');
                        $("#openCloseIdentifier").hide();
                    }
                });  
		
                $('#suggestS').click(function(){
                    tb_show('Suggest a School','#TB_inline?height=150&width=450&inlineId=popup_name', null);
		

                });

                $('#writeAreview').click(function(){ 
                   
	
                    var schoolName= '<?php echo $Shoolreview[0]['School']['name'] ?>';
	
                    tb_show(schoolName,'#TB_inline?height=530&width=500&inlineId=writeReview', null);
		
	
                    tinyMCE.settings = configArray[0];
                    tinyMCE.execCommand('mceAddControl', true, "textarea2");

	
		
                    //createEditor();
                });





                $('#writeAreviewNew').click(function(){  
	
                    var schoolName= '<?php echo $Shoolreview[0]['School']['name'] ?>';
	
                    tb_show(schoolName,'#TB_inline?height=530&width=500&inlineId=writeReview', null);

	
                    tinyMCE.settings = configArray[0];
                    tinyMCE.execCommand('mceAddControl', true, "textarea2");

	
		
                    //createEditor();
                });
            });
        </script>	

        <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
        <script type="text/javascript">
            //FB_RequireFeatures(["XFBML"], function(){
			
            FB.init( "<?php echo FACEBOOK_APP_ID; ?>","<?php echo FACEBOOK_APP_URL; ?>");
	
        </script>	
    </head>
    <body>


        <?php
        if ($usertextreview) {
            echo $form->input('abc', array('type' => 'hidden', 'value' => $usertextreview[0]['Review']['description']));
        }
        echo $javascript->link(array('wz_tooltip'));
        ?>
        <div id="leftSliderWrap">
            <div style="display: block;" id="openCloseIdentifier"></div>
            <div style="margin-left:-76px;" id="sliderLeft">
                <div id="sliderContent">
                        <!--<a href="<?php e($html->url('/maps/map_index')); ?>"><?php echo $html->image('reviews-icon.gif', array('alt' => '')); ?></a>-->

                    <?php if ($loggedInId) { ?>
                        <a href="javascript:void(0);" id="writeAreview" class="poplight suggestSchool">

                            <?php echo $html->image('submit_review_icon.gif', array('alt' => 'submit a review', 'title' => 'submit a review')); ?></a>

                    <?php } else { ?>

                        <a href="javascript:void(0);" class="login loginBoxPopup"><?php echo $html->image('submit_review_icon.gif', array('alt' => 'submit a review', 'title' => 'submit a review')); ?></a>
                    <?php } ?>

                    <a href="javascript:void(0);" id="suggestS" class="poplight suggestSchool"><?php echo $html->image('suggest-icon.gif', array('alt' => 'suggest a school', 'class' => 'no-border', 'title' => 'suggest a school')); ?></a>
                    <a href="javascript:void(0);"><?php echo $html->image('left-panel-bottom.png', array('alt' => '', 'class' => 'no-border')); ?></a>
                    <div class="clear"></div>
                </div>

            </div>
            <div id="openCloseWrap"><a href="javascript:void(0);" class="topMenuAction" id="topMenuImage"><?php echo $html->image('openLeftPanel.png', array('alt' => '')); ?></a></div>		
        </div>

        <div id="mainContainer">
            <div class="main_inner_container">
                <div id="header">
                    <?php echo $html->link($html->image("logouLinkv2.png"), array('controller' => 'pages', 'action' => 'home'), array('escape' => false)); ?>

                    <?php echo $this->element('login_tab'); ?>

                    <div class="searchPanel">
                        <div class="left">
                            <a href="<?php e($html->url('/')); ?>"><?php echo $html->image('home-icon.gif', array('alt' => '')); ?></a>
                            <a href="<?php e($html->url('/maps/map_index')); ?>"><?php echo $html->image('map-icon.gif', array('alt' => '')); ?></a>
                        </div>
                        <div class="right"><?php echo $html->image('search-bar-right.gif', array('alt' => '')); ?></div>

                        <div class="new_search">
                            <!-- <div class="search" id="tobeSearch">- -->
                            <?php
                            if (isset($actionType)) {

                                $action = $actionType;
                                $createType = $createTypeForm;
                            } else {

                                $action = "map_index";
                                $createType = "Map";
                            }
                            ?> 

                            <?php echo $form->create($createType, array('action' => $action, 'id' => 'MapMapIndexForm')); ?>

                            <span class="left"><?php echo $html->image('left_search_icon.png', array('alt' => '')); ?></span>
                            <?php
                            if (isset($search_srting)) {

                                $searchValueUser = $search_srting;
                            }

                            //else {$searchValueUser = "Quick search";}


                            echo $form->text('search', array('type' => 'text', 'id' => 'inputString', 'value' => $searchValueUser, 'title' => 'Search', 'placeHolder' => 'Search',
                                'class' => 'search_text',
                                'autocomplete' => 'off',
                                'onKeyUp' => 'lookup(this.value)'
                            ));
                            ?>

                            <div id="suggestionstext" class="suggestionshelp" value="Map" style="margin:0 20" onmouseout="hidesuggestionstext();" >
                            </div>


                            <?php
                            if (isset($type)) {

                                $searchType = $type;
                            } else {

                                $searchType = "Map";
                            }
                            ?>
                            <input class="drop_help" type="text" id="droptext" value="<?php echo $searchType; ?>" onmouseover="showOptionDefault();"/>

                            <?php echo $form->button('Search', array('type' => 'Submit', 'class' => 'btn', 'onmouseover' => 'blankDefault()')); ?>

                            <div id="suggestions" class="suggestionsBox" value="Map" style="display:none;">
                                <div id="autoSuggestionsList" class="suggestionList" >
                                    <div>
                                        <ul style="list-style: none outside none;" id="opList" >
                                            <li onclick="hideOption('maps')"   class="activeOption" id="optionmaps">Map</li>
                                            <li onclick="hideOption('users');" id="optionusers">Profile</li>
                                            <li class="no-border" onclick="hideOption('reviews')" id="optionreviews">Review</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?php echo $form->end(); ?>
                        </div>



                        <div class="clear"></div>
                    </div>



                </div>
                <div class="pageHeading"><?php if (isset($School['School']['name']))
                                echo $School['School']['name']; ?>
                    <?php if (isset($Review['School']['name']))
                        echo $Review['School']['name']; ?>
                    <?php if (!isset($currentPageHeading_last))
                        $currentPageHeading_last = ''; ?>
                    <?php if (isset($currentPageHeading))
                        echo $currentPageHeading . ' ' . $currentPageHeading_last; ?>
                </div>
                <div id="whiteContentBox" class="clear">
                    <div class="top">
                        <span class="left"><?php echo $html->image('white-box-top-left-inner.gif', array('alt' => '')); ?></span>
                        <span class="right"><?php echo $html->image('white-box-top-right-inner.gif', array('alt' => '')); ?></span>
                        <div class="clear"></div>
                    </div>
                    <?php $session->flash(); ?>
                    <?php echo $content_for_layout; ?>


                    <div class="bottom">
                        <span class="left"><?php echo $html->image('white-box-bottom-left-inner.gif', array('alt' => '')); ?></span>
                        <span class="right"><?php echo $html->image('white-box-bottom-right-inner.gif', array('alt' => '')); ?></span>


                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div><!-- main contaner ends here -->
        <div class="footer_bottom">
            <div class="share">
                <div class="left"><?php echo $html->image('find-us.gif', array('alt' => '')); ?></div>
                <a href="javascript:void(0)" class="facebook"></a>
                <a href="http://www.twitter.com/ulinkinc" class="twitter"></a>
                <a href="javascript:void(0)" class="stumble"></a>
                <a href="javascript:void(0)" class="delicious"></a>
                <a href="javascript:void(0)" class="yahoo"></a>
                <div class="clear"></div>
            </div>

            <div id="footer">
                <div class="left"><a href="<?php e($html->url('/')); ?>">Home</a> | 

                    <?php if (!isset($loggedInId)) { ?>
                        <a href="<?php e($html->url('/users/register')); ?>">Join uLink</a> |
                        <?php
                    } else {
                        if ($loggedInFacebookId > 0) {
                            echo $html->link('Log Out |', '#', array('class' => 'login', 'onclick' => 'FB.Connect.logout(function() { document.location = "' . $html->url('/users/logout/') . '"; }); return false;'));
                        } else {
                            ?>
                            <a href="<?php echo $html->url('/users/logout'); ?>" class="login">Log Out</a> |
                            <?php
                        }
                    }
                    ?> 

                    <a href="<?php e($html->url('/pages/faq')); ?>">FAQ</a> | <a href="<?php e($html->url('/pages/legal')); ?>">Legal</a> | <a href="<?php e($html->url('/pages/advertise')); ?>">Advertise</a></div>
                <div class="right">&copy; 2012 uLink, Inc. All rights reserved.</div>
                <div class="clear"></div>
            </div>
        </div>
        <?php echo $this->element('add_school'); ?>
        <?php echo $this->element('writereview'); ?>
    </body>
</html>
