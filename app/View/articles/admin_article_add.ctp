<?php 
echo ($this->Html->script(array('ckeditor/ckeditor', 'ckfinder/ckfinder'))); //includes .JS files?
echo $this->Form->create(('Article', array('action' => 'admin_article_add','name'=>'AdminArticleAddForm','type'=>'file'));
echo $this->Form->input('Article.title',array('maxlength'=>'255','label'=>'Title'));
echo $this->Form->input('Article.description',array('id' => 'editor1','label'=>'Description','type'=>'textarea'));
echo $this->Form->input('Article.status',array('type'=>'select','label'=>'Status','options'=>array('0'=>'Unpublish','1'=>'Publish'),'empty'=>'Select status'));
echo $this->Form->submit('Add',array('id'=>'send','value'=>'Add'));
echo $this->Form->end(); 
?>
<script type="text/javascript">				
	var editor = CKEDITOR.replacecho( 'editor1' );
	CKFinder.setupCKEditor( editor, '<?php echo $this->Html->url('/js/ckfinder/');?>');
</script>				