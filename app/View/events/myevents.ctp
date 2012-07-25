<div class="container-fluid">
    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo($this->Html->url('/users/'));?>"> <i class="icon-user"></i>Profile</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/password'));?>"><i class="icon-lock"></i>Password</a></li>
                    <li  class="active"><a href="<?php echo($this->Html->url('/users/events'));?>"><i class="icon-calendar"></i>Events</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-white well-nopadding">
            <div id="profile-tab-content" class="my-events-content tab-pane active">
                <div class="profile-header">
                    <h3>My Events</h3>
                </div>
                <div id="event-message">
                    <?php echo $this->Session->flash(); ?>
                </div>
                <div id="my-events-container">
                    <ul class="unstyled scroll">
                        <?php foreach( $events as $event ) {   ?>
                        <li><a class="pull-right my-event-link" href="<?php echo($this->Html->url('/events/edit/'.$event['Event']['_id'])); ?>" alt=""><i class="icon-share-alt"></i>Edit</a>
                            <div class="row">
                                <div class="span1">
                                    <?php echo "<img class='my-events-img' src='/events/getEventImage/" . $event['Event']['_id'] . "' alt='my event picture'/>"; ?>
                                </div>
                                <div class="my-event-container">
                                    <span class="my-event-title"><?php echo $event['Event']['eventTitle'] ?></span>&nbsp;-&nbsp;<span class="campus-event-date"><?php echo DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']['date'])->format('F d, Y'); ?></span>
                                    <p><?php if (strlen($event['Event']['eventInfo']) > 200) {
                                            echo substr($event['Event']['eventInfo'], 0, 250) . '...';
                                        } else { echo $event['Event']['eventInfo']; } ?></p>
                                </div>
                            </div>
                        </li>
                        <?php } ;?>
                    </ul>
                </div>
            </div> <!-- /profile-tab-content -->
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
</div> <!-- /container-fluid -->