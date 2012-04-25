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
		
	
	function chkemail() {	
	    
		var username =document.UserRegisterForm.UserUsername.value;
		var strURL=hostname+"/users/checkuser/" + username;
	    var req = getXMLHTTP();
		var req1=1
		if(username==""){
		var req1=10
		}
		if (req,req1) {
		//alert(req);	
			req.onreadystatechange = function() {
				if (req.readyState == 4) { 

                     
 					if (req.status == 200) { 
				 					
					
					//alert(req.responseText);	
																
						if(req.responseText==0) { 
							
					           if(req1==10){
									document.getElementById('searchResult_username').innerHTML="<font color='red'>Please Choose a username.</font>";
									} 
 							//alert("Email ID Already registered.");
				            else {
							document.getElementById('searchResult_username').innerHTML="<font color='red'>Username is already taken.</font>";
							document.getElementById('h1').value="0";
							    }
							//document.frm1.username.value="";
							
						} else if (req.responseText==1){ 
			
						//alert("Email ID Available.");
						         if(req1==10){
									document.getElementById('searchResult_username').innerHTML="<font color='red'>Please Choose a username.</font>";
									} 
						         else{
						          document.getElementById('searchResult_username').innerHTML="<font color='green'>Username is Available.</font>";
								  document.getElementById('searchResult_username').innerHTML="<font color='green'>Username is Available.</font>";
							      document.getElementById('h1').value="1";
								}
							
						}else{
						
						//alert("dfdff");
						
						}
						
												
					} else {
						//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}

   function chkemailByAdmin() {	
	   
		var username =document.UserAdminUserAddForm.UserUsername.value;
		var strURL=hostname+"/admin/users/checkuser/" + username;
	    var req = getXMLHTTP();
		var req1=1
		if(username==""){
		var req1=10
		}
		if (req,req1) {
		//alert(req);	
			req.onreadystatechange = function() {
				if (req.readyState == 4) { 

                     
 					if (req.status == 200) { 
				 					
					
					//alert(req.responseText);	
																
						if(req.responseText==0) { 
							
					           if(req1==10){
									document.getElementById('searchResult_username').innerHTML="<font color='red'>Please Choose a username.</font>";
									} 
 							//alert("Email ID Already registered.");
				            else {
							document.getElementById('searchResult_username').innerHTML="<font color='red'>Username is already taken.</font>";
							document.getElementById('h1').value="0";
							    }
							//document.frm1.username.value="";
							
						} else if (req.responseText==1){ 
			
						//alert("Email ID Available.");
						         if(req1==10){
									document.getElementById('searchResult_username').innerHTML="<font color='red'>Please Choose a username.</font>";
									} 
						         else{
						          document.getElementById('searchResult_username').innerHTML="<font color='green'>Username is Available.</font>";
							      document.getElementById('h1').value="1";
								}
							
						}else{
						
						//alert("dfdff");
						
						}
						
												
					} else {
						//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}

    
	
	

   function chkschooldomain() {	
	    
		
		
		
	
		
		 var email = $("#UserEmail").val();
		 var selectedSchool = $("#UserSchoolId").val();
		
		
		alert('mintukiuv'+selectedSchool);
		var strURL=hostname+"/users/checkdomain/" + email+"/"+selectedSchool;
		
	   
		var req = getXMLHTTP(); 
		var req1=1
		
		if(email==""){
		var req1=10
		}
		
		if (req,req1) {
		
			req.onreadystatechange = function() {
				if (req.readyState == 4) { 
     
 					if (req.status == 200) { 
						alert(req.responseText);
				   		//alert(req.responseText);	
						if(req.responseText==0) { 
					           if(req1==10){
									document.getElementById('searchResult_email').innerHTML="<font color='red'>Please Choose a email.</font>";                     
									document.getElementById('schooldomainCheck').value="0";
									} 
 							//alert("Email ID Already registered.");
				            else {
							
							$("#UserEmail").removeClass("error");
							$("#emailInfo").removeClass("error");
							document.getElementById('searchResult_email').innerHTML="<font color='red'>Email is not valid.</font>";
                            document.getElementById('schooldomainCheck').value="0";							 
							 }
							//document.frm1.username.value="";
							
						} else if (req.responseText==2){ 
							      document.getElementById('searchResult_email').innerHTML="<font color='red'>Email is already taken, please choose another.</font>";                        
								  document.getElementById('schooldomainCheck').value="0";
							
						} 
						else if (req.responseText==1){ 
			
							//alert("Email ID Available.");
						         if(req1==10){
									document.getElementById('searchResult_email').innerHTML="<font color='red'>Please Choose a email.</font>";                  
									document.getElementById('schooldomainCheck').value="0"; 
									} 
						         else{
						          document.getElementById('searchResult_email').innerHTML="<font color='green'>Email is Valid.</font>";                        
								  document.getElementById('schooldomainCheck').value="1";
								  
							     
								}
							
						}else{
						
						//alert("dfdff");
						
						}
						
												
					} else {
						//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}


    function chkschooldomainByAdmin() {	
	 
	    
		var email =document.UserAdminUserAddForm.UserEmail.value;
		//alert(email)
		var selectedSchool =document.UserAdminUserAddForm.UserSelectedSchool.value;
		//alert(selectedSchool)
		var strURL=hostname+"/admin/users/checkdomain/" + email+"/"+selectedSchool;
		//alert(strURL);
	    var req = getXMLHTTP(); 
		var req1=1
		
		if(email==""){
		var req1=10
		}
		
		if (req,req1) {
		
			req.onreadystatechange = function() {
				if (req.readyState == 4) { 

                     
 					if (req.status == 200) { 
				 					
					
					//alert(req.responseText);	
																
						if(req.responseText==0) { 
							
					           if(req1==10){
									document.getElementById('searchResult_email').innerHTML="<font color='red'>Please Choose a email.</font>";                     
									document.getElementById('schooldomainCheck').value="0";  
									} 
 							//alert("Email ID Already registered.");
				            else {
							document.getElementById('searchResult_email').innerHTML="<font color='red'>Email is not valid.</font>";
							document.getElementById('schooldomainCheck').value="0";     
								}
							//document.frm1.username.value="";
							
						} else if (req.responseText==1){ 
			
						//alert("Email ID Available.");
						         if(req1==10){
									document.getElementById('searchResult_email').innerHTML="<font color='red'>Please Choose a username.</font>";                 
									document.getElementById('schooldomainCheck').value="0"; 
									} 
						         else{
						          document.getElementById('searchResult_email').innerHTML="<font color='green'>Email is Valid.</font>";                        
								  document.getElementById('schooldomainCheck').value="1"; 
							    
								}
							
						}else{
						 //document.getElementById('searchResult_email').innerHTML="<font color='green'>Email is Valid.</font>";                    
						//alert("dfdff");
						
						}
						
												
					} else {
						//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}
