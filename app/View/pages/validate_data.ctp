<?php 
echo $this->Form->create((null, array('action' => 'validate_data'));
echo $this->Form->input('Message.url');
echo $this->Form->end('Submit'); 
?>