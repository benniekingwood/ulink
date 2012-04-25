Hi <?php echo $name;?><br/><br/>
Your Username is : <?php echo $username; ?><br /><br />
Your ULink temporary password is: <?php echo $auto_pass ?><br /><br /> You can <?php e($html->link('login here',array('controller' => 'users', 'action' => 'login'))) ?>" with your temporary password and proceed to change your password.<br/>
Regards<br/>
Ulink Team