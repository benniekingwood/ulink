<div class="registerContainter">

    <div class="registerHeading">
        <div class="headingTitle">Login Details</div>
        <div class="registerRequried"><span>*</span>Fields are required</div>
    </div>
    <div class="content">

        <?php echo $form->create('User', array('action' => 'register', 'name' => 'UserRegisterForm', 'type' => 'file')); ?>

        <?php
        echo $form->input('username');
        echo $form->input('password');
        echo "<div class='buttons'>";
        echo $form->submit('buttonLogin.gif');
        echo $form->submit('buttonLogin.gif');
        echo "</div>";
        ?>
        <?php echo $form->end(); ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div class="registerBottom"><div><span></span></div></div>
    <div class="clear"></div>
</div>