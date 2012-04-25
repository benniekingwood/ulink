<div class="topLinks">
    <?php if (isset($_SESSION['admin_id'])) { ?>
        <div><a href="<?php e($html->url('/admin/admins/logout')); ?>">Logout</a></div>
    <?php } ?>
</div>
<div class="clear"></div>