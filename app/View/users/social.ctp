<div class="container-fluid">
    <?php echo $this->Form->create('User', array('action' => 'social', 'name' => 'UserSocialForm', 'class' =>'form-horizontal')); ?>
    <?php echo $this->Form->input('User.username', array('type' => 'hidden')); ?>
    <input name="user_login" id="user_login" value="admin" disabled="disabled" type="hidden">

    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo($this->Html->url('/users/'));?>"> <i class="icon-user"></i>Profile</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/password'));?>"><i class="icon-lock"></i>Password</a></li>
                    <li><a href="<?php echo($this->Html->url('/events/myevents'));?>"><i class="icon-calendar"></i>Events</a></li>
                    <li><a href="<?php echo($this->Html->url('/snapshots/mysnaps'));?>"><i class="icon-camera"></i>Snaps</a></li>
                    <li class="active"><a href="#"><i class="icon-globe"></i>Social</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-nopadding well-white">
            <div id="password-tab-content">
                <?php echo($this->Form->input('User.id', array('type' => 'hidden'))); ?>
                <div class="profile-header">
                    <h3>Social</h3>
                </div>
                <div id="profile-message">&nbsp;
                    <?php echo $this->Session->flash(); ?>
                </div>
                <div class="alert alert-info">
                    Input your Twitter account username to have your tweets show up your school's uCampus homepage.  Stay tweeting my friends.
                </div>
                <div class="control-group">
                    <label class="control-label" for="twitter_username">Twitter Username</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.twitter_username', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'text', 'maxlength' => '50', 'label' => false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="twitter_enabled">Enabled</label>
                    <div class="controls">
                        <?php echo $this->Form->input('User.twitter_enabled', array('class' => 'input-xlarge ulink-input-bigfont', 'type' => 'checkbox', 'label' => false, 'div' => false)); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo $this->Form->button('Save changes', array('id'=>'btnSaveChanges', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-large'));?>
                </div>
            </div>  <!-- /password-tab-content -->
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
    <?php echo $this->Form->end(); ?>
</div> <!-- /container-fluid -->
