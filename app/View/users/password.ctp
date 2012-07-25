<div class="container-fluid">
    <?php echo $this->Form->create('User', array('action' => 'updatePassword', 'name' => 'UserIndexForm', 'type' => 'file', 'class' =>'form-horizontal')); ?>
    <?php echo $this->Form->input('User.username', array('type' => 'hidden')); ?>
    <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">

    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo($this->Html->url('/users/'));?>"> <i class="icon-user"></i>Profile</a></li>
                    <li class="active"><a href="#"><i class="icon-lock"></i>Password</a></li>
                    <li><a href="<?php echo($this->Html->url('/events/myevents'));?>"><i class="icon-calendar"></i>Events</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-nopadding well-white">
            <div id="password-tab-content">
                <input type="hidden" name="schooldomainCheck" id="schooldomainCheck" />
                <?php echo($this->Form->input('User.id', array('type' => 'hidden'))); ?>
                <div class="profile-header">
                    <h3>Password</h3>
                </div>
                <div id="profile-password-message">&nbsp;
                    <?php
                    if(isset($errors)) { echo $errors; }
                    else if (isset($pwdsavesuccess)) {  ?>
                        <span class='control-group profile-success'>Your password has been updated.</span>
                    <?php  }  else if(isset($pwdsavefail)) { ?>
                        <span class='control-group profile-error'>There was an issue updating your password.  Please try again, or contact help@theulink.com.</span>
                    <?php  } else if (isset($change)) { ?>
                        <span class='control-group profile-info'>Your password is auto generated, please change your password to gain full access to uLink.</span>
                    <?php } ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="oldPass1">Current Password</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.oldpass', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'password', 'id' => 'oldPass1', 'maxlength' => '50', 'label' => false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pass1">
                        New Password
                        <div class="pull-right span2" id="pass-strength-result">&nbsp;</div>
                    </label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.newpass', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'password', 'id' => 'pass1', 'maxlength' => '50', 'label' => false, 'div' => false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pass2">Verify Password</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.newconfirmpass', array('class' => 'input-xlarge ulink-input-bigfont','type' => 'password', 'id' => 'pass2', 'maxlength' => '50', 'label' => false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnUpdatePwd" class="btn btn-primary btn-large">Save changes</a>
                </div>
            </div>  <!-- /password-tab-content -->
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
<?php echo $this->Html->script(array('ulink-password-strength.js', 'ulink-update-profile-pwd.js')); ?>

