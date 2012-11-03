/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 5/15/12
 * Description: This js file handles global ulink functions
 ********************************************************************************/
$(document).ready(function(){
    // first check the browser type
    switch(BrowserDetect.browser) {
        case 'Explorer': {
            if (BrowserDetect.version < 9) {
                // hide page content container and show the browser version div
                $('#ulink-nav').hide();
                $('#ucampus-subnav').hide();
                $('#page-content').hide();
                $('#browser-container').show();
            }
        }
        break;
    }

    $("#ucampus-module").hover(
     function () {
        // show subnav
        $('#ucampus-subnav ul').addClass("active", 200);
        var val = $("#ucampus-module").attr("class");
        if(val != 'active') {
            $("#ucampus-module > a > i").toggleClass("ulink-icon-ucampus-white");
        }
      }
    );

    $('#page-content').on("mouseover", function() {
        if($('#ucampus-subnav ul').hasClass("active")) {
         $('#ucampus-subnav ul').removeClass("active", 200);
        }
    });

    // This adds 'placeholder' to the items listed in the jQuery .support object.
    jQuery(function() {
       jQuery.support.placeholder = false;
       test = document.createElement('input');
       if('placeholder' in test) jQuery.support.placeholder = true;
    });
    // This adds placeholder support to browsers that wouldn't otherwise support it.
    $(function() {
       if(!$.support.placeholder) {
          var active = document.activeElement;
          $(':text').focus(function () {
             if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                $(this).val('').removeClass('hasPlaceholder');
             }
          }).blur(function () {
             if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
             }
          });
          $(':text').blur();
          $(active).focus();
          $('form:eq(0)').submit(function () {
             $(':text.hasPlaceholder').val('');
          });
       }
    });

    // activates tooltips
    $("[rel=tooltip]").tooltip({placement : 'right'});
});
