<h3>Hi <?php echo $name;?></h3>
Your Username is : <?php echo $username; ?><br /><br />
Your uLink temporary password is: <b><?php echo $auto_pass ?></b><br /><br /> You can <?php echo($this->Html->link('login here',$this->Html->url('/users/login', true))) ?> with your temporary password and proceed to change your password.<br/>
Regards,<br/>
Ulink Team