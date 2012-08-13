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
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('uLink | '); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array('style.css', 'pop_thickbox.css', 'thickbox.css', 'autofill.css'));

        echo $this->Html->script(array('var.js', 'jquery-1.4.2.min.js', 'citystates.js', 'thickbox.js', 'form-submit.js', 'ajax.js', 'check_user_script.js', 'autofill.js', 'easySlider.packed.js', 'multiple-image-upload.js', 'validate.js', 'jquery.form.js'));

        echo $scripts_for_layout;
        ?>



        <script type="text/javascript">
            function hidesuggestionstext()
            {
	
                $("#suggestionstext").hidecho();
            }


            function blank(a) { 
	
                if(a.value == a.defaultValue) a.value = ""; 
                hideViewOption();
            }
            function unblank(a) { if(a.value == "") a.value = a.defaultValue; }
            function blankDefault() {  var myTextField = document.getElementById('inputString');
                hideViewOption();
                if(myTextField.value=="Quick search"){document.getElementById('inputString').value="";}
            }
            function fillDefault() {  
                var myTextField = document.getElementById('inputString');
                if(myTextField.value=="")
                {
                    document.getElementById('inputString').value="Quick search";
                }elseif( myTextField.value != "Quick search")
                {
			
                    document.getElementById('inputString').value;
                }
	   
            }
	
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
		
		
                $(".topMenuAction").click( function() {
                    if ($("#openCloseIdentifier").is(":hidden")) {
                        $("#sliderLeft").animatecho({ 
                            marginLeft: "-76px"
                        }, 500 );
                        $("#topMenuImage").html('<?php echo $this->Html->image(('openLeftPanel.png', array('alt' => '')); ?>');
                        $("#openCloseIdentifier").show();
                    } else {
                        $("#sliderLeft").animatecho({ 
                            marginLeft: "0px"
                        }, 500 );
                        $("#topMenuImage").html('<?php echo $this->Html->image(('closeLeftPanel.png', array('alt' => '')); ?>');
                        $("#openCloseIdentifier").hidecho();
                    }
                });  
		
                $('#suggestS').click(function(){
                    tb_show('Suggest a School','#TB_inline?height=130&width=400&inlineId=popup_name', null);
		

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


        <?php //echo $userSchoolId;  ?>
        <?php echo $this->Html->script(array('wz_tooltip')); ?>
        <div id="leftSliderWrap">
            <div style="display: block;" id="openCloseIdentifier"></div>
            <div style="margin-left:-76px;" id="sliderLeft">
                <div id="sliderContent">
                        <!--<a href="<?php echo($this->Html->url('/maps/map_index')); ?>"><?php echo $this->Html->image(('reviews-icon.gif', array('alt' => '')); ?></a>-->

                    <?php if ($loggedInId) { ?>
                        <a class="thickbox" href="<?php echo($this->Html->url('/reviews/writereview?height=530&width=500&itemId=' . $userSchoolId)); ?>">
                            <?php echo $this->Html->image(('submit_review_icon.gif', array('alt' => 'submit a review', 'title' => 'submit a review')); ?></a>

                    <?php } else { ?>

                        <a href="javascript:void(0);" class="login loginBoxPopup"><?php echo $this->Html->image(('submit_review_icon.gif', array('alt' => 'submit a review', 'title' => 'submit a review')); ?></a>
                    <?php } ?>
               <!--<a href="<?php echo($this->Html->url('/')); ?>"><?php echo $this->Html->image(('rated-icon.gif', array('alt' => '')); ?></a>-->

                    <a href="javascript:void(0);" id="suggestS" class="poplight suggestSchool"><?php echo $this->Html->image(('suggest-icon.gif', array('alt' => 'suggest a school', 'title' => 'suggest a school')); ?></a>

                    <a href="javascript:void(0);"><?php echo $this->Html->image(('left-panel-bottom.png', array('alt' => '')); ?></a>
                    <div class="clear"></div>
                </div>

            </div>
            <div id="openCloseWrap"><a href="javascript:void(0);" class="topMenuAction" id="topMenuImage"><?php echo $this->Html->image(('openLeftPanel.png', array('alt' => '')); ?></a></div>		
        </div>

        <div id="mainContainer">
            <div class="main_inner_container">
                <div id="header">
                    <?php echo $this->Html->link($this->Html->image(("logouLinkv2.png"), array('controller' => 'pages', 'action' => 'home'), array('escape' => false)); ?>

                    <?php echo $this->element('login_tab'); ?>

                    <div class="searchPanel">
                        <div class="left">
                            <a href="<?php echo($this->Html->url('/')); ?>"><?php echo $this->Html->image(('home-icon.gif', array('alt' => '')); ?></a>
                            <a href="<?php echo($this->Html->url('/maps/map_index')); ?>"><?php echo $this->Html->image(('map-icon.gif', array('alt' => '')); ?></a>
                        </div>
                        <div class="right"><?php echo $this->Html->image(('search-bar-right.gif', array('alt' => '')); ?></div>

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

                            <?php echo $this->Form->create(($createType, array('action' => $action, 'id' => 'MapMapIndexForm')); ?>

                            <span class="left"><?php echo $this->Html->image(('left_search_icon.png', array('alt' => '')); ?></span>
                            <?php
                            if (isset($search_srting)) {

                                $searchValueUser = $search_srting;
                            } else {

                                $searchValueUser = "Quick search";
                            }
                            echo $this->Form->text('search', array('type' => 'text', 'id' => 'inputString', 'value' => $searchValueUser,
                                'class' => 'search_text',
                                'autocomplete' => 'off',
                                'onfocus' => 'blank(this)',
                                'onKeyUp' => 'lookup(this.value)',
                                'onblur' => 'unblank(this)',
                                'onClick' => 'hideViewOption()'
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

                            <?php echo $this->Form->button('Search', array('type' => 'Submit', 'class' => 'btn', 'onmouseover' => 'blankDefault()', 'onmouseout' => 'fillDefault()')); ?>

                            <div id="suggestions" class="suggestionsBox" value="Map" style="display:none;">
                                <div id="autoSuggestionsList" class="suggestionList" >
                                    <div>
                                        <ul style="list-style: none outside none;" id="opList" >
                                            <li onclick="hideOption('maps')"   class="activeOption" id="optionmaps">Map</li>
                                            <li onclick="hideOption('users');" id="optionusers">Profile</li>
                                            <li onclick="hideOption('reviews')" id="optionreviews">Review</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?php echo $this->Form->end(); ?>
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
                        <span class="left"><?php echo $this->Html->image(('white-box-top-left-inner.gif', array('alt' => '')); ?></span>
                        <span class="right"><?php echo $this->Html->image(('white-box-top-right-inner.gif', array('alt' => '')); ?></span>
                        <div class="clear"></div>
                    </div>

                    <div class="not_found"> 


                        <label>We're sorry, the webpage you are looking for could not be found.
                            <br/>
	Please check the address and try again.You may also search our site, explore our schools, or return to our <a href="<?php echo $this->Html->url('/'); ?>">Home Page.</a>
                        </label>
                    </div>


                    <div class="bottom">
                        <span class="left"><?php echo $this->Html->image(('white-box-bottom-left-inner.gif', array('alt' => '')); ?></span>
                        <span class="right"><?php echo $this->Html->image(('white-box-bottom-right-inner.gif', array('alt' => '')); ?></span>


                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div><!-- main contaner ends here -->
        <div class="footer_bottom">
            <div class="share">
                <div class="left"><?php echo $this->Html->image(('find-us.gif', array('alt' => '')); ?></div>
                <a href="javascript:void(0)" class="facebook"></a>
                <a href="http://www.twitter.com/ulinkinc" class="twitter"></a>
                <a href="javascript:void(0)" class="stumble"></a>
                <a href="javascript:void(0)" class="delicious"></a>
                <a href="javascript:void(0)" class="yahoo"></a>
                <div class="clear"></div>
            </div>

            <div id="footer">
                <div class="left"><a href="<?php echo($this->Html->url('/')); ?>">Home</a> | 

                    <?php if (!isset($loggedInId)) { ?>
                        <a href="<?php echo($this->Html->url('/users/register')); ?>">Join uLink</a> |
                        <?php
                    } else {
                        if ($loggedInFacebookId > 0) {
                            echo $this->Html->link('Log Out |', '#', array('class' => 'login', 'onclick' => 'FB.Connect.logout(function() { document.location = "' . $this->Html->url('/users/logout/') . '"; }); return false;'));
                        } else {
                            ?>
                            <a href="<?php echo $this->Html->url('/users/logout'); ?>" class="login">Log Out</a> |
                            <?php
                        }
                    }
                    ?> 
                    <a href="<?php echo($this->Html->url('/pages/faq')); ?>">FAQ</a> | <a href="<?php echo($this->Html->url('/pages/legal')); ?>">Legal</a> | <a href="<?php echo($this->Html->url('/pages/advertise')); ?>">Advertise</a></div>
                <div class="right">&copy; 2012 uLink, Inc. All rights reserved.</div>
                <div class="clear"></div>
            </div>
        </div>
        <?php echo $this->element('add_school'); ?>
    </body>
</html>