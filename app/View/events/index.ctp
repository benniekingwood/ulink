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
<?php


echo "<pre>";
$this->Session->flash();
foreach($events as $event)
{
	echo "<img width='100' height='100' src='/events/getEventImage/" . $event['Event']['_id'] . "'/><br/>";
	echo "<b>School: </b>" . $event["Event"]["collegeName"] . "<br/>";
	echo "<b>Title:</b> " . $event["Event"]["eventTitle"] . "<br/>";
	echo "<b>Date and time:</b> " . $this->Time->format('l F jS, Y', $this->Time->fromString($event["Event"]["eventDate"])) . "<br/>";
	echo "<b>Active?:</b> " . $event["Event"]["active"] . "<br/>";
	echo "<b>Featured?:</b> " . $event["Event"]["featured"] . "<br/>";
	echo "<b>Details</b></br>";
	echo $event["Event"]["eventInfo"] . "<br/>";
	echo $this->Html->link('Delete Event', array('controller'=>'events', 'action'=>'delete', $event["Event"]["_id"])) . "<br/>";
	echo $this->Html->link('Edit Event', array('controller'=>'events', 'action'=>'edit', $event["Event"]["_id"])) . "<br/>";
	echo $this->Html->link('Toggle Active', array('controller'=>'events', 'action'=>'toggleActive', $event["Event"]["_id"])) . "<br/>";
	echo $this->Html->link('Toggle Featured', array('controller'=>'events', 'action'=>'toggleFeatured', $event["Event"]["_id"])) . "<br/>";
	echo $this->Html->link('View event', array('controller'=>'events', 'action'=>'getEventById', $event["Event"]["_id"])) . "<br/>";
	echo $this->Html->link('View Image', array('controller'=>'events', 'action'=>'getEventImage', $event["Event"]["_id"])) . "<br/><br/>";
}
echo "</pre>";

?>
