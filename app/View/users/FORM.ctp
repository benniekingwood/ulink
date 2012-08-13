<div class="registerContainter">

    <div class="registerHeading">
        <div class="headingTitle">Login Details</div>
        <div class="registerRequried"><span>*</span>Fields are required</div>
    </div>
    <div class="content">

        <?php echo $this->Form->create(('User', array('action' => 'register', 'name' => 'UserRegisterForm', 'type' => 'file')); ?>

        <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo "<div class='buttons'>";
        echo $this->Form->submit('buttonLogin.gif');
        echo $this->Form->submit('buttonLogin.gif');
        echo "</div>";
        ?>
        <?php echo $this->Form->end(); ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div class="registerBottom"><div><span></span></div></div>
    <div class="clear"></div>
</div>