$(document).ready(function(){
// class exists
if($('.confirm_delete_extra').length) {
	
	
        // add click handler
	$('.confirm_delete_extra').click(function(){
		// ask for confirmation
		var result = confirm('Are you sure you want to remove the selected image?');
		// show loading image
		$('.ajax_loader').show();
		$('#flashMessageExtra').fadeOut();
		
		// get parent row
		//var row ="imageshow";
		
		
		var row =this.id;
		// do ajax request
	
		
		//alert(row);
		//alert($(this).attr('href'));
		
		//return false;
		if(result) {
		     
		    $.ajax({
				type:"POST",
				url:$(this).attr('href'),
				data:"ajax=1",
				success:function(response){
					//alert(url);
					// hide loading image
					// hide table row on success
					//alert(response);
					if(response == 'true') {
					
						$("#"+row).fadeOut('slow');
					}
					
					// show respsonse message
					if(response == 'true' ) {
						$('#ajax_msg').html('<div class="showMsg">The image has been removed successfully<div>').show();
					} else {
						$('#ajax_msg').html( '<div class="showMsg">Sorry!! Try again.<div>' ).show();
					}
					
				}
			});
		}
	return false;
	});
}
});
