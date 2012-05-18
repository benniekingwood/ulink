/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 5/15/12
 * Description: This js file performs an ajax call to update the user's password
 ********************************************************************************/
$(document).ready(function () {
    // add click handler
    $('#btnUpdatePwd').click(function () {
        //organize the data properly
        var formData = $(this).parents('form').serialize();
        var strURL = hostname + "users/updatePassword/";
        $.ajax({
            type:"POST",
            url:strURL,
            data:formData,
            beforeSend: function () {
                if ($('#oldPass1').val() == "") {
                    $('#profile-password-message').html('<div class="profile-error">Please enter your current password.<div>').show();
                    $('#oldPass1').focus();
                    return false;
                }
            },
            success:function (response) {
                // show respsonse message
                if (response == 'true') {
                    $('#oldPass1').val('');
                    $('#pass1').val('');
                    $('#pass2').val('');
                    $('#profile-password-message').html("<p class='profile-success'>Your password has been updated</p>").show();
                } else {
                    $('#profile-password-message').html('<div class="profile-error">' + response + '<div>').show();
                }
            }
        });
        return false;
    });
});

