<script type="text/javascript">
    jQuery.validator.addMethod("selectSchool", function (value, element) {
        return selectschool();
    });

    jQuery.validator.addMethod("schoolStatusIsSelected", function (value, element) {
        return schoolstatusisselected();
    });

    jQuery.validator.addMethod("checkUsername", function (value, element) {

        alert(checkUsername());
    });


    function checkUsername() {

        var username = $("#UserUsername").val();
        var dataString = 'username=' + username;
        $.ajax({
            type:"POST",
            async:false,
            url:hostname + "users/checkUsername",
            data:dataString,
            success:function (data) {

                if (data == '1') {


                    return false;
                }
                else {
                    return true;
                }

            }
        });

    }

    function schoolstatusisselected() {
        return !$("#UserSchoolStatus").val() == "";
    }

    function selectschool() {
        return !$("#UserSchoolId").val() == "";
    }

    function getState(countryId) {

        //getCity();
        var strURL = hostname + "users/state/" + countryId;
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        $('#statediv').html(req.responseText);

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
        var strURL = hostname + "users/city/" + stateId;
        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {

                        $('#citydiv').html(req.responseText);
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
<script type="text/javascript">


    $(document).ready(function () {

        // tooltip initializations
        $("#school_input_info img[title]").tooltip({
            effect:'fade',
            position:'center right'
        });

        $("#password_input_info img[title]").tooltip({
            effect:'fade',
            position:'center right'
        });

        $("#email_input_info img[title]").tooltip({
            effect:'fade',
            position:'center right'
        });

        $("#UserSchoolStatus").change(function () {
            $("#UserEmail").removeData("previousValue");
        });

        $("#UserSchoolId").change(function () {
            $("#UserEmail").removeData("previousValue");
        });

        $("#UserRegisterForm").validate({
            errorPlacement:function (error, element) {
                element.after(error);

            },
            invalidHandler:function () {
                if ($(this).prev().hasClass('error')) $(this).prev().remove();
            },
            // onfocusout: false,

            rules:{
                'data[User][firstname]':"required",
                'data[User][lastname]':"required",

                'data[User][username]':{required:true,
                    remote:{
                        url:"<?php echo $html->url('/users/checkUsername/'); ?>",
                        type:"post",
                        data:{
                            username:function () {
                                return $("#UserUsername").val();
                            }
                        }
                    }
                },
                'data[User][major]':{
                    required:true,
                    minlength:3
                },

                'data[User][email]':{
                    selectSchool:true,
                    schoolStatusIsSelected:true,
                    required:true,
                    email:true,
                    remote:{
                        url:"<?php echo $html->url('/users/checkdomain/'); ?>",
                        type:"post",
                        data:{
                            email:function () {
                                return $("#UserEmail").val();
                            },
                            school_id:function () {
                                return $("#UserSchoolId").val();
                            },
                            school_status:function () {
                                return $("#UserSchoolStatus").val();
                            }
                        }
                    }

                },
                'data[User][school_id]':"required",
                'data[User][password]':{
                    required:true,
                    minlength:5
                },
                'data[User][confirm_password]':{
                    required:true,
                    equalTo:"#UserPassword"
                },
                'data[User][year]':"required",
                'data[User][hometown]':{
                    required:true,
                    minlength:3
                },
                'data[User][school_status]':"required",
                'data[User][file]':{ accept:"png|jpeg|jpg|gif" }
            },
            messages:{

                'data[User][username]':{
                    required:"User Name cannot be empty",
                    remote:"User name already taken"
                },

                'data[User][firstname]':{
                    required:"First name should not be empty"
                },
                'data[User][lastname]':{
                    required:"Last name should not be empty"
                },

                'data[User][password]':{
                    required:"Please enter password",
                    minlength:"Please enter at least 5 characters"
                },
                'data[User][confirm_password]':{
                    required:"Please enter password confirmation",
                    equalTo:"Passwords do not match"
                },
                'data[User][school_id]':{
                    required:"Please select a school"
                },
                'data[User][major]':{
                    required:"Major should not be empty",
                    minlength:"Major should be more than 3 characters"
                },
                'data[User][year]':{
                    required:"Please select your graduation year"
                },
                'data[User][hometown]':{
                    required:"Hometown should not be empty",
                    minlength:"Hometown should be more than 3 letters"
                },
                'data[User][school_status]':{
                    required:"Please select school status"
                },
                'data[User][email]':{
                    required:"Email Should not be empty",
                    email:"Please enter a valid email address",
                    remote:"Not a valid email for the school selected",
                    selectSchool:"Please select a school first",
                    schoolStatusIsSelected:"Please select your school status first"
                },
                'data[User][file]':{
                    accept:"Image format is not valid"
                }



            }
        });


    });


</script>
<?php echo $form->create('User', array('action' => 'register', 'name' => 'UserRegisterForm', 'type' => 'file')); ?>
<div class="registerContainter">

    <div class="registerHeading">
        <div class="headingTitle">Login Details</div>
        <div class="registerRequried"><span>&nbsp;</span>&nbsp;</div>
    </div>
    <div class="default_form_fields">
        <div class="content">

            <input type="hidden" name="schooldomainCheck" id="schooldomainCheck"/>


            <div class="input text">
                <div class="info_text"></div>

                <label for="UserUsername">User Name</label>
                <input type="text" id="UserUsername" value="" maxlength="255" name="data[User][username]"/>

                <div htmlfor="UserUsername" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="input password">
                <div id="password_input_info" class="info_text"><?php echo $html->image('question_blue.png',
                    array('title' => 'Password needs to be at least five characters.')); ?>
                </div>
                <label for="UserPassword">Password</label>
                <input type="password" id="UserPassword" value="" name="data[User][password]" class="title-error"/>

                <div htmlfor="UserPassword" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="input password">
                <div class="info_text"></div>
                <label for="UserConfirmPassword">Confirm Password</label>
                <input type="password" id="UserConfirmPassword" value="" name="data[User][confirm_password]"
                       class="title-error"/>

                <div htmlfor="UserConfirmPassword" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="registerBottom">
        <div><span></span></div>
    </div>
    <div class="clear"></div>
</div>


<div class="registerContainter">

    <div class="registerHeading">
        <div class="headingTitle">Personal Information</div>
        <div class="registerRequried"><span>&nbsp;</span>&nbsp;</div>
    </div>
    <div class="default_form_fields">
        <div class="content">

            <div class="input text required">
                <div class="info_text"></div>

                <label for="UserFirstname">First Name</label>
                <input type="text" id="UserFirstname" value="<?php echo $data[User][firstname] ?>" maxlength="50"
                       name="data[User][firstname]" class="title-error"/>

                <div htmlfor="UserFirstname" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="input text required">
                <div class="info_text"></div>

                <label for="UserLastname">Last Name</label>
                <input type="text" id="UserLastname" value="" maxlength="50" name="data[User][lastname]"
                       class="title-error"/>

                <div htmlfor="UserLastname" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="input text required">
                <div class="info_text"></div>

                <label for="UserHometown">Hometown</label>
                <input type="text" id="UserHometown" value="" maxlength="50" name="data[User][hometown]"
                       class="title-error"/>

                <div htmlfor="UserHometown" generated="true" class="error" style="display:none;"></div>
            </div>


            <?php
            echo $form->input('country_id', array('onchange' => 'getState(this.value)', 'value' => '223','type' =>
            'hidden', 'options' => $countries, 'empty' => 'Select Country'));
            ?>
            <!-- 2.05.12 we are defaulting the user country to US -->
            <script type="text/javascript" language="javascript">
                getState(223);
            </script>
            <div class="input text" id="statediv"><label>State</label><select name="state">
                <option>Select Country First</option>
            </select></div>
            <div class="input text" id="citydiv"><label>City</label><select name="city">
                <option>Select State First</option>
            </select></div>
            <?php echo $form->input('file', array('type' => 'file', 'label' => 'Profile Image')); ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="registerBottom">
        <div><span></span></div>
    </div>
    <div class="clear"></div>
</div>

<div class="registerContainter">

    <div class="registerHeading">
        <div class="headingTitle">School Details</div>
        <div class="registerRequried"><span>&nbsp;</span>&nbsp;</div>
    </div>
    <div class="default_form_fields">
        <div class="content">

            <div class="input select required">
                <div id="school_input_info" class="info_text"><?php echo $html->image('question_blue.png', array('title'
                    => 'If your school is not present, you will need to suggest your school
                    from the home page. This will speed up the process of adding your school to uLink.')); ?>
                </div>
                <label for="UserSchoolId">School</label>
                <?php echo $form->input('school_id', array('type' => 'select', 'options' => $schools, 'empty' =>
                    'Please Select', 'label' => false, 'div' => false));?>
                <div htmlfor="UserSchoolId" generated="true" class="error" style="display:none;"></div>
            </div>

            <div class="input select required">
                <div class="info_text"></div>

                <label for="UserSchoolStatus">School Status</label>
                <select id="UserSchoolStatus" class="userStatusSel title-error" name="data[User][school_status]">
                    <option value="">Please select</option>
                    <option value="Current Student">Current Student</option>
                    <option value="Alumni">Alumni</option>
                </select>

                <div htmlfor="UserSchoolStatus" generated="true" class="error" style="display:none;"></div>
            </div>
            <div class="valid_email">
                <div id="email_input_info" class="info_text"><?php echo $html->image('question_blue.png', array('title'
                    => 'Enter your school email address, if it does not validate with your school please contact us at
                    help@theulink.com.')); ?>
                </div>

                <label for="UserEmail">Email</label>
                <input type="text" id="UserEmail" value="" maxlength="255" name="data[User][email]" class="title-error">

                <div htmlfor="UserEmail" generated="true" class="error" style="display:none;"></div>

            </div>

            <div class="input text required">
                <label for="UserMajor">Major</label>
                <input type="text" id="UserMajor" value="" maxlength="100" name="data[User][major]" class="title-error">

                <div class="info_text"></div>
                <div htmlfor="UserMajor" generated="true" class="error" style="display:none;"></div>

            </div>
            <div class="input select required"><label for="UserYear">Graduation Year</label>

                <div class="info_text"></div>

                <select id="UserYear" class="userYearSel title-error" name="data[User][year]">
                    <option value="">Please select</option>
                    <option value="1961">1961</option>
                    <option value="1962">1962</option>
                    <option value="1963">1963</option>
                    <option value="1964">1964</option>
                    <option value="1965">1965</option>
                    <option value="1966">1966</option>
                    <option value="1967">1967</option>
                    <option value="1968">1968</option>
                    <option value="1969">1969</option>
                    <option value="1970">1970</option>
                    <option value="1971">1971</option>
                    <option value="1972">1972</option>
                    <option value="1973">1973</option>
                    <option value="1974">1974</option>
                    <option value="1975">1975</option>
                    <option value="1976">1976</option>
                    <option value="1977">1977</option>
                    <option value="1978">1978</option>
                    <option value="1979">1979</option>
                    <option value="1980">1980</option>
                    <option value="1981">1981</option>
                    <option value="1982">1982</option>
                    <option value="1983">1983</option>
                    <option value="1984">1984</option>
                    <option value="1985">1985</option>
                    <option value="1986">1986</option>
                    <option value="1987">1987</option>
                    <option value="1988">1988</option>
                    <option value="1989">1989</option>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                </select>

                <div htmlfor="UserYear" generated="true" class="error" style="display:none;"></div>
            </div>


            <?php
            echo "<div class='buttons'>";
            echo $form->submit('buttonRegister.gif');

            echo "
        </div>
        ";
        ?>

        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<div class="registerBottom">
    <div><span></span></div>
</div>
<div class="clear"></div>
</div>
<?php echo $form->end(); ?>
