<div class="inner_text">
    <h2><?php echo $newsDetails['Article']['title']; ?> </h2>

    <div class="listing">
        <div class="date">
            <b><i>
            <?php echo datecho("F", strtotimecho($newsDetails['Article']['modified']));?>&nbsp;
            <?php echo datecho("d", strtotimecho($newsDetails['Article']['modified']));?>, 
            <?php echo datecho("Y", strtotimecho($newsDetails['Article']['modified']));?>
                </i></b>
        </div>
        <div class="newsContent"><?php echo $newsDetails['Article']['description']; ?></div>
        <div class="clear"></div>
    </div>


</div>
