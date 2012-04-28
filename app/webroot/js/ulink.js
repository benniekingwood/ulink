$("#ucampus-module").hover(
 function () {
 	var val = $("#ucampus-module").attr("class");
 	if(val != 'active') {
    	$("#ucampus-module > a > i").toggleClass("ulink-icon-ucampus-white");
    }
  }
);

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
$("[rel=tooltip]").tooltip({placement : 'bottom'});

$(function(){
	$('#eventtime').timePicker({
	  startTime: "24:00",  
	  endTime: new Date(0, 0, 0, 23, 45, 0), 
	  show24Hours: false,
	  separator:':',
	  step: 15});
});

// submit event component
function showEventTimeOn() {
	$('#eventtime').toggle();
	$('.event-time').hide();
	$('.event-time-on').show();
}
function showEventTimeOff() {
	$('#eventtime').val(''); 
	$('#eventtime').toggle();
	$('.event-time').show();
	$('.event-time-on').hide();
}
function showEventLocOn() {
	$('#eventloc').toggle();
	$('.event-location').hide();
	$('.event-location-on').show();
}
function showEventLocOff() {
	$('#eventloc').val(''); 
	$('#eventloc').toggle();
	$('.event-location').show();
	$('.event-location-on').hide();
}
