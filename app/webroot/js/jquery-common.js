$(document).ready(function(){
// class exists
if($('.confirm_delete').length) {
        // add click handler
	$('.confirm_delete').click(function(){
		
	  	var row =this.id;
		
		$('#'+this.id).addClass('selectToDelete');
		// ask for confirmation
		var result = confirm('Are you sure you want to delete this?');
		
		// show loading image
		$('.ajax_loader').show();
		$('#flashMessage').fadeOut();
		
		//return false;
		//alert($(this).attr('href'));
		
		//return false;
		if(result) {
		    
		    $.ajax({
				type:"POST",
				url:$(this).attr('href'),
				data:"ajax=1",
				success:function(response){
					
					// hide loading image
					// hide table row on success
					if(response == 'true') {
						
						$("#"+row).fadeOut('slow');
					}
					
					// show respsonse message
					if(response == 'true' ) {
						$('#ajax_msg').html('<div class="showStatusMsg">The Selected record is successfully removed  <a class="MgsClose" href="javascript:void(0);">Hide X</a></div>' ).show();
					} else {
						$('#ajax_msg').html( '<div class="showStatusMsg_error">Unable to delte. Please try again <a class="MgsClose" href="javascript:void(0);">Hide X</a><div>' ).show();
					}
					
					$('.MgsClose').click(function(){
						  $('#ajax_msg').html('');						  
  	   				  	});
					
				}
			});
			
		}
	else{ 
		$('#'+this.id).removeClass('selectToDelete');
	}
	return false;
	});
}


	// to change the status and show response 
	
	$('.changeStatus').click(function(){
		var aId		=	this.id
	
		$.ajax({
				type:"POST",
				url:$(this).attr('path'),
				data:"ajax=1",
				success:function(response){
					//alert(response);
					if(response == '0') {
						$("#"+aId).find(".changeStatus").find('img').attr('src',hostname+'/app/webroot/img/unpublish.png');
					}
					else if(response == '1') {
						$("#"+aId).find(".changeStatus").find('img').attr('src',hostname+'/app/webroot/img/publish.png');
					}
					
					// show respsonse message
					if(response == '1' || response == '0' ) {
						$('#ajax_msg').html('<div class="showStatusMsg">The status has been changed <a class="MgsClose" href="javascript:void(0);">Hide X</a></div>' ).show();
						
						
					} else {
						$('#ajax_msg').html( '<div class="showStatusMsg_error">Unable to change status. Please try again <a class="MgsClose" href="javascript:void(0);">Hide X</a><div>' ).show();
					}
				
					$('.MgsClose').click(function(){
						  $('#ajax_msg').html('');						  
  	   				  	});
				
				}
			});
		
	  });


});