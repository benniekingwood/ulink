<?php


echo "<pre>";
echo $this->Session->flash();
echo "<img width='100' height='100' src='/events/getEventImage/" . $event['Event']['_id'] . "'/><br/>";
echo $this->Form->create('Event', array('action' => 'edit','enctype' => 'multipart/form-data'));
echo $this->Form->input('collegeID', array('label' => 'Select School','options' => $schools));
echo $this->Form->input('eventTitle');
echo $this->Form->input('eventInfo', array('type'=>'textarea','rows' => '3','cols'=>'40'));
echo $this->Form->input('eventDate', array('type' => 'text','default' => 'MM/DD/YYYY'));
echo $this->Form->file('image',array('between'=>'<br />','type'=>'file'));
echo $this->Form->input('_id', array('type' => 'hidden'));
echo $this->Form->end('Update Event');

echo "</pre>";

?>