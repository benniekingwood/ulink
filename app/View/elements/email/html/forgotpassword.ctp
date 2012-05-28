Hello <?php echo $name;?><br/><br/>
Your username is: <?php echo $usersname;?><br /><br /> 
Your uLink temporary password is: <?php echo $auto_pass ?><br /><br /> You can <a href="http://<?php echo(SERVER_NAME) ?><?php echo($this->Html->url(array('controller' => '/users', 'action' => 'login'))) ?>">login here</a>
 with your temporary password and proceed to change your password.<br/>


Regards,
<br />
<br />
uLink Team