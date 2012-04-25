<div class="topLinks">
    <?php if (!isset($loggedInId)) { ?>
        <a href="<?php e($html->url('/users/register')); ?>">Join uLink</a>

        <?php if (isset($checkLogin)) {
            ?>
            <a href="javascript:void(0);" class="login">Log In</a>  

        <?php } else { ?>


            <a href="javascript:void(0);" class="login loginBoxPopup">Log In</a>
        <?php }
    } else { ?>
        <a href="<?php e($html->url('/users/')); ?>">My Profile</a>
        <?php
        if ($loggedInFacebookId > 0):
            echo $html->link('Log Out', '#', array('class' => 'login', 'onclick' => 'FB.Connect.logout(function() { document.location = "' . $html->url('/users/logout/') . '"; }); return false;'));
        else:
            ?>
            <a href="<?php echo $html->url('/users/logout'); ?>" class="login">Log Out</a>  
        <?php
        endif;
    }
    ?>
</div>
<div class="clear"></div>