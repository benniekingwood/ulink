<?php
$url_string = $_SERVER['REQUEST_URI'];
$arr = explode('/', $url_string);
?>
<div class="admin_left">
    <h3>Welcome to Admin</h3>
    <div><a href="<?php e($html->url('/admin/admins/change_password')); ?>"  <?php if ($arr['3'] == 'admins') { ?>class="selected" <?php } ?>><?php echo $html->image('password.jpg') ?>Account Settings</a></div>
    <div><a href="<?php e($html->url('/admin/users/user_index')); ?>"  <?php if ($arr['3'] == 'users') { ?>class="selected" <?php } ?> ><?php echo $html->image('account.jpg') ?>Manage User Accounts</a></div>
    <div><a href="<?php e($html->url('/admin/schools/school_index')); ?>"  <?php if ($arr['3'] == 'schools') { ?>class="selected" <?php } ?>><?php echo $html->image('school.jpg') ?>Manage Schools</a></div>
    <div><a href="<?php e($html->url('/admin/suggestions/suggestion_index')); ?>"  <?php if ($arr['3'] == 'suggestions') { ?>class="selected" <?php } ?>><?php echo $html->image('school.jpg') ?>Manage Suggested Schools</a></div>
    <div><a href="<?php e($html->url('/admin/reviews/review_index')); ?>" <?php if ($arr['3'] == 'reviews') { ?>class="selected" <?php } ?>><?php echo $html->image('review.gif') ?>Manage Reviews</a></div>
    <div><a href="<?php e($html->url('/admin/articles/article_index')); ?>" <?php if ($arr['3'] == 'articles') { ?>class="selected" <?php } ?>><?php echo $html->image('review.gif') ?>Manage Articles</a></div>
</div>		
