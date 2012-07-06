<?php


echo "<pre>";

echo $this->Form->create('Event', array('action' => 'add'));
echo $this->Form->input('collegeID', array('label' => 'Select School','options' => $schools));
echo $this->Form->input('eventTitle');
echo $this->Form->input('eventInfo', array('type'=>'textarea','rows' => '3','cols'=>'40'));
echo $this->Form->input('eventDate', array('type' => 'text','default' => 'MM/DD/YYYY'));
echo $this->Form->input('_id', array('type' => 'hidden'));
echo $this->Form->end('Add Event');

echo "</pre>";

?>