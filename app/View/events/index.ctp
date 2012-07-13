<div class="container">
    <div class="row offset1">
        <a class="orange" href="<?php echo($this->Html->url('/ucampus/')); ?>">< Back</a>
    </div>
    <div class="event-picture thumbnail span4 well offset1">
        <img class="rounded" src="<?php echo $event['Event']['eventPicture]?>" alt="event picture">
    </div>
    <div>
        <div class="well span4">
            <h2><?php $event['Event']['eventTitle'] ?></h2>
            <div class="row">
                <div class="span1">
                    <?php if ($user['User']['image_url'] != '' && file_exists(WWW_ROOT . '/img/files/users/' . echo $user['User']['image_url'])) {
                             echo $this->Html->image('files/users/' . $user['User']['image_url'] . '', array('alt' =>'profileimage'));
                        } else {
                            echo $this->Html->image('files/users/noImage.jpg', array('alt' => 'noimage', 'class'=>'rounded'));
                        }
                    ?>
                </div>
                <div class="span3 event-user-info">
                    <h4>by <a id="view-profile-<?php echo $user['User']['user_id'] ?>" data-toggle="modal" href="#viewProfileComponent">blau3</a></h4>
                    <h6><?php echo $event['Event']['eventDate'].' '.$event['Event']['eventTime'] ?></h6>
                    <p><?php $event['Event']['eventLocation'] ?></p>
                </div>
            </div>
        </div>
        <div class="well span4">
            <p><?php echo $event['Event']['eventInfo'] ?></p>
        </div>
    </div>
</div> <!-- /container -->