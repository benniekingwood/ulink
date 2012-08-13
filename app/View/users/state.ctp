<?php  if(!empty($states)){ ?>
<label>State</label>
<?php echo $this->Form->select('User.state_id',$states,'',array('onchange'=>'getCity(this.value)'),'Select States');
} else { ?>
<label>State</label>
<?php echo $this->Form->select('User.state_id',$states,'',array('onchange'=>'getCity(this.value)'),'No States Found');} ?>
