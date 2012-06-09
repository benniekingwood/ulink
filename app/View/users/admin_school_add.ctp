<?php echo $this->Form->create(('School',array('action' => 'school_add','type'=>'file'));?>
   <?php
      echo $this->Form->input('name');
      echo $this->Form->input('attendence'); 
      echo $this->Form->input('address'); ?>
      Country <?php echo $this->Form->select('country_id',$countries,'','','Please Select');?><br/>
	  <?php echo $this->Form->input('longitude');
	  echo $this->Form->input('latitude'); ?>
	  <?php echo $this->Form->input('file', array('type'=>'file')); ?>
     
	  
<?php echo $this->Form->end('Submit');?>