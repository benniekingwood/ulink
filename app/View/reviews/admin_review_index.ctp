<script type="text/javascript" language="javascript">
    reviewVideoPopup = function(id,i){
        $('#video'+i).click(function() {
            tb_show("Video Review","<?php echo echo($this->Html->url('/admin/reviews/video?mode=1&height=310&width=250&code=')) ?>"+id, null);
        });
    }
</script>
<h1 class="form_head">Reviews</h1>
<?php echo $form->create(('Review', array('action' => 'admin_review_index')); ?>
<div class="search_admin">
    <b>Search  </b><?php echo $form->text('Review.searchText'); ?>
    <?php echo $form->submit('Search', array('div' => false)); ?>
    <div class="clear"></div>
</div>

<?php echo $form->end(); ?>

<div id="ajax_msg"></div>

<div id="ReviewList">
    <table border="1" cellpadding="0" cellspacing="0" id="myTable"  class="listing edit">
        <tr class="ListHeading">
            <td><b>S.No</b></td>
            <td><?php echo $paginator->sort('Title', 'title'); ?></td>
            <td><?php echo $paginator->sort('Review', 'description'); ?></td>
            <td><?php echo $paginator->sort('School', 'School.name'); ?></td>
            <td><?php echo $paginator->sort('Review Type', 'type'); ?></td>
            <td><?php echo $paginator->sort('Author Name', 'User.firstname'); ?></td>
            <td><?php echo $paginator->sort('Author Email', 'User.email'); ?></td>
            <td><?php echo $paginator->sort('Rating', 'rating'); ?></td>
            <td><?php echo $paginator->sort('Pending/Live', 'status'); ?></td>
            <td><b>Edit</b></td>
            <td><b>Remove</b></td>
            </thead> 
            <?php
            if (isset($page_no))
                $sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
            else
                $sr_no = 1;
            if (!empty($Review)) {
                $i = 0;
                foreach ($Review as $Review) {
                    ?>
                <tr id="<?php echo $Review['Review']['id'] ?>">    
                    <td><?php echo($i++ + $sr_no); ?>.</td>
                    <td><?php echo $Review['Review']['title']; ?></td>
                    <td><?php echo substr($Review['Review']['description'], 0, 50); ?></td>
                    <td><?php echo $Review['School']['name']; ?></td>
                    <?php if ($Review['Review']['type'] != 'video') { ?>
                        <td><?php echo $Review['Review']['type']; ?></td>
                    <?php } else { ?>
                        <td>
                            <a class="thickbox" id="video<?php echo $i; ?>" onclick="javascript:reviewVideoPopup('<?php echo $Review['Review']['link']; ?>',<?php echo $i; ?>);"> view <?php echo $Review['Review']['type']; ?>
                            </a>
                        </td>
                    <?php } ?>
                    <td><?php echo $Review['User']['firstname'] . ' ' . $Review['User']['lastname']; ?></td>
                    <td><?php echo $Review['User']['email']; ?></td>
                    <td><center><?php echo $this->Html->image(('star-' . $Review['Review']['rating'] . '.gif', array('alt' => '')); ?></center></td>
                <td><a class="changeStatus" path="<?php echo($this->Html->url('/admin/reviews/review_changeStatus/' . $Review['Review']['id'])); ?>" id="<?php echo $Review['Review']['id']; ?>"><?php
            if ($Review['Review']['status'] == 0)
                echo "<img src='" . $this->Html->url('/img/unpublish.png') . "' border='0'>"; else
                echo "<img src='" . $this->Html->url('/img/publish.png') . "' border='0'>";
            ?></a></td>
                <td><a href="<?php echo($this->Html->url('/admin/reviews/review_edit/' . $Review['Review']['id'])); ?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" border="0"/></a></td>
                <td><?php echo $this->Html->link('<img src="' . $this->Html->url('/img/delete.gif') . '" />', array('action' => 'review_delete', $Review['Review']['id']), array('class' => 'confirm_delete', 'id' => $Review['Review']['id'], 'escape' => false)); ?></td>                 
                </tr>
    <?php }
} else { ?>

            <tr><td colspan="11" align="center"><strong>No Record Found</strong></td></tr>

    <?php } ?>
    </table>

<?php echo $this->element('paging'); ?>
</div>