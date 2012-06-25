Hi <?php echo $name; ?>,<br />
Thank you for signing up in uLink. To complete the sign up process please click on the link below:<br />

<?php 
    $url = $this->Html->url('/users/confirm', true);
    $url .= '/'.$id.'/'.$code;
echo($this->Html->link('Activate Your Account',$url)) 
?>