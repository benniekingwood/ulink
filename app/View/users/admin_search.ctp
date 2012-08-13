<h1>Users</h1>
<script type="text/javascript">
    function loadPiececho(href,divName) {
        $('#imageList').fadeOut('slow');
        document.getElementById('imageList').innerHTML = '<br/><img src="<?php echo($this->Html->url('/img/loading.gif')); ?>" />';//+document.getElementById('imageList').innerHTML;

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
        loadPiececho("<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'all_search_ajax/' . $search_srting)); ?>","#imageList");
    });
</script>
<div id="imageList" style="text-align:center;">

</div>