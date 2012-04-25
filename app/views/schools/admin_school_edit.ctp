<?php echo $javascript->link(array('jqurey-removeImg.js', 'jqurey-removeExtraImg.js', 'ckeditor/ckeditor', 'ckfinder/ckfinder')); ?>
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


    span.error{
        color: #e46c6e;
    }

    .schoolName{
        /*width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;*/
    }

    .schoolNameError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .domainName{
        /*width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;*/
    }

    .domainNameError{
        background: #f8dbdb;
        border-color: #e77776;
    }



    .schoolAddress{
        /*
	width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;
	*/
    }

    .addressError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolAttendence{
        /*
	width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;
	*/
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
        /*
	width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;
	*/
    }

    .latitudeError{
        background: #f8dbdb;
        border-color: #e77776;
    }

    .schoolLongitude{
        /*
	width: 220px;
	padding: 6px;
	color: #949494;
	font-family: Arial,  Verdana, Helvetica, sans-serif;
	font-size: 11px;
	border: 1px solid #cecece;
	*/
    }
    .longitudeError{
        background: #f8dbdb;
        border-color: #e77776;
    }



    .year {
        width:200px;	
    }

    .yearError{
        background: #f8dbdb;
        width:200px;
        border-color: #e77776;
    }
    .zipcode {
        width:200px;	
    }

    .zipcodeError{
        background: #f8dbdb;
        width:200px;
        border-color: #e77776;
    }
</style>
<script type="text/javascript" languagej="javascript">
    function getState(countryId) {		
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
                status.text('Uploading Please Wait...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');
                //Add uploaded file to list
				
                var msg=response.split("/");
                if(msg[0]==="success"){
                    $('<li></li>').appendTo('#files').html('<img src="../../../img/files/test/'+msg[1]+file+'" alt="" /><br />'+msg[1]+file).addClass('success');
                } else{
                    alert(response);
                    $('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
		
    });

    $(document).ready(function(){
        //global vars
        var form = $("#SchoolAdminSchoolEditForm");
        var name = $("#SchoolName");
        var nameInfo=$("#nameInfo");
        var short_description = $("#SchoolShortDescription");
        var short_descriptionInfo=$("#short_descriptionInfo");
        var attendence = $("#SchoolAttendence");
        var attendenceInfo=$("#attendenceInfo");
	
        var domain=$("#SchoolDomain");
        var domainInfo=$("#domainInfo");
	
        var address = $("#SchoolAddress");
        var addressInfo=$("#addressInfo");
	
        //var SchoolYear = $("#SchoolYear");
	
        var latitude = $("#SchoolLatitude");
        var latitudeInfo=$("#latitudeInfo");
	
        var longitude = $("#SchoolLongitude");
        var longitudeInfo=$("#longitudeInfo");
	
        var longitudeInfo=$("#longitudeInfo");
        var year = $("#SchoolYear");
        var yearInfo = $("#yearInfo");
        var zipcode = $("#SchoolZipcode");
        var zipcodeInfo = $("#zipcodeInfo");
	
        //On blur
        name.blur(validateName);
        short_description.blur(validateShortDescription);
        attendence.blur(validateAttendence);
        address.blur(validateAddress);
        latitude.blur(validateLatitude);
        longitude.blur(validateLongitude);
        domain.blur(validateschoolDomain);
        year.blur(validateYear);
        zipcode.blur(validateZipCode);
	
        //On key press
        name.keyup(validateName);
        short_description.keyup(validateShortDescription);
        attendence.keyup(validateAttendence);
        address.keyup(validateAddress);
        latitude.keyup(validateLatitude);
        longitude.keyup(validateLongitude);
        domain.keyup(validateschoolDomain);
        year.keyup(validateYear);
        zipcode.keyup(validateZipCode);
        
        //On Change
        //SchoolYear.change(validateYearSel);
	
        //On Submitting
        form.submit(function(){
	  
            if(validateZipCode() & validateYear() & validateName() & validateShortDescription()  & validateAddress() & validateAttendence() & validateLatitude() & validateLongitude() & validateschoolDomain())
                return true;
            else
                return false;
        });
        function validateZipCode(){
            //if it's NOT valid
            if(zipcode.val()=="" || isNaN(zipcode.val())){
                zipcode.addClass("zipcodeError");
                zipcodeInfo.addClass("error");
                zipcodeInfo.text("Zip Code must be a number");
                return false;
            }
            //if it's valid
            else{
                zipcode.removeClass("zipcodeError");
                zipcodeInfo.removeClass("error");
                zipcodeInfo.text("Done");
                return true;
            }
        }
        
        function validateYear(){
            //if it's NOT valid
            if(year.val()=="" || isNaN(year.val())){
                year.addClass("yearError");
                yearInfo.addClass("error");
                yearInfo.text("Foundation year must be a number");
                return false;
            }
            //if it's valid
            else{
                year.removeClass("yearError");
                yearInfo.removeClass("error");
                yearInfo.text("Done");
                return true;
            }
        }
        
        function validateName(){
            //if it's NOT valid
            if(name.val().length < 1){
                name.addClass("schoolNameError");
                nameInfo.addClass("error");
                nameInfo.text("School Name cannot be blank");
                return false;
            }
            //if it's valid
            else{
                name.removeClass("schoolNameError");
                nameInfo.removeClass("error");
                nameInfo.text("Done");
                return true;
            }
        }
	
	
        function validateShortDescription(){
            //if it's NOT valid
            if(short_description.val().length < 1){
                short_description.addClass("schoolShortDescriptionError");
                short_descriptionInfo.addClass("error");
                short_descriptionInfo.text("Short Description cannot be empty");
                return false;
            }
            //if it's valid
            else{
                short_description.removeClass("schoolShortDescriptionError");
                short_descriptionInfo.removeClass("error");
                short_descriptionInfo.text("Done");
                return true;
            }
        }
        function validateAddress(){
            //if it's NOT valid
            if(address.val().length < 1){
                address.addClass("addressError");
                addressInfo.addClass("error");
                addressInfo.text("Address cannot be blank");
                return false;
            }
            //if it's valid
            else{
                address.removeClass("addressError");
                addressInfo.removeClass("error");
                addressInfo.text("Done");
                return true;
            }
        }
	
        function validateAttendence(){
            //if it's NOT valid
            if(attendence.val()=="" || isNaN(attendence.val())){
                attendence.addClass("attendenceError");
                attendenceInfo.addClass("error");
                attendenceInfo.text("can't blank & should be numeric only");
                return false;
            }
            //if it's valid
            else{
                attendence.removeClass("attendenceError");
                attendenceInfo.removeClass("error");
                attendenceInfo.text("Done");
                return true;
            }
        }
	
	
        function validateLatitude(){
            //if it's NOT valid
            if(latitude.val()=="" || isNaN(latitude.val())){
                latitude.addClass("latitudeError");
                latitudeInfo.addClass("error");
                latitudeInfo.text("can't blank & should be numeric only");
                return false;
            }
            //if it's valid
            else{
                latitude.removeClass("latitudeError");
                latitudeInfo.removeClass("error");
                latitudeInfo.text("Done");
                return true;
            }
        }
	
        function validateLongitude(){
            //if it's NOT valid
            if(longitude.val()=="" || isNaN(longitude.val())){
                longitude.addClass("longitudeError");
                longitudeInfo.addClass("error");
                longitudeInfo.text("can't blank & should be numeric only");
                return false;
            }
            //if it's valid
            else{
                longitude.removeClass("longitudeError");
                longitudeInfo.removeClass("error");
                longitudeInfo.text("Done");
                return true;
            }
        }
	
       
	
        function validateschoolDomain(){
            //if it's NOT valid
            if(domain.val().length < 1){
                domain.addClass("domainNameError");
                domainInfo.addClass("error");
                domainInfo.text("School Domain Name cannot be blank");
                return false;
            }
            //if it's valid
            else{
                domain.removeClass("domainNameError");
                domainInfo.removeClass("error");
                domainInfo.text("Done");
                return true;
            }
        }
	
	
    });
</script>
<?php
unset($_SESSION['ct']);
unset($_SESSION['extra_image']);
?>
<div class="login">
    <?php echo $form->create('School', array('action' => 'admin_school_edit', 'type' => 'file')); ?>
    <?php $hello = "bye"; ?>

    <div class="editor_title">
        <label>School Name<span class="red">*</span></label> 
        <?php echo $form->text('name', array('class' => 'schoolName')); ?> 
        <span id="nameInfo" ></span> 
    </div>

    <div class="editor_title">
        <label>School Short Description<span class="red">*</span></label> 
        <?php echo $form->input('School.short_description', array('class' => 'schoolShortDescription', 'type' => 'textarea', 'label' => false)); ?> 
        <span id="short_descriptionInfo" ></span>
    </div>
    <label>Description</label>

    <?php echo $form->input('School.description', array('id' => 'editor1', 'label' => false, 'type' => 'textarea')); ?>
    <div class="login_form">
        <h2>School Attendence<span class="red" >*</span></h2> <?php echo $form->text('attendence', array('class' => 'schoolAttendence')); ?>
        <span id="attendenceInfo" ></span>
    </div>
    <br/>

    <div class="login_form">
        <h2>Address</h2> <?php echo $form->text('School.address', array('class' => 'schoolAddress')); ?> 
        <span id="addressInfo"></span> 

    </div>
    <div class="login_form">
        <h2>Zip Code<span class="red" >*</span></h2> <?php echo $form->text('School.zipcode', array('class' => 'zipcode')); ?> 
        <span id="zipcodeInfo"></span> 

    </div>
    <br/>

    <div class="login_form">
        <h2>Foundation Year<span class="red" >*</span></h2><?php echo $form->text('School.year', array('class' => 'year')); ?>
        <span id="yearInfo"></span> 
    </div>
    <br/>
    <div class="login_form">
        <h2>School Type </h2><?php echo $form->radio('School.type', array('private' => 'private', 'public' => 'public'), array('legend' => false)); ?>
    </div>
    <br/>

    <div class="login_form">
        <h2>Shool-email domain</h2><?php echo $form->text('School.domain', array('class' => 'domainName')); ?> 
        <span id="domainInfo"></span>
    </div>
    <br/>	 

    <div class="login_form">
        <h2>Country</h2> 
        <?php echo $form->select('School.country_id', $countries, $countries_id, array('onchange' => 'getState(this.value)'), 'Please Select'); ?>
    </div>
    <br/>

    <div class="login_form">
        <h2>State</h2><div id="statediv"> 
            <?php echo $form->select('School.state_id', $states, $states_id, array('onchange' => 'getCity(this.value)'), 'Please Select'); ?>
        </div>
    </div>
    <br/>

    <div class="login_form">
        <h2>City</h2><div id="citydiv">
            <?php echo $form->select('School.city_id', $cities, $cities_id, '', 'Please Select'); ?>
        </div>
    </div>

    <br/>


    <div class="login_form">
        <h2>Longitude</h2> <?php echo $form->text('longitude', array('class' => 'schoolLongitude')); ?>
        <span id="longitudeInfo" ></span> 
    </div>
    <br/>

    <div class="login_form">
        <h2>Latitude</h2> <?php echo $form->text('latitude', array('class' => 'schoolLatitude')); ?>
        <span id="latitudeInfo" ></span> 
    </div>
    <br/>
    <div class="login_form">    
        <h2>File</h2>
        <?php echo $form->input('file', array('type' => 'file', 'label' => false)); ?>&nbsp;
    </div>
    <br/>

    <?php if ($this->data['School']['image_url']) { ?>
        <div id="imageshow"><?php echo $html->image('files/schools/' . $this->data['School']['image_url'] . '', array('alt' => '', 'height' => '100', 'width' => '100')); ?>
            <br/><?php echo $html->link('Remove Image', array('action' => 'school_delimage', $this->data['School']['id'], $this->data['School']['image_url']), array('class' => 'confirm_delete', 'id' => $this->data['School']['id'], 'image_url' => $this->data['School']['image_url'])); ?></div>

    <?php } ?>

    <?php if (count($this->data['Image'])) { ?>
        <div class="login_form">
            <h2>Extra Images </h2>

            <table>
                <?php
                $i = 0;
                $e = count($this->data['Image']) - 1;

                for ($j = 0; $j < count($this->data['Image']); $j++) {
                    ?>
                    <?php
                    if ($i == 0) {
                        echo "<tr>";
                        $fli = "0";
                    }
                    if (($i % 4 == 0 && $i != 1 && $fli == "1") || ($li == "0")) {
                        echo "<tr>";
                        $li = "1";
                        $start = 0;
                    } $start++;
                    ?>
                    <td><div id="<?php echo $this->data['Image'][$j]['id']; ?>"><?php echo $html->image('files/test/' . $this->data['Image'][$j]['url'] . '', array('alt' => '', 'height' => '100', 'width' => '100')); ?>
                            <br/><?php echo $html->link('Remove Image', array('action' => 'school_extdelimage', $this->data['Image'][$j]['id'], $this->data['Image'][$j]['url']), array('class' => 'confirm_delete_extra', 'id' => $this->data['Image'][$j]['id'], 'image_url' => $this->data['Image'][$j]['url'])); ?></div></td>
                    <?php
                    if (($li == "1" && $start == "4") or ($i == 3) or ($i == $e)) {
                        echo "</tr>";
                        $li = "0";
                        $fli = "1";
                    }
                    $i++;
                }
                ?>
            </table>
        </div>

    <?php } ?>  

    <div class="login_form">
        <h2>Add More</h2> 
        <table><tr><td><div id="upload" style="margin:10px 0px 0px 0px;" ><span>Upload File<span></div><span id="status" ></span>
                                <ul id="files" ></ul>
                                </td></tr></table>
                                </div>


                                <?php e($form->text('School.id', array('type' => 'hidden'))); ?><br/>
                                <div id="submit_button">
                                    <?php echo $form->submit('Update', array('class' => 'update_button', 'div' => false)); ?>
                                    <div class="cancel_button"><a href="<?php e($html->url('/admin/schools/index')); ?>"><b>Cancel</b></a></div>
                                </div>


                                <?php echo $form->end(); ?>

                                </div>


                                <script type="text/javascript">				
                                    var editor = CKEDITOR.replace( 'editor1' );
                                    CKFinder.setupCKEditor( editor, '<?php echo $html->url('/js/ckfinder/'); ?>' ) ;
                                </script>