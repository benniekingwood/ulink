<?php echo $this->Form->select('User.state_id',$states,'',array('onchange'=>'getCity(this.value)'),'Select States');?>
