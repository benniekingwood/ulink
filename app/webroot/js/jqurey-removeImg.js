$(document).ready(function(){
// class exists
if($('.confirm_delete').length) {
	
        // add click handler
	$('.confirm_delete').click(function(){
		
		var hostname="http://dev.zapbuild.com/ulink/";
		// ask for confirmation
		var result = confirm('Are you sure you want to remove the image?');
		// show loading image
		$('.ajax_loader').show();
		$('#flashMessage').fadeOut();
		
		// get parent row
		var row ="imageshow";
		
		
		//alert('#'+row);
		// do ajax request
	
		
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
					//alert(response);
			
					// show respsonse message
					if(response == 'true' ) {
					
						
						$('#checkImage').html("<img height='225' width='225' border='0' src='"+hostname+"app/webroot/img/files/users/noImage.jpg' />");
					} else {
						$('#ajax_msg_image_response').html( '<div class="showMsg">Sorry!! Try again.<div>' ).show();
					}
					
				}
			});
		}
	return false;
	});
}
});
