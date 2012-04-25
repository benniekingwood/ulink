<style>
#nameInfo{ float:left;}
#suggestionForm label{display: block;	color: #797979;	font-weight: 700;	line-height: 1.4em; }
#suggestionForm input{	width: 220px;	padding: 6px;	color: #949494;	font-family: Arial,  Verdana, Helvetica, sans-serif;font-size: 11px;	border: 1px solid #cecece;}
#suggestionForm input.formButton{	width: 90px;	padding:6px;	color: #ffffff;font-weight:bold;	font-family: Arial,  Verdana, Helvetica, sans-serif;font-size: 12px;	border: 1px solid #cecece; background:url(app/webroot/img/green-color.jpg) repeat-x; height:28px;}
#suggestionForm input.formButton1{	width: 90px;	padding:6px;	color: #ffffff;	font-weight:bold; font-family: Arial,  Verdana, Helvetica, sans-serif;font-size: 12px;	border: 1px solid #cecece; background:url(app/webroot/img/orange-color.jpg) repeat-x; height:28px;}

#suggestionForm input.error{	background: #f8dbdb;	border-color: #e77776;}
#suggestionForm textarea{	width: 220px;	height: 80px;	padding: 6px;	color: #adaeae;	font-family: Arial,  Verdana, Helvetica, sans-serif;	font-style: italic;	font-size: 12px;	border: 1px solid #cecece;
}
#suggestionForm textarea.error{	background: #f8dbdb;	border-color: #e77776;}
#suggestionForm div{	margin-bottom: 15px;}
#suggestionForm div span{ color: #b1b1b1;	font-size: 11px;	font-style: italic;}
#suggestionForm div span.error{	color: #e46c6e;}
#error{	margin-bottom: 20px;	border: 1px solid #efefef;}
#error ul{	list-style: square;	padding: 5px;	font-size: 11px;}
#error ul li{	list-style-position: inside;	line-height: 1.6em;}
#error ul li strong{	color: #e46c6d;}
#error.valid ul li strong{	color: #93d72e;}
</style>
<script type="text/javascript">
 $('.loginBoxPopup').click(function(){
 		tb_show("Login to ulink",'<?php e($html->url('/users/login'));?>?mode=1&height=250&width=800');
 });
</script>

<script type="text/javascript">
// add school opo up script
   $('a.poplight[href^=#]').click(function() {
	var popID = $(this).attr('rel'); //Get Popup Name
	var popURL = $(this).attr('href'); //Get Popup href to define size

	//Pull Query & Variables from href URL
	var query= popURL.split('?');
	var dim= query[1].split('&');
	var popWidth = dim[0].split('=')[1]; //Gets the first query string value
	
	$('#name').val('');	
	$('#name').removeClass("error");
	$('#nameInfo').text("");
	//Fade in the Popup and add close button
	$('#' + popID).fadeIn().css({'width': Number( popWidth)}).prepend('<a href="#" class="close"><?php echo $html->image('close_pop.png',array('class'=>'btn_close','alt'=>'close'));?></a>');

	//Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
	var popMargTop = ($('#' + popID).height() + 80) / 2;
	var popMargLeft = ($('#' + popID).width() + 80) / 2;

	//Apply Margin to Popup
	$('#' + popID).css({
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft
	});

	//Fade in Background
	$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 
	return false;
});
//Close Popups and Fade Layer
$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
	$('#fade , .popup_block').fadeOut(function() {
		$('#fade, a.close').remove();  //fade them both out
	});
	return false;
});
</script>
<!--  add school pop up -->
<div id="popup_name" class="popup_block">
   <div id="mainContainer" style="">
	<fieldset>
  	<form action="/school/suggest" method="post" name="myForm" id="suggestionForm">
		<div id="formResponse">
		<div id="formResponseWait"></div>
		<table>
			<tr>
				<td><label for="firstname">Name:</label></td>
				<td id="_name"></td>
				<td><input type="text" class="textInput" name="name" id="name" value=""><span id="nameInfo"></span></td>
			</tr>
		   <tr>
			<td colspan="2">
			</td>
			<td style="padding-top:4px;">
				<input type="button" id="mySubmit" class="formButton" value="Suggest">
				<input type="reset" class="formButton1" value="Reset">
			</td>
	  	  </tr>
		</table>
	</div>		
	</form>
	</fieldset>
</div>
<script type="text/javascript">
var formObj = new DHTMLSuite.form({formRef:'myForm',action:hostname+'/schools/suggestion',responseEl:'formResponse'});
</script>
</div>