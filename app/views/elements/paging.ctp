<div id="pagination">		
    <div class="bottom-text">		
        <?php
        echo $paginator->first("<<", array('class' => 'footer_nav'));
        echo '&nbsp;&nbsp;';
        echo $paginator->prev("<", array('class' => 'footer_nav'));
        echo '&nbsp;&nbsp;';
        echo $paginator->numbers(array('separator' => ' | '));
        echo '&nbsp;&nbsp;';
        echo $paginator->next(">", array('class' => 'footer_nav'));
        echo '&nbsp;&nbsp;';
        echo $paginator->last(">>", array('class' => 'footer_nav'));
        ?>
    </div>
</div>