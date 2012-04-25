$(document).click(function (event) {                    
    $('#suggestions:visible').hide();
});

function lookup(inputString) {
	 	if(inputString.length == 0) {
			// Hide the suggestion box.
		//$('#inputString').val('Quick search');
		//$(this).val('Quick Search');
			$('#suggestions').hide();
		} else {
		var url = hostname + "schools/autocomplete";
		// var url = 'http://localhost/ulinknew/schools/autocomplete';

		if(inputString.length >=3 ) {
			
			   $.post(url, {queryString: ""+inputString+""}, function(data){
						if(data.length >3 ) {
							$('#suggestionstext').show();
							$('#suggestionstext').html(data);
						}
				});
			}
		}
	} // lookup

	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
	

function showOptionDefault() 
{
	
	
	$('#suggestions').show();
var value=	$('#droptext').val();
	if(value=="Profiles")
	{
	
	$('#autoSuggestionsList').html('<div><ul id="opList" style="list-style:none outside none"><li id="optionmaps" class="" onclick=\'hideOption("maps")\'>Map</li><li id="optionusers" onclick=\'hideOption("users");\' class="activeOption">Profiles</li><li class="no-border" id="optionreviews"  onclick=\'hideOption("reviews")\'>Reviews</li></ul></div>');
}	
else if(value=="Reviews")
{
	$('#autoSuggestionsList').html('<div><ul id="opList" style="list-style:none outside none"><li id="optionmaps" class="" onclick=\'hideOption("maps")\'>Map</li><li id="optionusers" onclick=\'hideOption("users");\' >Profiles</li><li class=" activeOption no-border" id="optionreviews"  onclick=\'hideOption("reviews")\' >Reviews</li></ul></div>');
}
else
{
	$('#autoSuggestionsList').html('<div><ul id="opList" style="list-style:none outside none"><li id="optionmaps" class="activeOption" onclick=\'hideOption("maps")\'>Map</li><li id="optionusers" onclick=\'hideOption("users");\'>Profiles</li><li class="no-border" id="optionreviews"  onclick=\'hideOption("reviews")\'>Reviews</li></ul></div>');
}
	
} // lookup

function showOptionUsers() {
	
	          
	 	 			$('#suggestions').show();
					$('#autoSuggestionsList').html('<div><ul id="opList" style="list-style:none"><li id="optionmaps"  onclick=hideOption("maps")>Map</li><li class="activeOption" id="optionusers" onclick=hideOption("users");>Profiles</li><li class="no-border" id="optionreviews"  onclick=hideOption("reviews")>Reviews</li></ul></div>');
					
	} // lookup

function showOptionReviews() {
	
	
	          
	 	 			$('#suggestions').show();
					$('#autoSuggestionsList').html('<div><ul id="opList" style="list-style:none"><li id="optionmaps" onclick=hideOption("maps")>Map</li><li id="optionusers" onclick=hideOption("users");>Profiles</li><li class="no-border" id="optionreviews" class="activeOption"   onclick=hideOption("reviews")>Reviews</li></ul></div>');
					
	} // lookup



function hideOption(option,controllerName) {
						
					//$('#suggestions').hide();
					ajaxhangeAction(option);

} // lookup	
function hideViewOption() {
		$('#suggestions').hide();
 } // lookup		

function ajaxhangeAction(changeAction)
{
	$.ajax({
		
		
	//	url:hostname+'/'+changeAction+'/searchform',
	//	url:'http://localhost/ulinknew' +'/'+changeAction+'/searchform',
	
		beforeSend:  function() { 
			
				if(changeAction == 'users')
				{
				
					$('#droptext').val('Profiles');
					$('#optionusers').addClass('activeOption');
					$('#optionreviews').removeClass('activeOption');
					$('#optionmaps').removeClass('activeOption');
				
					$('#MapMapIndexForm').attr('action', hostname +'users/searchresults');
				
			}
				else if(changeAction == 'reviews')
				{	
					$('#droptext').val('Reviews');
					$('#optionusers').removeClass('activeOption');
					$('#optionreviews').addClass('activeOption');
					$('#optionmaps').removeClass('activeOption');
					$('#MapMapIndexForm').attr('action',hostname+'reviews/searchresults');
			
			}else 
				{	
					$('#droptext').val('Map');
					$('#optionusers').removeClass('activeOption');
					$('#optionreviews').removeClass('activeOption');
					$('#optionmaps').addClass('activeOption');
					$('#MapMapIndexForm').attr('action',hostname+'/maps/map_index');
			
			}
			//	$('#tobeSearch').html('<form action="javascript:void(0);"><input type="text" value=""/><input type="Submit" value="Search" class="btn"/></form>');
		},
		success: function(data) {
		/*  		I do not why form data is refreshed here using this code , so I commented the following line as url that is called is not just fetching form again*/
		//		$('#tobeSearch').html(data);
		
		}
	});
	
	//document.getElementById('inputString').focus();
} 	
