
<?php
      echo "ECHO this will be the events search page";

echo "<pre>";
$this->Session->flash();
foreach($events as $event)
{
	echo "<img width='100' height='100' src='/events/getEventImage/" . $event['Event']['_id'] . "'/><br/>";
	echo "<b>School: </b>" . $event["Event"]["collegeName"] . "<br/>";
	echo "<b>Title:</b> " . $event["Event"]["eventTitle"] . "<br/>";
	echo "<b>Date and time:</b> " .  DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']['date'])->format('F d, Y'). "<br/>";
	echo "<b>Active?:</b> " . $event["Event"]["active"] . "<br/>";
	echo "<b>Featured?:</b> " . $event["Event"]["featured"] . "<br/>";
	echo "<b>Username:</b> " . $event["Event"]["userName"] . "<br/>";
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
