<h1 class="form_head">Schools</h1>
<?php echo $form->create(('School', array('action' => 'admin_school_index'));?>


<div class="search_admin">
		<b>Search  </b><?php echo $form->text('School.searchText');?>
		<?php echo $form->submit('Search',array('div'=>false));?>
		<div class="clear"></div>
	</div>

<?php echo $form->end(); ?>
<div id="ajax_msg"></div>
<div id="SchoolList">
     <table border="1" cellpadding="0" cellspacing="0" id="myTable"  class="listing edit">
        <tr class="ListHeading">
	     <td><b>S.No</b></td>
		 <td><?php echo $paginator->sort('Name', 'name'); ?></td>
		 <td><?php echo $paginator->sort('Address', 'address'); ?></td>
		 <td><?php echo $paginator->sort('Attendence', 'attendence'); ?></td>
		 <td><?php echo $paginator->sort('Zipcode', 'zipcode'); ?></td>
		 <td><b>Edit</b></td>
		 <td><b>Remove</b></td>
		</tr>	
	     <?php
		 if(isset($page_no))
					$sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
				else
					$sr_no = 1;
			if(!empty($School))
			{	
		  $i =0 ; foreach($School as $School){ ?>
	     <tr id="<?php echo $School['School']['id'] ?>">    
         <td><?php echo($i++ + $sr_no ); ?>.</td>
		 <td><?php echo $School['School']['name'];?></td>
		 <td><?php echo $School['School']['address'];?></td>
		 <td><?php echo $School['School']['attendence'];?></td>
		 <td><?php echo $School['School']['zipcode'];?></td>
		 
		 <td><a href="<?php echo($this->Html->url('/admin/schools/school_edit/'.$School['School']['id'])); ?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" border="0"/></a></td>
		 <td><?php echo $this->Html->link('<img src="'.$this->Html->url('/img/delete.gif').'" />',array('action'=>'School_delete',$School['School']['id']),array('class'=>'confirm_delete','id'=>$School['School']['id'],'escape'=>false));?>              
              </tr>
		<?php }}  else { ?>
		<tr><td colspan="7" align="center"><strong>No Record Found</strong></td></tr>
		<?php  }?>
		 
     </table>

<?php echo $this->element('paging');?>

<div>
<a href="<?php echo($this->Html->url('/admin/schools/school_add/')); ?>">Add School</a>
</div>
</div>