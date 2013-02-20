<div class="container">
    <div class="row offset1">
        <a class="orange" href="<?php echo($this->Html->url('/ucampus/')); ?>">< Back</a>
    </div>
    <div class="event-picture thumbnail span4 well offset1">
        <img class="rounded" src="<?php
                                    if(isset($event['Event']['imageURL'])) {
                                        echo(URL_EVENT_IMAGE.$event['Event']['imageURL']);
                                    } else { echo(URL_DEFAULT_EVENT_IMAGE); } ?>" alt="event image"/>
        <br />
        <div class="caption">
            <!--<a href="https://twitter.com/share" class="twitter-share-button" data-related="ulinkInc" data-dnt="true">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            -->
        </div>
    </div>
    <div>
        <div class="well span4">
            <h2><?php echo $event['Event']['eventTitle'] ?></h2>
            <div class="row">
                <div class="span1 event-user-picture-container">
                    <a href="#">
                    <?php if ($eventUser['User']['image_url'] != '' && getimagesize(URL_USER_IMAGE_MEDIUM . $eventUser['User']['image_url'])) { ?>
                           <img src="<?php echo URL_USER_IMAGE_MEDIUM . $eventUser['User']['image_url'] ?>" class="rounded" alt="user profile image" />
                   <?php } else { ?>
                     <img src="<?php echo URL_DEFAULT_USER_IMAGE ?>" class="rounded" alt="default user image" />
                   <?php } ?>
                </a>
                </div>
                <div class="span3 event-user-info">
                    <h4>by <a id="view-profile-<?php echo $eventUser['User']['id'] ?>" data-toggle="modal" href="#viewProfileComponent"><?php echo $eventUser['User']['username'] ?></a></h4>
                    <h6><?php echo $event['Event']['eventDate'] .' '.$event['Event']['eventTime']?></h6>
                    <p><?php echo $event['Event']['eventLocation'] ?></p>
                </div>
            </div>
        </div>
        <div class="well span4">
            <p><?php echo $event['Event']['eventInfo'] ?></p>
        </div>
    </div>
</div> <!-- /container -->