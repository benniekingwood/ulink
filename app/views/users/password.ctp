<div class="container-fluid">
    <?php echo $form->create('User', array('action' => 'updatePassword', 'name' => 'UserIndexForm', 'type' => 'file', 'class' => 'form-horizontal')); ?>
    <?php echo $form->input('User.username', array('type' => 'hidden')); ?>
    <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">

    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php e($html->url('/users/'));?>"> <i class="icon-user"></i>My Profile</a></li>
                    <li class="active"><a href="#"><i class="icon-lock"></i>Password</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-white">
            <div id="password-tab-content">
                <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
                <?php e($form->input('User.id', array('type' => 'hidden'))); ?>
                <div class="profile-header">
                    <h3>Password</h3>
                </div>
                <hr />
                <div id="profile-password-message">&nbsp;
                    <?php
                    if(isset($errors)) { echo $errors; }
                    else if (isset($pwdsavesuccess)) {  ?>
                    <span class='control-group profile-success'>Your password has been updated.</span>
                    <?php  }  else if(isset($pwdsavefail)) { ?>
                    <span class='control-group profile-error'>There was an issue updating your password.  Please try again, or contact help@theulink.com.</span>
                    <?php  } ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="oldPass1">Current Password</label>
                    <div class="controls">
                        <?php echo $form->input('User.oldpass', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'password', 'id' => 'oldPass1', 'maxlength' => '50', 'label' => false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pass1">
                        New Password
                        <div class="pull-right span2" id="pass-strength-result">&nbsp;</div>
                    </label>
                    <div class="controls">
                        <?php echo $form->input('User.newpass', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'password', 'id' => 'pass1', 'maxlength' => '50', 'label' => false, 'div' => false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pass2">Verify Password</label>
                    <div class="controls">
                        <?php echo $form->input('User.newconfirmpass', array('class' => 'input-xlarge ulink-input-bigfont','type' => 'password', 'id' => 'pass2', 'maxlength' => '50', 'label' => false, 'div'=>false)); ?>
                    </div>
                </div>
                <a id="btnUpdatePwd" class="btn btn-primary btn-large">Save changes</a>
            </div>  <!-- /password-tab-content -->
            <?php echo $form->end(); ?>
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
</div> <!-- /container-fluid -->
<?php echo $form->end(); ?>
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
<?php echo $javascript->link(array('ulink-password-strength.js', 'ulink-update-profile-pwd.js')); ?>

