<div class="content">
    <h1 style="float:left">Profiles</h1>
    <div class="clear"></div>
    <?php
    $total = count($serchResultsUsers);
    if ($total) {

        for ($i = 0; $i < $total; $i++) {
            ?>

            <div class="content">

                <div class="info">
                    <div class="inner">
                        <div class="innerContent">

                            <div class="userProfileimage">
                                <?php
                                if (empty($serchResultsUsers[$i]['User']['image_url'])) {
                                    echo $this->Html->image(('noImage.jpg', array('alt' => '', 'height' => '112', 'width' => '112'));
                                } else {
                                    echo $this->Html->image(('files/users/' . $serchResultsUsers[$i]['User']['image_url'] . '', array('alt' => '', 'height' => '112', 'width' => '112'));
                                }
                                ?>
                                <?php //echo $this->Html->image(('files/users/'.$serchResultsUsers[$i]['User']['image_url'].'',array('alt'=>'','height'=>'112','width'=>'112'));?>
                            </div>
                            <div class="searchresult"><strong>Name :</strong><a href="<?php echo($this->Html->url('/users/userinfo/' . $serchResultsUsers[$i]['User']['id'] . '')); ?>"><?php echo ucwords($serchResultsUsers[$i]['User']['firstname']) . ' ' . ucwords($serchResultsUsers[$i]['User']['lastname']); ?></a></div>
                            <div class="searchresult"><strong>School Status :</strong><?php echo $serchResultsUsers[$i]['User']['school_status']; ?></div>
                            <div class="searchresult"><strong>School name :</strong><a href="<?php echo($this->Html->url('/schools/detail/' . $serchResultsUsers[$i]['School']['id'] . '')); ?>"><?php echo $serchResultsUsers[$i]['School']['name']; ?></a></div>
                            <div class="searchresult">
                                <span class="top_padd"><a href="<?php echo($this->Html->url('/users/userinfo/' . $serchResultsUsers[$i]['User']['id'] . '')); ?>"><?php echo $this->Html->image(('buttonViewdetails.gif') ?></a>
                                </span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear" style="height:20px;"></div>
        <?php
        }
    } else {
        echo "<h3>Sorry no user profile found with " . $search_srting . "</h3>";
    }
    ?>
    <div class="clear"></div>
    <div class="pagination"><span class="left"><?php
    echo $paginator->counter(array(
        'format' => 'Displaying  %start% to %current% out of %count% Profiles'
    ));
    ?></span>
        <span class="right"><div id="pagination">		
                <div >		
                    <?php
                    echo $paginator->first("<<First", array('class' => 'footer_nav', 'url' => $search_srting));
                    //echo '&nbsp;';
                    //echo $paginator->prev("<", array('class'=>'footer_nav'));
                    echo '&nbsp;&nbsp;';
                    echo $paginator->numbers(array('separator' => ' | ', 'url' => $search_srting));
                    echo '&nbsp;&nbsp;';
                    //echo $paginator->next(">", array('class'=>'footer_nav'));
                    //echo '&nbsp;';
                    echo $paginator->last("Last>>", array('class' => 'footer_nav', 'url' => $search_srting));
                    ?>

                </div>
            </div>
        </span>
    </div>
    <div class="clear"></div>
</div>