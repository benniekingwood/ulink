<?php
$url_string = $_SERVER['REQUEST_URI'];
$arr = explodecho('/', $url_string);
?>
<div class="admin_left">
    <h3>Welcome to Admin</h3>
    <div><a href="<?php echo($this->Html->url('/admin/admins/change_password')); ?>"  <?php if ($arr['3'] == 'admins') { ?>class="selected" <?php } ?>><?php echo $this->Html->image(('password.jpg') ?>Account Settings</a></div>
    <div><a href="<?php echo($this->Html->url('/admin/users/user_index')); ?>"  <?php if ($arr['3'] == 'users') { ?>class="selected" <?php } ?> ><?php echo $this->Html->image(('account.jpg') ?>Manage User Accounts</a></div>
    <div><a href="<?php echo($this->Html->url('/admin/schools/school_index')); ?>"  <?php if ($arr['3'] == 'schools') { ?>class="selected" <?php } ?>><?php echo $this->Html->image(('school.jpg') ?>Manage Schools</a></div>
    <div><a href="<?php echo($this->Html->url('/admin/suggestions/suggestion_index')); ?>"  <?php if ($arr['3'] == 'suggestions') { ?>class="selected" <?php } ?>><?php echo $this->Html->image(('school.jpg') ?>Manage Suggested Schools</a></div>
    <div><a href="<?php echo($this->Html->url('/admin/reviews/review_index')); ?>" <?php if ($arr['3'] == 'reviews') { ?>class="selected" <?php } ?>><?php echo $this->Html->image(('review.gif') ?>Manage Reviews</a></div>
    <div><a href="<?php echo($this->Html->url('/admin/articles/article_index')); ?>" <?php if ($arr['3'] == 'articles') { ?>class="selected" <?php } ?>><?php echo $this->Html->image(('review.gif') ?>Manage Articles</a></div>
</div>		
