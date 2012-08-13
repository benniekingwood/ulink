<?php echo ($this->Html->script(array('ckeditor/ckeditor', 'ckfinder/ckfinder'))); //includes .JS files?>
<?php echo $this->Form->create(('Article', array('action' => 'admin_article_edit','name'=>'AdminArticleAddForm','type'=>'file'));?>
<?php echo $this->Form->input('Article.id',array('type'=>'hidden'));?>
<div class="editor_title">
	<label>Title</label>
	<?php echo $this->Form->input('Article.title',array('maxlength'=>'50','label'=>false , 'div'=>false));?>
</div>
<label class="editor_desp">Description</label>
<?php echo $this->Form->input('Article.description',array('maxlength'=>'50','id' => 'editor1','label'=>false,'type'=>'textarea',));?>
<?php echo $this->Form->input('Article.status',array('type'=>'select','label'=>'Status','options'=>array('0'=>'Unpublish','1'=>'Publish'),'empty'=>'Select status'));?>
<?php echo $this->Form->submit('&nbsp;',array('id'=>'send','value'=>'Update','escape'=>false));?>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">				
	var editor = CKEDITOR.replacecho( 'editor1' );
	CKFinder.setupCKEditor( editor, '<?php echo $this->Html->url('/js/ckfinder/');?>' ) ;
</script>
				
				
				
				
				
