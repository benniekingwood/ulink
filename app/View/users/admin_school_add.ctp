<?php echo $form->create(('School',array('action' => 'school_add','type'=>'file'));?>
   <?php
      echo $form->input('name');
      echo $form->input('attendence'); 
      echo $form->input('address'); ?>
      Country <?php echo $form->select('country_id',$countries,'','','Please Select');?><br/>
	  <?php echo $form->input('longitude');
	  echo $form->input('latitude'); ?>
	  <?php echo $form->input('file', array('type'=>'file')); ?>
     
	  
<?php echo $form->end('Submit');?>