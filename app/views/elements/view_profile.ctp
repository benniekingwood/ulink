<?php echo $javascript->link(array('jquery.min.js')); ?>
<div class="modal profile-component fade hide" id="viewProfileComponent">
    <div class="row">
        <a class="close" data-dismiss="modal">x</a>
        <div class="span2">&nbsp;
            <?php echo $html->image('files/users/noImage.jpg', array('id'=>'vpImg', 'class'=>'rounded', 'alt' => 'profileImg')); ?>
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
        var url = hostname + "/users/viewprofile/" + id + "/" + username;

        // grab the user
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.onreadystatechange = function () {
            if (this.status == 200 && this.readyState == 4) {
                var data = JSON.parse(this.responseText);
                $('#vpUsername').html(data.User.username);
                $('#vpImg').attr('src',hostname+"/img/files/users/"+data.User.image_url);
                $('#vpFirstName').html(data.User.firstname);
                $('#vpLastName').html(data.User.lastname);
                $('#vpSchool').html(data.School.name);
                $('#vpSchoolStatus').html(data.User.school_status);
                $('#vpGradYear').html(data.User.year);
                $('#vpBio').html(data.User.bio);
            }
        };
        xhr.send(null);
    });

</script>