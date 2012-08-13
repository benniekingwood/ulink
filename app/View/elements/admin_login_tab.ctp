<div class="topLinks">
    <?php if (isset($_SESSION['admin_id'])) { ?>
        <div><a href="<?php echo($this->Html->url('/admin/admins/logout')); ?>">Logout</a></div>
    <?php } ?>
</div>
<div class="clear"></div>