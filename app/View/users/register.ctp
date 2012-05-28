<script type="text/javascript">
$(document).ready(function () {
    jQuery.validator.addMethod("selectSchool", function (value, element) {
        return $("#UserSchoolId").val() != "";
    });

    jQuery.validator.addMethod("schoolStatusIsSelected", function (value, element) {
        return $("#UserSchoolStatus").val() != "";
    });

    jQuery.validator.addMethod("checkUsername", function (value, element) {
        alert(checkUsernamecho());
    });

    /**
     * This function will make an ajax call to
     * validate the username to make sure it's not
     * already in use.
     */
    function checkUsernamecho() {
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

    $("#UserSchoolStatus").changecho(function () {
        $("#UserEmail").removeData("previousValue");
    });

    $("#UserSchoolId").changecho(function () {
        $("#UserEmail").removeData("previousValue");
    });
    $("#UserRegisterForm").validatecho({
        ignore: ':hidden',
        errorClass: "jerror",
        errorPlacement:function (error, element) {
            error.appendTo( element.parent("div").next("div") );
        },
        invalidHandler:function () {
           if ( $(this).prev().hasClass('jerror')) {
                $(this).prev().removecho();
            }
        },
        rules:{
            'data[User][username]':{
                required:true,
                remote:{
                    url:"<?php echo $this->Html->url('/users/checkUsername/'); ?>",
                    type:"post",
                    data:{
                        username:function () {
                            return $("#UserUsername").val();
                        }
                    }
                }
            },
            'data[User][email]':{
                selectSchool:true,
                required:true,
                email:true,
                remote:{
                    url:"<?php echo $this->Html->url('/users/checkdomain/'); ?>",
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
                minlength:6
            },
            'data[User][confirm_password]':{
                required:true,
                equalTo:"#UserPassword"
            },
            'data[User][school_status]':"required"
        },
        messages:{
            'data[User][username]':{
                required:"What about your username?",
                remote:"That username is already being used, please try another."
            },
            'data[User][password]':{
                required:"Did you forget about your password?",
                minlength:"Please enter at least six characters"
            },
            'data[User][confirm_password]':{
                required:"Please enter password confirmation",
                equalTo:"Passwords do not match"
            },
            'data[User][school_id]':{
                required:"What school did you go to?"
            },
            'data[User][school_status]':{
                required:"Please choose your school status"
            },
            'data[User][email]':{
                required:"Please enter your email",
                email:"Please enter a valid email address",
                selectSchool:"Please select a school first",
                schoolStatusIsSelected:"Please select your school status first",
                remote:"That email is not valid for the school selected"
            }
        }
    });
});
</script>

<div class="container">
    <?php echo $form->create(('User', array('action' => 'register', 'name' => 'UserRegisterForm', 'type' => 'file')); ?>
    <div id="login-details-container" class="well well-white span7 offset2">
        <span class="flash-error"><?php $session->flash(); ?></span>
        <h3>Login Details</h3>

        <div id="login-details-form-fields">
            <div class="controls">
                <input type="hidden" name="schooldomainCheck" id="schooldomainCheck"/>
                <div class="row">
                    <div class="span4">
                        <input placeholder="username" type="text" id="UserUsername" value="" maxlength="255" name="data[User][username]" class="input-xlarger ulink-input-bigfont"/>
                    </div>
                    <div class="span3"></div>
                </div>
                <div class="row">
                    <div class="span4">
                        <input placeholder="password" type="password" id="UserPassword" value="" name="data[User][password]" class="input-xlarger ulink-input-bigfont" rel = "tooltip" data-original-title="Password needs to be at least six characters, be crafty!"/>
                    </div>
                    <div class="span3"></div>
                </div>
                <div class="row">
                    <div class="span4">
                    <input placeholder="confirm password" type="password" id="UserConfirmPassword" value="" name="data[User][confirm_password]" class="input-xlarger ulink-input-bigfont"/>
                    </div>
                    <div class="span3"></div>
                </div>
            </div>
        </div> <!-- /login-details-form-fields -->
    </div>  <!-- /login-details-container -->

    <div id="school-details-container" class="well well-white span7 offset2">
        <h3>School Details</h3>
        <div id="school-details-form-fields">
            <div class="row">
                <div class="span4">
                    <select id="UserSchoolStatus" class="input-xlarger" name="data[User][school_status]">
                        <option value="">Please select status</option>
                        <option value="Current Student">Current Student</option>
                        <option value="Alumni">Alumni</option>
                    </select>
                </div>
                <div class="span3"></div>
            </div>
            <div class="row">
                <div class="span4">
                    <?php
                        echo $form->input('school_id', array('type' => 'select', 'options' => $schools, 'empty' =>
                        'Select school', 'label' => false, 'div' => false, 'class' => 'input-xlarger', 'rel'=>'tooltip', 'data-original-title'
                    => 'If your school is not present, you will need to suggest your school
                    from the home page. This will speed up the process of adding your school to uLink.'));
                    ?>
                </div>
                <div class="span3"></div>
            </div>
            <div class="row">
                <div class="span4">
                   <input class="input-xlarger ulink-input-bigfont" placeholder="email" type="text"
                   id="UserEmail" value="" maxlength="255" name="data[User][email]"
                   rel="tooltip" data-original-title="Enter your school email address, if it does not validate with your school please contact us at
                    help@theulink.com.">
                </div>
                <div class="span3"></div>
            </div>
        </div> <!-- school-info-form-fields -->
        <div class="alert alert-info">
            By Pressing the "Create My Account" button you agree to the terms and conditions listed in the Terms section of this website.
        </div>
        <div class="span4">
            <?php echo $form->button('Create My Account', array('id'=>'btnCreateAccount', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-xlarge-wide'));?>
        </div>
    </div>  <!--school-details-container-->
    <?php echo $form->end(); ?>
</div> <!-- container -->