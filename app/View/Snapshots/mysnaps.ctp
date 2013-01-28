<div class="container-fluid">
    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo($this->Html->url('/users/'));?>"> <i class="icon-user"></i>Profile</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/password'));?>"><i class="icon-lock"></i>Password</a></li>
                    <li><a href="<?php echo($this->Html->url('/events/myevents'));?>"><i class="icon-calendar"></i>Events</a></li>
                    <li class="active"><a href="#"><i class="icon-camera"></i>Snaps</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/social'));?>"><i class="icon-globe"></i>Social</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-cork well-nopadding">
            <div id="profile-tab-content" class="my-snaps-content tab-pane active">
                <div class="profile-header">
                    <h3>My Snaps</h3>
                </div>
                <div id="snap-message">
                    <?php echo $this->Session->flash(); ?>
                </div>
                <div id="my-snaps-container">
                    <?php
                        if(isset($snaps) && count($snaps) == 0) {
                            echo '<div class="alert alert-warn">You have no snaps at this time.</div>';
                        } else { ?>
                        <ul class="unstyled scroll thumbnails">
                        <?php foreach( $snaps as $snap ) {   ?>
                        <li class="span2">
                            <a class="pull-right my-snap-link" onclick="return confirm('Are you sure you would like to delete this snap?');" href="<?php echo($this->Html->url('/snapshots/deletesnap/'.$snap['Snapshot']['_id'])); ?>" alt=""><i class="icon-remove-sign"></i></a>
                            <div class="thumbnail snap-thumbnail">
                                <img src="<?php
                                    if(isset($snap['Snapshot']['imageURL'])) {
                                        echo($this->Html->url('/img/files/snaps/medium/'.$snap['Snapshot']['imageURL']));
                                    } else { echo($this->Html->url('/img/defaults/default_featured_event.png')); } ?>" alt=""/>
                                 <p><?php if (strlen($snap['Snapshot']['caption']) > 50) {
                                            echo htmlspecialchars_decode(substr($snap['Snapshot']['caption'], 0, 56)) . '...';
                                        } else { echo htmlspecialchars_decode($snap['Snapshot']['caption']); } ?>
                                </p>
                            </div>
                        </li>
                        <?php } }?>
                    </ul>
                </div>
            </div> <!-- /profile-tab-content -->
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
</div> <!-- /container-fluid -->