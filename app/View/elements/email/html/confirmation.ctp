Hi <?php echo($name); ?>,<br />
Thank you for signing up in Ulink. To complete the sign up process please click on the link below:<br />
<a href="http://<?php echo($server_name) ?><?php echo($this->Html->url(array('controller' => '/users', 'action' => 'confirm'))) ?>/<?php echo($id) ?>/<?php echo($code) ?>">Confirm your account</a>
