<?php echo ( $javascript->link(array('jquery.form.js')) ); //includes .JS files   ?>
<style>
    #nameInfo{ float:left;}
    #suggestionFormNew label{display: block;	color: #797979;	font-weight: 700;	line-height: 30px; height:30px; width:50px;}
    #suggestionFormNew input.error{ background: #f8dbdb; border-color: #e77776;}
    #suggestionFormNew #name { width: 350px; height: 30px; color: #000; font-family: Arial,  Verdana, Helvetica, sans-serif; font-size: 26px;border: 1px solid #cecece;}
    #suggestionFormNew textarea.error{	background: #f8dbdb;	border-color: #e77776;}
    #suggestionFormNew div{	margin-bottom: 15px;}
    #suggestionFormNew div span{ color: #b1b1b1;	font-size: 11px;	font-style: italic;}
    #suggestionFormNew div span.error{	color: #e46c6e;}
</style>

<script type="text/javascript">

    $(document).ready(function(){
        $("#suggestionFormNew").validate({
            rules: 
                {
                'data[School][name]' :
                    {	
                    required:true
                }		
            },
            messages: 
                {
                'data[School][name]' :
                    { 
                    required: "Please enter a school name."
                }										
            }	
        });
        
        $('#suggestionFormNew').ajaxForm({
            success : function(response) {
								
                if(response == 'true'){
                    $('#formResponse').html('Your request has been submitted.  Please check back with us to see if your school has been added.');
                    setTimeout(function(){ parent.tb_remove() }, 5000);												
                }
                else if(response=="false")
                {
                    $('#formResponse').html('Sorry! your suggestion was not submitted. Please try again later.');
                    setTimeout(function(){ parent.tb_remove() }, 5000);
                }
            }
        });

        // function to show login

    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
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
            $('#' + popID).fadeIn().css({'width': Number( popWidth)}).prepend('<a href="#" class="close"><?php echo $html->image('close_pop.png', array('class' => 'btn_close', 'alt' => 'close')); ?></a>');

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

    });

    $('.loginBoxPopup').click(function(){
        tb_show("Login to ulink",'<?php e($html->url('/users/login')); ?>?mode=1&height=250&width=800');
    });
</script>
<!--  add school pop up -->
<div id="popup_name" class="popup_block">
    <div id="mainContainer" style="">
        <fieldset>
            <?php echo $form->create('School', array('action' => 'suggestion', 'id' => 'suggestionFormNew')); ?>

            <div id="formResponse">
                <div id="formResponseWait"></div>
                <div style="height: 50px">
                    <?php echo $form->input('name', array('id' => 'name', 'value' => '')); ?>
                </div>
                <div class="pop_buttons">
                    <?php echo $form->submit('suggest.gif'); ?>
                    <!--<input type="reset" class="formButton1" value="Reset">!-->
                </div>
            </div>		

            <?php echo $form->end(); ?>
        </fieldset>
    </div>
</div>