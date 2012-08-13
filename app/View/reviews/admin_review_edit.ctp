<?php echo ($this->Html->script(array('ckeditor/ckeditor', 'ckfinder/ckfinder'))); //includes .JS files ?>
<script type="text/javascript" language="javascript">
		
    function setDisplayRatingLevel(level) {
        for(i = 1; i <= 5; i++) {
            var starImg = "img_rateMiniStarOff.gif";
            if( i <= level ) {
                starImg = "img_rateMiniStarOn.gif";
            }
            var imgName = 'star'+i;
            document.images[imgName].src=hostname+"/app/webroot/img/"+starImg;
        }
    }
    function resetRatingLevel() {
		
        setDisplayRatingLevel(document.ReviewAdminReviewEditForm.ReviewRating.value);
		    
    }
		
    function setRatingLevel(level) {
        document.ReviewAdminReviewEditForm.ReviewRating.value = level; 
		  
    }
		
</script>


<div class="login">
    <?php echo $this->Form->create(('Review', array('action' => 'admin_review_edit', 'name' => 'ReviewAdminReviewEditForm')); ?>
    <?php $hello = "bye"; ?>
    <?php echo $this->Form->input('Review.title'); ?>

    <h3>Rate It</h3><p><?php for ($i = 1; $i < 6; $i++) { ?>	

            <?php echo $this->Html->image(('img_rateMiniStarOff.gif', array('onclick' => 'setRatingLevel(' . $i . ')', 'onMouseOut' => 'resetRatingLevel()', 'onmouseover' => 'setDisplayRatingLevel(' . $i . ')', 'name' => 'star' . $i . '')); ?>
            </a>	
        <?php } ?>

        <?php echo $this->Form->input('Review.description', array('id' => 'editor1', 'label' => 'Description', 'type' => 'textarea')); ?>

        <?php echo($this->Form->text('Review.id', array('type' => 'hidden'))); ?><br/>

        <?php echo($this->Form->text('Review.rating', array('type' => 'hidden'))); ?>

        <?php echo $this->Form->submit('Update', array('value' => 'Update')); ?>
        <?php echo $this->Form->end(); ?>

    <div><object width="200" height="200" data="http://www.youtube.com/v/<?php echo $link; ?>" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/<?php echo $link; ?>" /></object></div>

</div>

<div><a href="<?php echo($this->Html->url('/admin/reviews/index')); ?>"><b>Cancel</b></a></div><?php if ($status == 0) { ?><div><a href="<?php echo($this->Html->url('/admin/reviews/reviews_changeStatus/' . $this->params['pass'][0])); ?>"><b>Publish to live</b></a></div><?php } ?><?php if ($status == 1) { ?><div><a href="<?php echo($this->Html->url('/admin/reviews/reviews_changeStatus/' . $this->params['pass'][0])); ?>"><b>Return to pending</b></a></div><?php } ?>


<script type="text/javascript">
    setDisplayRatingLevel('<?php echo $ShowRating; ?>');
</script>

<script type="text/javascript">				
    var editor = CKEDITOR.replacecho( 'editor1' );
    CKFinder.setupCKEditor( editor, '<?php echo $this->Html->url('/js/ckfinder/'); ?>' ) ;
</script>