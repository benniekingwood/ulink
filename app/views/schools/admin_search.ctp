<h1>Suggestions Search results</h1>
<?php echo $form->create('School', array('action' => 'search', 'name' => 'searchForm')); ?>
<?php echo $form->input('School.search'); ?><br/>
<?php echo $form->submit('Search', array('div' => false)); ?>

<script type="text/javascript">
    function loadPiece(href,divName) {
        $('#imageList').fadeOut('slow');
        document.getElementById('imageList').innerHTML = '<br/><img src="<?php e($html->url('/img/ajax-loader.gif')); ?>" />';//+document.getElementById('imageList').innerHTML;

        $(divName).load(href, {}, function(a,b){ 
            var divPaginationLinks = divName+" #pagination a";
            $(divPaginationLinks).click(function() {
                var thisHref = $(this).attr("href");
                loadPiece(thisHref,divName);
	            	
                $('#imageList').fadeIn('slow');
				    
                return false;
            });
        });
    }

    $(document).ready(function() {
        loadPiece("<?php echo $html->url(array('controller' => 'Schools', 'action' => 'all_search_ajax/' . $search_srting)); ?>","#imageList");
    });
</script>
<div id="imageList" style="text-align:center;">
</div>

<div><a href="<?php e($html->url('/admin/schools/index/')); ?>">Back To school</a></div>