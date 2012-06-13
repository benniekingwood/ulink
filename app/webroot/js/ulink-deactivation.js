/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 6/3/12
 * Description: This javascript file contains the function that will deactivate
 *              a user's uLink account
 ********************************************************************************/
$(document).ready(function () {
    // add click handler
    $('#btn-deactivate').click(function () {
        //organize the data properly
        var strURL = hostname + "users/deactivateaccount/";
        $.ajax({
            type:"GET",
            url:strURL,
            beforeSend: function () {
                return confirm("Are you sure you would like to deactivate your account?");
            },
            success:function (response) {
                // show response message
                if (response == 'true') {
                    $('#deactivate-container').hide();
                    $('#deactive-container').show();
                } else {
                    $('#deactivate-message').html('<div class="profile-error">' + response + '<div>').show();
                }
            }
        });
        return false;
    });
});