<?php 
echo $form->create(null, array('action' => 'validate_data'));
echo $form->input('Message.url');
echo $form->end('Submit'); 
?>