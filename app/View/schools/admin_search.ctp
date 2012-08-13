<h1>Suggestions Search results</h1>
<?php echo $this->Form->create(('School', array('action' => 'search', 'name' => 'searchForm')); ?>
<?php echo $this->Form->input('School.search'); ?><br/>
<?php echo $this->Form->submit('Search', array('div' => false)); ?>

<script type="text/javascript">
    function loadPiececho(href,divName) {
        $('#imageList').fadeOut('slow');
        document.getElementById('imageList').innerHTML = '<br/><img src="<?php echo($this->Html->url('/img/ajax-loader.gif')); ?>" />';//+document.getElementById('imageList').innerHTML;

        $(divName).load(href, {}, function(a,b){ 
            var divPaginationLinks = divName+" #pagination a";
            $(divPaginationLinks).click(function() {
                var thisHref = $(this).attr("href");
                loadPiececho(thisHref,divName);
	            	
                $('#imageList').fadeIn('slow');
				    
                return false;
            });
        });
    }

    $(document).ready(function() {
        loadPiececho("<?php echo $this->Html->url(array('controller' => 'Schools', 'action' => 'all_search_ajax/' . $search_srting)); ?>","#imageList");
    });
</script>
<div id="imageList" style="text-align:center;">
</div>

<div><a href="<?php echo($this->Html->url('/admin/schools/index/')); ?>">Back To school</a></div>