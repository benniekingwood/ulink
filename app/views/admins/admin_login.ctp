<div>
    <form id="frmLogin" name="frmLogin" method="post" action="<?php e($html->url('/admin/admins/login/')); ?>">
        <h2>Welcome to Administrative Area</h2>

        <div>
            <?php if (isset($msg) && $msg != "") { ?>
                <img src="<?php e($html->url('/img/error.png')); ?>" align="absmiddle"/>
                <?php e($msg);
            } ?>
        </div>

        <div>
            <div style="padding-bottom: 6px; padding-top: 18px;"><?php e($form->input('Admin.username', array('label' => array('label' => 'Username', 'style' => 'padding-right:10px;')))); ?></div>
            <div class="clear"></div>
        </div>

        <div style="padding-bottom: 6px;padding-top:5px; "><?php e($form->input('Admin.password', array('label' => array('label' => 'Passowrd', 'style' => 'padding-right:10px;'), 'type' => 'password'))); ?></div>
        <div style="padding-left:71px; padding-top:5px"><input type="checkbox" name="data[remember_me]" id="remember_me" /> Keep me signed in</div>

        <div style="padding-left:70px; padding-top:5px;"><input type="submit" name="login" value="Login" /></div>
        <div class="clear"></div>
    </form>


    <div style="padding-left:71px; padding-top:5px"><a href="<?php e($html->url('/admin/admins/forgot_password')); ?>">Forgot Password</a></div>
</div>