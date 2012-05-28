<h1 class="form_head">Users</h1>
<?php echo $form->create(('User', array('action' => 'admin_user_index')); ?>
<div class="search_admin">
    <b>Search  </b><?php echo $form->text('User.searchText'); ?>
    <?php echo $form->submit('Search', array('div' => false)); ?>
    <div class="clear"></div>
</div>
<?php echo $form->end(); ?>

<div id="ajax_msg"></div>

<div id="imageList">
    <table border="1" cellpadding="0" cellspacing="0" id="myTable" class="listing edit" >
        <tr class="ListHeading" >
            <td><b>S.No</b></td>
            <td><b><?php echo $paginator->sort('First Name', 'firstname'); ?></b></td>
            <td><b><?php echo $paginator->sort('Last Name', 'lastname'); ?></b></td>
            <td><b><?php echo $paginator->sort('Email', 'email'); ?></b></td>
            <td><b><?php echo $paginator->sort('Active/Inactive', 'activation'); ?></b></td>
            <td><b>Edit</b></th>
            <td><b>Remove</b></th>
        <tr> 
            <?php
            if (isset($page_no))
                $sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
            else
                $sr_no = 1;

            $i = 0;
            foreach ($User as $user) {
                ?>
            <tr id="<?php echo $user['User']['id'] ?>">    
                <td><?php echo($i++ + $sr_no); ?>.</td>
                <td><?php echo $user['User']['firstname']; ?></td>
                <td><?php echo $user['User']['lastname']; ?></td>
                <td><?php echo $user['User']['email']; ?></td>
                <td><a class="changeStatus" path="<?php echo($this->Html->url('/admin/users/user_changeStatus/' . $user['User']['id'])); ?>" id="<?php echo $user['User']['id']; ?>"><?php if ($user['User']['activation'] == 0)
                    echo "<img src='" . $this->Html->url('/img/unpublish.png') . "' border='0'>"; else
                    echo "<img src='" . $this->Html->url('/img/publish.png') . "' border='0'>"; ?></a></td>

                <td><a href="<?php echo($this->Html->url('/admin/users/user_edit/' . $user['User']['id'])); ?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" border="0"/></a></td>
                <td><?php echo $this->Html->link('<img src="' . $this->Html->url('/img/delete.gif') . '" />', array('action' => 'user_delete', $user['User']['id']), array('class' => 'confirm_delete', 'id' => $user['User']['id'], 'escape' => false)); ?></td>                 
            </tr>
<?php } ?>
    </table>

<?php echo $this->element('paging'); ?>

    <div class="admin_link">

        <a href="<?php echo($this->Html->url('/admin/users/user_add/')); ?>">Add User</a>
    </div>
</div>