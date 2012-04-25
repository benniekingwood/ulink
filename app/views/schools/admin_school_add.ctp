<?php echo $javascript->link(array('jqurey-removeImg.js', 'ckeditor/ckeditor', 'ckfinder/ckfinder')); ?>
<style type="text/css">

    /* to tackle the multiple upload */
    #upload{
        margin:30px 200px; padding:15px;
        font-weight:bold; font-size:1.3em;
        font-family:Arial, Helvetica, sans-serif;
        text-align:center;
        background:#f2f2f2;
        color:#3366cc;
        border:1px solid #ccc;
        width:150px;
        cursor:pointer !important;
        -moz-border-radius:5px; -webkit-border-radius:5px;
    }
    .darkbg{
        background:#ddd !important;
    }
    #status{
        font-family:Arial; padding:5px;
    }
    ul#files{ list-style:none; padding:0; margin:0; }
    ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
    ul#files li img{ max-width:180px; max-height:150px; }
    .success{ background:#99f099; border:1px solid #339933; }
    .error{ border:0px solid #cc6622; }

    /* ends here the multiple upload */

    span.error{
        color: #e46c6e;
    }

    .schoolName{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .schoolNameError{
        background: #f8dbdb;
        border-color: #e77776;
    }


    .schoolShortDescription{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .schoolShortDescriptionError{
        background: #f8dbdb;
        border-color: #e77776;
    }
    .domainName{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .domainNameError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolAddress{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .addressError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolAttendence{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .schoolYearSel{
        width:200px;	
    }

    .schoolYearError{
        background: #f8dbdb;
        width:200px;
        border-color: #e77776;
    }

    .attendenceError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolLatitude{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .latitudeError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolLongitude{
        width: 220px;
        padding: 6px;
        color: #949494;
        font-family: Arial,  Verdana, Helvetica, sans-serif;
        font-size: 11px;
        border: 1px solid #cecece;
    }

    .longitudeError{
        background: #f8dbdb;
        border-color: #e77776;
    }



    .schoolYearSel{
        width:200px;	
    }

    .schoolYearError{
        background: #f8dbdb;
        width:200px;
        border-color: #e77776;
    }

    .zipcode{
        width:200px;	
    }

    .zipcodeError{
        background: #f8dbdb;
        width:200px;
        border-color: #e77776;
    }
</style>
<script type="text/javascript">
    function getState(countryId) {	
        if(countryId == 223){	
            document.getElementById('statedivother').style.display = 'none';
            document.getElementById('statediv').style.display = 'block';
            document.getElementById('citydivother').style.display = 'none';
            document.getElementById('citydiv').style.display = 'block';
            getCity();
            var strURL=hostname+"/admin/schools/school_state/"+countryId;
            var req = getXMLHTTP();
            if (req) {
                req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                        // only if "OK"
                        if (req.status == 200) {						
                            document.getElementById('statediv').innerHTML=req.responseText;						
                        } else {
                            //alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                        }
                    }				
                }			
                req.open("GET", strURL, true);
                req.send(null);
            }
        } else {
            document.getElementById('statedivother').style.display = 'block';
            document.getElementById('statediv').style.display = 'none';
            document.getElementById('citydivother').style.display = 'block';
            document.getElementById('citydiv').style.display = 'none';
		
        }		
    }
    function getCity(stateId) {		
        var strURL=hostname+"/admin/schools/school_city/"+stateId;
        var req = getXMLHTTP();
        if (req) {
			
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {						
                        document.getElementById('citydiv').innerHTML=req.responseText;						
                    } else {
                        //alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }				
            }			
            req.open("GET", strURL, true);
            req.send(null);
        }
				
    }
</script>
<script type="text/javascript" >
    $(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
        new AjaxUpload(btnUpload, {
            action: hostname+'admin/schools/school_extimage',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
				
                //On completion clear the status
                status.text('');
                //Add uploaded file to list
				
                var msg=response.split("/");
                if(msg[0]==="success"){
                    $('<li></li>').appendTo('#files').html('<img src="../../../img/files/test/'+msg[1]+file+'" alt="" /><br />'+msg[1]+file).addClass('success');
                } else{
                    $('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
		
    });
</script>

<script type="text/javascript">
    jQuery.validator.addMethod("noSpecialChars", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_\s]+$/i.test(value);
    });

		

    $(document).ready(function(){
	

	
        $("#SchoolSchoolAddForm").validate({
            errorPlacement: function(error, element) {
                element.after(error);
               
            },
            invalidHandler: function () {
                if ($(this).prev().hasClass('error')) $(this).prev().remove();
            },
		

            rules: {
                'data[School][name]'			:	{required:true,
                    noSpecialChars:true
                },
                'data[School][short_description]'			:	"required",
					
                'data[School][description]'			:	"required",
                'data[School][attendence]'				: {
                    digits: true
															
                },
                'data[School][zipcode]'				: {
                    digits: true,
                    required: true
															
                },
													  
                'data[School][longitude]'				: {
															
                    required: true
														
															
                },
                'data[School][latitude]'				: {
                    required: true                },
				
                'data[School][domain]'			:	{
                    required: true
															
                },
				
                'data[School][address]'				:{
                    required:true,
                    noSpecialChars:true
                },
                'data[School][hometown]'			:	{ 
                    required:true
															
                },
                'data[School][year]'		:	 {
                    required:true,
                    digits: true
															
                }
            },
            messages: {
					
                'data[School][name]'			:	{ 
                    required: "Please enter name"	,
                    noSpecialChars:"Please enter valid data"
                },
                'data[School][short_description]'			:	{ 
                    required: "Please enter short description"	
                },
												
                'data[School][domain]'			:	{ 
                    required: "Please enter school-email domain"
													
                },
                'data[School][zipcode]'				:	{ 
                    required: "Please enter a zip code",
                    digits: "Please enter digits only  "		
                },		
					
                'data[School][year]'				:	{ 
                    required: "Please enter foundation year",
                    digits: "Please enter digits only  "		
                },	
                'data[School][description]'				:	{ 
                    required: "Please enter description"	
                },				
                'data[School][address]'			:	{ 
                    required: "Please enter address"	,
                    noSpecialChars:"Please enter valid data"
                },
                'data[School][attendence]'		:	{ 
                    digits: "Please enter digits"	
                },									
                'data[School][longitude]'			:	{ 
                    required: "Please enter longitude",
                    digits: "Please enter digits only "																	
                },	
                'data[School][latitude]'			:	{ 
                    required: "Please enter latitude",
                    digits: "Please enter digits only "																	
                }	
										
            }	
        });

	
	
    });


</script>
<?php
unset($_SESSION['ct']);
unset($_SESSION['extra_image']);

echo $form->create('School', array('action' => 'school_add', 'type' => 'file'));
?>
<?php echo $form->input('name', array('class' => 'schoolName', 'label' => 'School Name*')); ?> 
<br/>

<div class="editor_title">

    <?php echo $form->input('School.short_description', array('class' => 'schoolShortDescription', 'type' => 'textarea', 'label' => 'School Short Description*')); ?> 

</div>

<?php echo $form->input('School.description', array('id' => 'editor1', 'label' => 'Description*', 'type' => 'textarea')); ?>
<?php echo $form->input('attendence', array('label' => 'School Attendence*')); ?>
<?php echo $form->input('address', array('label' => 'Address*')); ?> 
<?php echo $form->input('School.zipcode', array('label' => 'Zip Code*', 'class' => 'zipcode')); ?>

<?php echo $form->input('School.year', array('type' => 'text', 'class' => 'schoolYearSel', 'label' => 'Foundation Year*')); ?> <span id="SchoolYearInfo" name ="SchoolYearInfo"></span><br/>

	School Type<?php echo $form->input('type', array('type' => 'radio', 'options' => array('private' => 'private', 'public' => 'public'), 'default' => 'public', 'legend' => false)); ?>

<?php echo $form->input('School.domain', array('class' => 'domainName', 'label' => 'School-email domain*')); ?> 

<?php echo $form->input('country_id', array('onchange' => 'getState(this.value)', 'type' => 'select', 'empty' => 'Please Select', 'options' => $countries)); ?><br/>
<?php echo $form->error('School.country_id'); ?>
<div id="statediv">
    <?php echo $form->input('state', array('type' => false, 'empty' => 'Select Country First', 'type' => 'select')) ?>
</div>

<div id="statedivother" style="display:none;">
    <?php echo $form->input('School.stateother', array('type' => 'text', 'id' => 'stateother', 'label' => 'State')); ?>

</div>

<br/>

<div id="citydiv">
    <?php echo $form->input('city', array('empty' => 'Select State First', 'type' => 'select')) ?>
</div>
<br/>
<div id="citydivother" style="display:none;">
    <?php echo $form->input('School.cityother', array('type' => 'text', 'id' => 'cityother', 'label' => 'City')); ?>
</div>
<br/>
<?php echo $form->input('School.longitude', array('label' => 'Longitude*')); ?>

<?php echo $form->input('School.latitude', array('label' => 'Latitude*')); ?>


<?php echo $form->input('file', array('type' => 'file', 'label' => 'Main Image')); ?>


<table><tr><td><div id="upload" ><span>Upload Images for Gallery<span></div><span id="status" ></span>
                        <ul id="files" ></ul>
                        </td></tr></table>

                        <?php echo $form->end('Submit'); ?></div>


                        <div align="left"> <div><a href="<?php e($html->url('/admin/schools/index')); ?>"><b>Cancel</b></a></div></div>

                        <script type="text/javascript">				
                            var editor = CKEDITOR.replace( 'editor1' );
                            CKFinder.setupCKEditor( editor, '<?php echo $html->url('/js/ckfinder/'); ?>' ) ;
                        </script>
