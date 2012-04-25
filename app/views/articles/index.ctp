<div class="inner_text">
    <h2><?php echo $newsDetails['Article']['title']; ?> </h2>

    <div class="listing">
        <div class="date">
            <b><i>
            <?php echo date("F", strtotime($newsDetails['Article']['modified']));?>&nbsp;
            <?php echo date("d", strtotime($newsDetails['Article']['modified']));?>, 
            <?php echo date("Y", strtotime($newsDetails['Article']['modified']));?>
                </i></b>
        </div>
        <div class="newsContent"><?php echo $newsDetails['Article']['description']; ?></div>
        <div class="clear"></div>
    </div>


</div>
