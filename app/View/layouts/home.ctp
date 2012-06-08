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
        $controllerName = $this->params['controller'];
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('style.css', 'jquery_006.css', 'pop_thickbox.css', 'thickbox.css', 'autofill.css'));
        echo $this->Html->script(array('var.js', 'jquery.js', 'easySlider.packed.js', 'jquery_004.js', 'thickbox.js', 'jquery_013.js', 'global_fn.js', 'form-submit.js', 'ajax.js', 'autofill.js', 'validate.js', 'jquery.form.js','tiny_mce/tiny_mce.js'));
        echo $this->Html->script(array( 'check_user_script.js', 'autofill.js', 'tiny_mce/tiny_mce.js', 'jquery.tools.min.js'));

        echo $scripts_for_layout;
        ?>
        <style type="text/css">
            /*to slider in home page */
            #slider{ width:100% !important; }
            #slider ul{ width:100% !important; list-style:none; line-height:18px; }
            #slider, #slider li{ width:100%; height:350px; overflow:hidden; text-align:justify; }
            .sliderContent{ float:left; width:100%; padding-bottom:10px;}
            .sliderContent a{text-decoration:none; color:#000;}
            .sliderContent a:hover{color:#1269B6; text-decoration:underline;}
            /* ends hereto slider in home page */

            span#prevBtn, span#prevBtn a{background:url("/img/up-arrow_n.png") no-repeat scroll 0 0 transparent}
            span#nextBtn, span#nextBtn a{background:url("/img/down-arrow_n.png") no-repeat scroll 0 0 transparent}

        </style>
        <script type="text/javascript" language="javascript">
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

            function hidesuggestionstext()
            {
	
                $("#suggestionstext").hidecho(); 
            }

            function ajaxDo(contrl,action) {
                $.ajax({
                    url:hostname+contrl+'/'+action,
                    beforeSend:  function() { 
                        $('#switchContent').html('<div class=\'imageLoagGif\'><center><?php echo $this->Html->image(('ajax-loader.gif', array('alt' => 'Loading...')); ?></center></div>');
                    },
                    success: function(data) {
                        $('#switchContent').html(data);
                    }
                });
            } 

            $(document).ready(function() {

                $("#slider").easySlider({
                    prevText:'UP',
                    nextText:'DOWN',
                    vertical:'true'
                });
	
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
	

                $('#recentR').click(function(){
                    $('#topR').removeClass("selected");
                    $('#newlyA').removeClass("selected");
                    $('#suggestS').removeClass("selected");
                    $(this).addClass("selected");
                    //$('#switchContent').fadeOut('slow');
                    ajaxDo('reviews','recentreviews');
                    $( 'title' ).html ( '<?php echo RECENT_REVIEWS_TITLE; ?>' ); 
                });
                
                $('#newlyA').click(function(){
                    $('#topR').removeClass("selected");
                    $('#recentR').removeClass("selected");
                    $('#suggestS').removeClass("selected");
                    $(this).addClass("selected");
                    //$('#switchContent').fadeOut('slow');
                    ajaxDo('schools','recentaddedschools');
                    $( 'title' ).html ( '<?php echo NEWLY_ADDED_SCHOOL; ?>'); 
				   
                });
	 
                $('#topR').click(function(){
                    $('#newlyA').removeClass("selected");
                    $('#recentR').removeClass("selected");
                    $('#suggestS').removeClass("selected");
                    $(this).addClass("selected");
                    //$('#switchContent').fadeOut('slow');
                    ajaxDo('schools','topratedschools');
                    $( 'title' ).html ( '<?php echo TOP_RATED_SCHOOLS; ?>' ); 
				   
                });
     
     
                $('#suggestS').click(function(){
	
                    $('#newlyA').removeClass("selected");
                    $('#topR').removeClass("selected");
                    $('#recentR').removeClass("selected");
                    $('#suggestS').addClass("selected");
                    tb_show('Suggest a School','#TB_inline?height=150&width=450&inlineId=popup_name', null);
                    $( 'title' ).html ( '<?php echo SUGGEST_A_SCHOOL; ?>' ); 

                });

                $('#writeAreview').click(function(){

                    if (tinyMCE.getInstanceById('textarea2'))
                    {
                        tinyMCE.execCommand('mceFocus', false, 'textarea2');
                        tinyMCE.execCommand('mceRemoveControl', false, 'textarea2');
                    }


                    var schoolName= '<?php echo $Shoolreview[0]['School']['name'] ?>';

                    tb_show(schoolName,'#TB_inline?height=530&width=500&inlineId=writeReview', null);
                    if (tinyMCE.getInstanceById('textarea2'))
                    {


                        tinyMCE.execCommand('mceFocus', false, 'textarea2');
                        tinyMCE.execCommand('mceRemoveControl', false, 'textarea2');
                    }else
                    {

                        tinyMCE.settings = configArray[0];
                        tinyMCE.execCommand('mceAddControl', true, "textarea2");
                    }


                    //createEditor();
                });





                $('#writeAreviewNew').click(function(){
                    if (tinyMCE.getInstanceById('textarea2'))
                    {



                        tinyMCE.execCommand('mceFocus', false, 'textarea2');
                        tinyMCE.execCommand('mceRemoveControl', false, 'textarea2');
                    }


                    var schoolName= '<?php echo $Shoolreview[0]['School']['name'] ?>';

                    tb_show(schoolName,'#TB_inline?height=530&width=500&inlineId=writeReview', null);
                    if (tinyMCE.getInstanceById('textarea2'))
                    {
                        tinyMCE.execCommand('mceFocus', false, 'textarea2');
                        tinyMCE.execCommand('mceRemoveControl', false, 'textarea2');
                    }else
                    {

                        tinyMCE.settings = configArray[0];
                        tinyMCE.execCommand('mceAddControl', true, "textarea2");
                    }


                    //createEditor();
                });

                /* <![CDATA[ */
                var numSlides = $('#features').find('li').not('li ul li').length;
	
                $('#features').jcarousel({
                    scroll: 1,
                    auto: 8,
                    easing: 'easeOutCirc',
                    //animation: 'fast',
                    //indicator_label: 'Features',
                    skin: '.jcarousel-skin-widefeature',
                    //size: numSlides,
                    visible: 1,
                    wrap: 'both',
                    //initCallback: jcarousel_initCallback,
                    itemFirstInCallback: jcarousel_itemFirstInCallback
                    /*itemVisibleInCallback: {onBeforeAnimation: jcarousel_itemVisibleInCallback},
                                itemVisibleOutCallback: {onAfterAnimation: jcarousel_itemVisibleOutCallback}*/
                });
                //searchbox init
	

                /* ]]> */



                function blank(a) {

                    hideViewOption();
                }
                function blankDefault() {  var myTextField = document.getElementById('inputString');
                    hideViewOption();
                    if(myTextField.value=="Quick search"){document.getElementById('inputString').value="";}
                }

            });
        </script>


        <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
        <script type="text/javascript">
            //FB_RequireFeatures(["XFBML"], function(){
			
            FB.init( "<?php echo FACEBOOK_APP_ID; ?>" ,"<?php echo FACEBOOK_APP_URL; ?>");
        </script>

    </head>


    <body>


        <?php echo $this->Form->input('abc', array('type' => 'hidden', 'value' => $usertextreview[0]['Review']['description'])); ?>

        <div id="mainContainer">
            <div class="main_inner_container">
                <div id="header">
                    <div class="left">
                        <?php echo $this->Html->link($this->Html->image(("logouLinkv2.png"), array('controller' => 'pages', 'action' => 'home'), array('escape' => false)); ?>
                    </div>

                    <?php echo $this->element('login_tab'); ?>
                    <?php echo $this->element('add_school'); ?>

                    <div class="searchPanel">
                        <div class="left">
                            <a href="<?php echo($this->Html->url('/')); ?>">
                                <?php echo $this->Html->image(('home-icon.gif', array('alt' => 'home', 'title' => 'uLink home')); ?>
                            </a>

                            <a href="<?php echo($this->Html->url('/maps/map_index')); ?>">
                                <?php echo $this->Html->image(('map-icon.gif', array('alt' => 'map of schools', 'title' => 'map of schools')); ?>
                            </a>

                        </div>
                        <div class="right">
                            <?php echo $this->Html->image(('search-bar-right.gif', array('alt' => '')); ?>
                        </div>

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
                            }


                            echo $this->Form->text('search', array('type' => 'text', 'id' => 'inputString', 'value' => $searchValueUser, 'title' => 'Search', 'placeHolder' => 'Search',
                                'class' => 'search_text',
                                'autocomplete' => 'off',
                                'onKeyUp' => 'lookup(this.value)'
                            ));
                            ?>

                            <div id="suggestionstext" class="suggestionshelp" value="Map" style="margin:0 20" onmouseout="hidesuggestionstext();"  >
                            </div>



                            <?php
                            if (isset($type)) {

                                $searchType = $type;
                            } else {

                                $searchType = "Map";
                            }
                            ?>
                            <input class="drop_help" type="text" id="droptext" value="<?php echo $searchType; ?>" onmouseover="showOptionDefault();"/>

                            <?php echo $this->Form->button('Search', array('type' => 'Submit', 'class' => 'btn', 'onmouseover' => 'blankDefault()')); ?>

                            <div id="suggestions" class="suggestionsBox" value="Map" style="display:none;">
                                <div id="autoSuggestionsList" class="suggestionList">
                                    <div>
                                        <ul style="list-style: none outside none;" id="opList">
                                            <li onclick="hideOption('maps')"   class="activeOption" id="optionmaps">Map</li>
                                            <li onclick="hideOption('users,<?php echo $controllerName ?>');" id="optionusers">Profile</li>
                                            <li class="no-border" onclick="hideOption('reviews')" id="optionreviews">Review</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?php echo $this->Form->end(); ?>
                        </div>



                        <div class="clear"></div>
                    </div>



                </div>
                <div id="sliderHome">
                    <div class="jcarousel-skin-widefeature">
                        <div class="jcarousel-clip jcarousel-clip-horizontal">
                            <ul id="features" class="jcarousel-list jcarousel-list-horizontal">
                                <li jcarouselindex="1" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">
                                    <?php echo $this->Html->image(('slider.jpg', array('alt' => '')); ?>
                                </li>
                                <li jcarouselindex="1" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">
                                    <a href="#"><?php echo $this->Html->image(('slider.jpg', array('alt' => '')); ?></a>
                                </li>
                                <li jcarouselindex="1" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">
                                    <?php echo $this->Html->image(('slider.jpg', array('alt' => '')); ?>
                                </li>
                                <li jcarouselindex="1" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">
                                    <?php echo $this->Html->image(('slider.jpg', array('alt' => '')); ?>
                                </li>
                                <li jcarouselindex="1" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">
                                    <?php echo $this->Html->image(('slider.jpg', array('alt' => '')); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="whiteContentBox" class="clear">
                    <div class="top">
                        <span class="left">
                            <?php echo $this->Html->image(('white-box-top-left.gif', array('alt' => '')); ?>
                        </span>
                        <span class="right">
                            <?php echo $this->Html->image(('white-box-top-right.gif', array('alt' => '')); ?>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="content">
                        <div id="blueBox">
                            <div class="top">
                                <span class="left">
                                    <?php echo $this->Html->image(('blue-border-box-top-left.gif', array('alt' => '')); ?>
                                </span>
                                <span class="right">
                                    <?php echo $this->Html->image(('blue-border-box-top-right.gif', array('alt' => '')); ?>
                                </span>
                                <div class="clear"></div>
                            </div>



                            <div class="content">
                                <div class="leftPanel">
                                    <a href="javascript:void(0);" id="recentR" class="recentReviews selected"></a>
                                    <a href="javascript:void(0);" id="newlyA" class="newlyAdded"></a>
                                    <a href="javascript:void(0);" id="topR" class="topRated"></a>
                                    <a href="javascript:void(0);" id="suggestS" class="poplight suggestSchool"></a>
                                </div>
                                <div class="homeContent">
                                    <div class="homeContentHolder">


                                        <div id="switchContent" class="homeContentLeft">

                                            <div id="slider">
                                                <ul>
                                                    <?php
                                                    $i = 0;
                                                    $start = 0;
                                                    $li = "";

                                                    $e = count($Review) - 1;
                                                    foreach ($Review as $review) {
                                                        if ($i == 0) {
                                                            echo "<li>";
                                                            $fli = "0";
                                                        }
                                                        if (($i % 4 == 0 && $i != 1 && $fli == "1") || ($li == "0")) {
                                                            echo "<li>";
                                                            $li = "1";
                                                            $start = 0;
                                                        }
                                                        $start++;
                                                        if ($review['School']['image_url'] == "" ||
                                                                !file_exists(WWW_ROOT . '/img/files/schools/' . $review['School']['image_url'])) {
                                                            $review['School']['image_url'] = "noImage.jpg";
                                                        }
                                                        ?>
                                                        <div class="sliderContent">
                                                            <span class="sliderImage">
                                                                <a href="schools/detail/<?php echo $review['School']['id']; ?>">
                                                                    <img alt="" border="0" src="<?php echo($this->Html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/schools/<?php echo $review['School']['image_url']; ?>&w=50&h=50" />
                                                                </a>				
                                                            </span>
                                                            <span>
                                                                <a class="margin_right" href="reviews/<?php echo $review['Review']['type']; ?>review/<?php echo $review['Review']['id']; ?>">
                                                                    <strong><?php echo substr($review['Review']['title'], 0, 40); ?></strong>
                                                                </a>
                                                                <?php echo $this->Html->image(('star-' . $review['School']['rating'] . '.gif', array('title' => $review['School']['rating'] . ' star')); ?>	
                                                                <span class="reviewDate">Posted on <?php echo datecho("d M, Y ", strtotimecho($review['Review']['created'])); ?> by <?php echo ucwords($review['User']['firstname']); ?></span>
                                                            </span>
                                                            <span class="reviewDescription">
                                                                <?php
                                                                echo strip_tags(substr($review['Review']['description'], 0, 75));
                                                                if (strlen($review['Review']['description']) > 75) {
                                                                    echo "...";
                                                                }
                                                                ?>
                                                                <span style="float:right"><a href="reviews/<?php echo $review['Review']['type']; ?>review/<?php echo $review['Review']['id']; ?>" class="home_read"><div class="read_more">Read More</div></a></span>
                                                            </span>
                                                        </div>
                                                        <?php
                                                        if (($li == "1" && $start == "4") or ($i == 3) or ($i == $e)) {
                                                            echo "</li>";
                                                            $li = "0";
                                                            $fli = "1";
                                                        }
                                                        $i++;
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="homeContentRight news">
                                            <h2>uLink News</h2>


                                            <?php
                                            $i = 0;
                                            foreach ($News as $news) {
                                                //echo "<pre>"; 
                                                //print_r($news);	
                                                //print_r($news['News']['title']);
                                                //print_r($news['News']['modified']);

                                                if ($i == 4) {

                                                    $class = "listing no-border";
                                                } else {

                                                    $class = "listing";
                                                }
                                                ?>

                                                <div class="<?php echo $class; ?>">
                                                    <div class="date"><?php
                                            echo datecho("M", strtotimecho($news['Article']['modified']));
                                                ?><span><?php
                                                    echo datecho("d", strtotimecho($news['Article']['modified']));
                                                ?></span></div>
                                                    <div class="newsContent"><?php echo $news['Article']['title']; ?> <a href="<?php echo $this->Html->url('/articles/index/' . $news['Article']['id']) ?>"><div class="read_more">Read More</div></a></div>
                                                    <div class="clear"></div>
                                                </div>

                                                <?php
                                                if ($i == 4)
                                                    break;
                                                $i++;
                                            }
                                            ?>

                                            <!-- <a href="blog/" class="viewAll">View All</a> -->
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="bottom">
                                <span class="left">
                                    <?php echo $this->Html->image(('blue-border-box-bottom-left.gif', array('alt' => '')); ?>
                                </span>
                                <span class="right">
                                    <?php echo $this->Html->image(('blue-border-box-bottom-right.gif', array('alt' => '')); ?>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="bottom">
                        <span class="left">
                            <?php echo $this->Html->image(('white-box-bottom-left.gif', array('alt' => '')); ?>
                        </span>
                        <span class="right">
                            <?php echo $this->Html->image(('white-box-bottom-right.gif', array('alt' => '')); ?>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
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

 <?php echo $this->element('writereview'); ?>
    </body>
</html>