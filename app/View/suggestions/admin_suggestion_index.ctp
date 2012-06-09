<h1 class="form_head">Suggested Schools</h1>
<?php echo $this->Form->create(('Suggestion', array('action' => 'admin_suggestion_index')); ?>

<div class="search_admin">
    <b>Search  </b><?php echo $this->Form->text('Suggestion.searchText'); ?>
    <?php echo $this->Form->submit('Search', array('div' => false)); ?>
    <div class="clear"></div>
</div>

<?php echo $this->Form->end(); ?>
<div id="ajax_msg"></div>
<div id="SuggestionList">
    <table border="1" cellpadding="0" cellspacing="0" id="myTable"  class="listing edit">
        <tr class="ListHeading" >
            <td><b>S.No</b></td>
            <td><?php echo $paginator->sort('Name', 'name'); ?></td>
            <td><b>Remove</b></td>
        </tr>
        <?php
        if (isset($page_no))
            $sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
        else
            $sr_no = 1;
        if (!empty($Suggestion)) {
            $i = 0;
            foreach ($Suggestion as $Suggestion) {
                ?>
                <tr id="<?php echo $Suggestion['Suggestion']['id'] ?>">    
                    <td><?php echo($i++ + $sr_no); ?>.</td>
                    <td><?php echo $Suggestion['Suggestion']['name']; ?></td>
                    <td><?php echo $this->Html->link('<img src="' . $this->Html->url('/img/delete.gif') . '" />', array('action' => 'suggestion_delete', $Suggestion['Suggestion']['id']), array('class' => 'confirm_delete', 'id' => $Suggestion['Suggestion']['id'], 'escape' => false)); ?>              
                </tr>
    <?php }
} else { ?>

            <tr><td colspan="3" align="center"><strong>No Record Found</strong></td></tr>
    <?php } ?>
    </table>
<?php echo $this->element('paging'); ?>
</div>