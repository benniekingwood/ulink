<script type="text/javascript">

    function loadPiece(href,divName) { 
        // Loading Image....
        //$('#imageList').fadeOut('slow');
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
<?php
if (isset($this->data['Map']['search'])) {
    $searchText = $this->data['Map']['search'];
} else if (isset($this->data['Review']['search'])) {
    $searchText = $this->data['Review']['search'];
} else if (isset($this->data['User']['search'])) {
    $searchText = $this->data['User']['search'];
}

$searchText = str_replace(" ", "-", $searchText);
?>
			   
        loadPiece("<?php echo $html->url(array('controller' => 'reviews', 'action' => 'search_ajax/' . $searchText)); ?>","#imageList");
    });
				
</script>
<div id="imageList" style="text-align:center;">
</div>