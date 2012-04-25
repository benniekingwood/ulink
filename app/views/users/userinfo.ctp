<div class="content">
    <div id="blueBox">
        <div class="top">
            <span class="left"><?php echo $html->image('blue-border-box-top-left.gif', array('alt' => '')); ?></span>
            <span class="right"><?php echo $html->image('blue-border-box-top-right.gif', array('alt' => '')); ?></span>
            <div class="clear"></div>
        </div>
        <div class="content">
            <div style="width:700px; margin:auto">
                <div class="userProfileimage">

                    <?php if ($User['User']['image_url'] != '' && file_exists(WWW_ROOT . '/img/files/users/' . $User['User']['image_url'])) {
                        ?>

                        <?php echo $html->image('files/users/' . $User['User']['image_url'] . '', array('alt' => '', 'height' => '150', 'width' => '150')); ?>


                    <?php } else { ?>

                        <img alt="" border="0" src="<?php e($html->url('/thumbs/index/')); ?>?src=/app/webroot/img/files/users/noImage.jpg&w=150&h=150" />
                    <?php } ?>


                </div>
                <div class="userDetails"><strong>Name :</strong><?php echo ucwords($User['User']['firstname']) . ' ' . ucwords($User['User']['lastname']); ?></div>
                <?php if ($User['Country']['countries_name']) { ?><div class="userDetails"><strong>Country :</strong><?php echo $User['Country']['countries_name']; ?></div><?php } ?>
                <?php if ($User['State']['name']) { ?><div class="userDetails"><strong>State :</strong><?php echo $User['State']['name']; ?></div><?php } ?>
                <?php if ($User['City']['name']) { ?><div class="userDetails"><strong>City :</strong><?php echo $User['City']['name']; ?></div><?php } ?>
                <div class="userDetails"><strong>School:</strong><a href="<?php e($html->url('/schools/detail/' . $User['School']['id'] . '')); ?>"><?php echo $User['School']['name']; ?></a></div>
                <div class="userDetails"><strong>School status :</strong><?php echo $User['User']['school_status']; ?></div>
                <div class="userDetails"><strong>Graduation Year:</strong><?php echo $User['User']['year']; ?></div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="bottom">
            <span class="left"><?php echo $html->image('blue-border-box-bottom-left.gif', array('alt' => '')); ?></span>
            <span class="right"><?php echo $html->image('blue-border-box-bottom-right.gif', array('alt' => '')); ?></span>
            <div class="clear"></div>
        </div>
    </div>
</div>