<?php


echo "<pre>";
$this->Session->flash();

echo "<img width='300' height='300' src='/events/getEventImage/" . $event['Event']['_id'] . "'/><br/>";
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
echo $this->Html->link('View Image', array('controller'=>'events', 'action'=>'getEventImage', $event["Event"]["_id"])) . "<br/><br/>";

echo "</pre>";

?>