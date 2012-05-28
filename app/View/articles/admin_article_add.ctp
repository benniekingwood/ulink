<?php 
echo ($javascript->link(array('ckeditor/ckeditor', 'ckfinder/ckfinder'))); //includes .JS files?
echo $form->create(('Article', array('action' => 'admin_article_add','name'=>'AdminArticleAddForm','type'=>'file'));
echo $form->input('Article.title',array('maxlength'=>'255','label'=>'Title'));
echo $form->input('Article.description',array('id' => 'editor1','label'=>'Description','type'=>'textarea'));
echo $form->input('Article.status',array('type'=>'select','label'=>'Status','options'=>array('0'=>'Unpublish','1'=>'Publish'),'empty'=>'Select status'));
echo $form->submit('Add',array('id'=>'send','value'=>'Add'));
echo $form->end(); 
?>
<script type="text/javascript">				
	var editor = CKEDITOR.replacecho( 'editor1' );
	CKFinder.setupCKEditor( editor, '<?php echo $this->Html->url('/js/ckfinder/');?>');
</script>				