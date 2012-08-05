/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 5/15/12
 * Description: This js file performs an ajax call to remove the user's profile image
 ********************************************************************************/
$(document).ready(function () {
    // class exists
    if ($('.remove-profile-image').length) {
        // add click handler
        $('.remove-profile-image').click(function () {
            // ask for confirmation
            var result = confirm('Are you sure you want to remove your profile image?');
            $('#flashMessage').fadeOut();
            if (result) {
                $.ajax({
                    type:"POST",
                    url:$(this).attr('href'),
                    data:"ajax=1",
                    success:function (response) {
                        // show respsonse message
                        if (response == 'true') {
                            $('#profile-image').html("<img src='" + hostname + "app/webroot/img/files/users/noImage.jpg' />");
                        } else {
                            $('#profile-message').html('<div class="jerror">Sorry!! Try again.<div>').show();
                        }
                    }
                });
            }
            return false;
        });
    }
});