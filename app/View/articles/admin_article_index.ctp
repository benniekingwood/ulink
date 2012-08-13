<h1 class="form_head">Articles</h1>
<?php echo $this->Form->create(('Article', array('action' => 'admin_article_index')); ?>
<div class="search_admin">
    <b>Search  </b><?php echo $this->Form->text('Article.searchText'); ?>
    <?php echo $this->Form->submit('Search', array('div' => false)); ?>
    <div class="clear"></div>
</div>

<?php echo $this->Form->end(); ?>

<div id="ajax_msg"></div>

<div id="articleList">
    <table border="1" cellpadding="0" cellspacing="0" id="myTable"  class="listing edit">
        <tr class="ListHeading"> 
            <td><b>S.No</b></td>
            <td><?php echo $paginator->sort('Title', 'title'); ?></td>
            <td><?php echo $paginator->sort('Publish', 'status'); ?></td>
            <td><b>Edit</b></td>
            <td><b>Remove</b></td>
        </tr>
        <?php
        if (isset($page_no))
            $sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
        else
            $sr_no = 1;
        if (!empty($Article)) {
            $i = 0;
            foreach ($Article as $article) {
                ?>
                <tr id="<?php echo $article['Article']['id'] ?>">    
                    <td><?php echo($i++ + $sr_no); ?>.</td>
                    <td><?php echo $article['Article']['title']; ?></td>
                    <td><a class="changeStatus" path="<?php echo($this->Html->url('/admin/articles/article_changeStatus/' . $article['Article']['id'])); ?>" id="<?php echo $article['Article']['id']; ?>"><?php if ($article['Article']['status'] == 0)
            echo "<img src='" . $this->Html->url('/img/unpublish.png') . "' border='0'>"; else
            echo "<img src='" . $this->Html->url('/img/publish.png') . "' border='0'>"; ?></a></td>

                    <td><a href="<?php echo($this->Html->url('/admin/articles/article_edit/' . $article['Article']['id'])); ?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" border="0"/></a></td>
                    <td><?php echo $this->Html->link('<img src="' . $this->Html->url('/img/delete.gif') . '" />', array('action' => 'article_delete', $article['Article']['id']), array('class' => 'confirm_delete', 'id' => $article['Article']['id'], 'escape' => false)); ?></td>                 
                </tr>
    <?php }
} else { ?>
            <tr><td colspan="5" align="center"><strong>No Articles Found</strong></td></tr>
<?php } ?>
    </table>

<?php echo $this->element('paging'); ?>

    <div>
        <a href="<?php echo($this->Html->url('/admin/articles/article_add/')); ?>">Add Article</a>
    </div>
</div>



