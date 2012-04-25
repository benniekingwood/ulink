<?php echo ($javascript->link(array('ckeditor/ckeditor', 'ckfinder/ckfinder'))); //includes .JS files?>
<?php echo $form->create('Article', array('action' => 'admin_article_edit','name'=>'AdminArticleAddForm','type'=>'file'));?>
<?php echo $form->input('Article.id',array('type'=>'hidden'));?>
<div class="editor_title">
	<label>Title</label>
	<?php echo $form->input('Article.title',array('maxlength'=>'50','label'=>false , 'div'=>false));?>
</div>
<label class="editor_desp">Description</label>
<?php echo $form->input('Article.description',array('maxlength'=>'50','id' => 'editor1','label'=>false,'type'=>'textarea',));?>
<?php echo $form->input('Article.status',array('type'=>'select','label'=>'Status','options'=>array('0'=>'Unpublish','1'=>'Publish'),'empty'=>'Select status'));?>
<?php echo $form->submit('&nbsp;',array('id'=>'send','value'=>'Update','escape'=>false));?>
<?php echo $form->end(); ?>
<script type="text/javascript">				
	var editor = CKEDITOR.replace( 'editor1' );
	CKFinder.setupCKEditor( editor, '<?php echo $html->url('/js/ckfinder/');?>' ) ;
</script>
				
				
				
				
				
