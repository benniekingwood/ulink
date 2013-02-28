<div class="modal profile-component fade hide" id="viewProfileComponent">
    <div class="row">
        <!--<a class="close" data-dismiss="modal">x</a>-->
        <div class="span2">&nbsp;
            <img alt="profile image" id="vpImg" class="rounded" src="<?php echo URL_DEFAULT_USER_IMAGE ?>"/>
        </div>
        <div class="span3">
            <h2><span id="vpFirstName">Firstname</span>&nbsp;<span id="vpLastName">Lastname</span></h2>
            <p id="vpUsername" class="username">username</p>
            <p><span id="vpSchool" class="school">School Name</span>&nbsp;<span id="vpSchoolStatus" class="school-status">status</span></p>
            <p>Graduated&nbsp;<span id="vpGradYear" class="grad-year">YYYY</span></p>
            <p id="vpBio" class="bio">BIO</p>
        </div>
    </div>
</div> <!-- /viewProfileComponent -->
<script type="text/javascript" language="javascript">
    $("[id^=view-profile]").click(function() {
        // get the username
        var username = $(this).text();
        // grab the unique user id from the element's id
        var id = $(this).attr('id').split("-")[2];
        // build the url
        var url = hostname + "users/viewprofile/" + id;
        // perform get request, jquery version is efficient
        var jqxhr = $.get(url, function() {})
        .success(function(responseText) {
            var data = JSON.parse(responseText);
            $('#vpUsername').html(data.User.username);
            if(data.User.image_url != '' && data.User.image_url !== undefined && data.User.image_url != false && data.User.image_url) {
                $('#vpImg').attr('src',URL_IMAGES_S3+"files/users/medium/"+data.User.image_url);
            } else {
               $('#vpImg').attr('src',URL_DEFAULT_USER_IMAGE); 
            }
            $('#vpFirstName').html(data.User.firstname);
            $('#vpLastName').html(data.User.lastname);
            $('#vpSchool').html(data.School.name);
            $('#vpSchoolStatus').html(data.User.school_status);
            $('#vpGradYear').html(data.User.year);
            $('#vpBio').html(data.User.bio);
        })
        .error(function() {
            $('#vpUsername').html('username');
            $('#vpImg').attr('src',URL_DEFAULT_USER_IMAGE);
            $('#vpFirstName').html('Firstname');
            $('#vpLastName').html('Lastname');
            $('#vpSchool').html('School Name');
            $('#vpSchoolStatus').html('status');
            $('#vpGradYear').html('YYYY');
            $('#vpBio').html('BIO');
        });
    });
</script>