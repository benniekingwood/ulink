	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				req = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
		
	
	function check_file() {	//alert("Stop");
	    var pat_fileurl =document.ReviewWritereviewForm.file.value;
		//alert(pat_fileurl); 
		var strURL=hostname+"/app/webroot/chkfile.php?sub_file="+pat_fileurl;
	   // alert(strURL); 
		var req = getXMLHTTP();
		
        var req1=1
		if(pat_fileurl==""){
		var req1=10
		}
		
		if (req,req1) {
		//alert(req1);	
			req.onreadystatechange = function() {
				if (req.readyState == 4) { 

 //alert(req.status); 
 					if (req.status == 200) { 
				 					
					
					//alert(req.responseText);	
																
						if(req.responseText==0) { 
							
					           if(req1==10){
									document.getElementById('searchResult_file').innerHTML="Please Choose a file to upload.";
									document.getElementById('h1').value="0";
									} 
 							//alert("Email ID Already registered.");
				            else {
						document.getElementById('searchResult_file').innerHTML="<font color='red'>File Type is In-Valid. Please Choose a vaid file The file size must be less than 1GB and can be ony extentions of .mov, .mpg, .flv, .3gp ,.avi formats </font>";
						document.getElementById('h1').value="0";	    
								}
							//document.frm1.username.value="";
							
						} else if (req.responseText==1){ 
			
						//alert("Email ID Available.");
						         if(req1==10){
									document.getElementById('searchResult_file').innerHTML="Please Choose a file to upload.";
									document.getElementById('h1').value="0";
									} 
						         else{
						          document.getElementById('searchResult_file').innerHTML="<font color='green'>File Type is Valid.</font>";
							      document.getElementById('h1').value="1";
								 }
							
						}else{
						
						//alert("dfdff");
						
						}
						
												
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}

		
		
		
		