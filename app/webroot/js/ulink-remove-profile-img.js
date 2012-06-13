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