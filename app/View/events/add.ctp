<?php


echo "<pre>";
echo $this->Session->flash();
echo $this->Form->create('Event', array('action' => 'add','type' => 'file'));
echo $this->Form->input('collegeID', array('label' => 'Select School','options' => $schools));
echo $this->Form->input('eventTitle');
echo $this->Form->input('eventInfo', array('type'=>'textarea','rows' => '3','cols'=>'40'));
echo $this->Form->input('eventDate', array('type' => 'text','default' => 'MM/DD/YYYY'));
echo $this->Form->file('image');
echo $this->Form->input('_id', array('type' => 'hidden'));
echo $this->Form->input('userID', array('type' => 'hidden', 'value' => $user['id']));
echo $this->Form->end('Add Event');

echo "</pre>";

?>