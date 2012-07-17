<div class="container-fluid">
    <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'index', 'name' => 'UserIndexForm', 'type' => 'file', 'class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('User.username', array('type' => 'hidden')); ?>
    <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">
    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li class="active"><a href="#"> <i class="icon-user"></i>My Profile</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/password'));?>"><i class="icon-lock"></i>Password</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/events'));?>"><i class="icon-calendar"></i>My Events</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-white well-nopadding">
            <div id="profile-tab-content" class="profile-content tab-pane active">
               <div class="profile-header">
                    <h3>My Profile</h3>
               </div>
                <div id="profile-message">
                    <?php echo $this->Session->flash(); ?>
                </div>
                <div class="row">
                    <div class="span3">
                        <?php if ($this->data['User']['image_url'] != '' && file_exists(WWW_ROOT . '/img/files/users/' . $this->data['User']['image_url'])) {?>
                            <div id="profile-image">
                                <?php echo $this->Html->image('files/users/' . $this->data['User']['image_url'] . '', array('alt' => 'profile image')); ?>
                                <br />
                                <?php echo $this->Html->link('Remove this image', array('action' => 'removeImage', $this->data['User']['image_url']), array('class' => 'remove-profile-image', 'id' => $this->data['User']['id'], 'image_url' => $this->data['User']['image_url'])); ?>
                            </div>
                        <?php } else { ?>
                            <div>
                                <?php echo $this->Html->image('files/users/noImage.jpg', array('alt' => 'noprofileimagg')); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="span3">
                        <?php echo $this->Form->input('file', array('class' => 'profile-file-upload','type' => 'file', 'label' => false, 'div' => false)); ?>
                        <p>Maximum file size 700k.<br />Filetypes JPG,PNG,GIF.</p>
                        <a href="<?php echo($this->Html->url('/users/deactivate'));?>">Deactivate my account</a>
                    </div>
                </div>
                <hr />
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.username', array('id'=>'username', 'class' => 'input-xlarge', 'type' => 'text','disabled'=>'disabled', 'label'=>false, 'div'=>false)); ?>
                    </div>
                </div>
               <div class="control-group">
                    <label class="control-label" for="firstname">First Name</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.firstname', array('id' => 'firstname', 'class' => 'input-xlarge','maxlength' => '50', 'label'=>false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="lastname">Last Name</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.lastname', array('id' => 'lastname', 'class' => 'input-xlarge','maxlength' => '50', 'label'=>false, 'div'=>false)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="bio">Bio</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.bio', array('id' => 'bio', 'type'=>'textarea', 'maxlength' => '150',
                        'class' => 'input-xlarge','maxlength' => '150', 'label'=>false, 'div'=>false)); ?>
                        <p class="input-info">Describe yourself in <b>150</b> characters or less.</p>
                    </div>
                </div>
                <hr />
                <div class="control-group">
                    <label class="control-label" for="school_id">School</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.school_id', array('id'=>'school_id','class' => 'input-xlarge','type' => 'select','label'=>false, 'div'=>false, 'disabled' => 'true', 'options' => $schools, 'selected' => $schools_id)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="school_status">School Status</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.school_status', array('id' => 'school_status','class' => 'input-xlarge',
                        'options' => array('Current Student' => 'Current Student', 'Alumni' => 'Alumni'), 'type' => 'select', 'label'=>false, 'div'=>false, 'selected' => $school_status, 'empty' => 'Please Select')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">School Email</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.email', array('id'=>'email','class' => 'input-xlarge', 'type' => 'text', 'label'=>false, 'div'=>false,'disabled'=>'true')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="year">Graduation Year</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.year', array('id'=>'year', 'class' => 'input-xlarge', 'type' => 'select', 'options' => $years, 'selected' => $years_id, 'label'=>false, 'div'=>false, 'empty' => 'Please Select')); ?>
                    </div>
                </div>
                <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
                <?php echo($this->Form->input('User.id', array('type' => 'hidden'))); ?>
                <?php echo($this->Form->input('User.image_url', array('type' => 'hidden'))); ?>
                <?php echo($this->Form->input('User.email', array('type' => 'hidden'))); ?>
                <div class="modal-footer">
                    <?php echo $this->Form->button('Save changes', array('id'=>'btnSaveChanges', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-large'));?>
                </div>
            </div> <!-- /profile-tab-content -->

            <?php echo $this->Form->end(); ?>
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
</div> <!-- /container-fluid -->
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
    /* <![CDATA[ */
    try{convertEntities(commonL10n);}catch(e){};
    var pwsL10n = {
        empty: '<span>&nbsp;</span>',
        short: "<span class='label'>Very weak</b>",
        bad: "<span class='label label-warning'>Weak</b>",
        good: "<span class='label label-warning'>Medium</span>",
        strong: "<span class='label label-success'>Strong</span>",
        mismatch: "<span class='label label-important'>Mismatch</span>"
    };
    try{convertEntities(pwsL10n);}catch(e){};
    /* ]]> */
</script>
<!--<script src="/js/jquery.min.js"></script>-->
<script type="text/javascript">
    $.validator.addMethod("noSpecialChars", function(value, element) {
      return this.optional(element) || /^[a-z0-9\_\s]+$/i.test(value);
    });
    
    /*
     * value = value of the element (file name)
     * element = element to validate (<input>)
     * param = size (en bytes)
     */
    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param)
    });
    
    $(document).ready(function(){

      $("#UserIndexForm").validate({
           invalidHandler: function () {
           $('.profile-error').each(function(a,b){
                                    $(this).remove();
                                    });
           },
           errorClass: "profile-error",
           ignore: ':hidden',
           rules: {
               'data[User][firstname]': {
               required: true,
               noSpecialChars:true
           },
               'data[User][lastname]' :{
               required: true,
               noSpecialChars:true
           },
               'data[User][username]' : "required",
               'data[User][year]' : "required",
               'data[User][school_status]' :"required",
               'data[User][file]' : { accept:"png|jpeg|jpg|gif", filesize: 700000 }
           },
           messages: {
               'data[User][firstname]'	: {
                   required: "Please enter your first name",
                   noSpecialChars: "Please on use letters for your first name"
               },
               'data[User][lastname]' : { 
                   required: "Please enter your last name",
                   noSpecialChars: "Please on use letters for your last name"
               },
               'data[User][year]' : {
                   required: "Please select your graduation year"
               },
               'data[User][school_status]'	: { 
                   required: "Please select your school status"
               },
               'data[User][file]' : { 
                   accept: "Please use images of type jpg, png or gif",
                   filesize: "File size must be less than 700k"
               }
               }
           });
      });
</script>
<?php echo $this->Html->script(array('ulink-remove-profile-img.js')); ?>
