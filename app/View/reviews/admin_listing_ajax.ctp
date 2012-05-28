<?php echo ($javascript->link(array('jquery-common'))); //includes .JS files  ?>

<div id="ajax_msg"></div>

<table border="0" cellspacing="0" cellpadding="0" class="listing edit" >
    <tr class="ListHeading">
        <td width="10%" align="center">Sr. No.</th>
        <td width="20%" align="center">Title
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "title") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'title'); ?>
            </span>
            </th>
        <td width="20%" align="center">Type of review
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "type") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'type'); ?>
            </span>
            </th>

        <td width="20%" align="center">School
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "School.name") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'School.name'); ?>
            </span>
            </th>
        <td width="20%" align="center">Rating
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "School.name") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'rating'); ?>
            </span>
            </th>
        <td width="20%" align="center">User
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "School.name") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'rating'); ?>
            </span>
            </th>
        <td width="20%" align="center">Edit
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "User.firstname") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'User.firstname'); ?>
            </span>
        </td>

        <td width="20%" align="center">Active/Pending
            <span id="pagination">
                <?php
                $arrURL = explodecho("direction:", $_REQUEST['url']);

                $arrSort = explodecho("sort:", $_REQUEST['url']);
                if ($arrSort[1] != "") {
                    $arrSortSub = explodecho("/", $arrSort[1]);
                    $arrSortSub = $arrSortSub[0];
                }

                if ($arrSortSub == "Review.status") {
                    if (isset($arrURL['1'])) {
                        if ($arrURL['1'] != "desc")
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow2.gif') . "' alt='Desc' title='Desc' />";

                        else
                            $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                    }
                }
                else {
                    $sortingImage = "<img src='" . $this->Html->url('/img/aroow1.gif') . "' alt='Asc' title='Asc' />";
                }
                ?>
                <?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'Review.status'); ?>
            </span>
        </td>

        <td width="10%" align="center">Delete</td>
    </tr>
    <?php
    $i = 0;

    foreach ($reviews as $review) {

        if ($page_no)
            $sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
        else
            $sr_no = 1;

        $class = "";
        if ($i % 2 != 0)
            $class = 'class="gr-row"';
        ?>
        <tr <?php echo($class); ?> id="<?php echo $review['Review']['id'] ?>">
            <td align="center"><?php echo($i++ + $sr_no); ?>. </td>
            <td align="left"><?php echo($review['Review']['title']); ?></td>
            <td align="left">
                <?php echo($review['Review']['type']); ?></td>
            <td align="left">
                <?php echo($review['School']['name']); ?></td>
            <td><center><?php echo $this->Html->image(('star-' . $review['Review']['rating'] . '.gif', array('alt' => '')); ?></center></td>	
    <td><?php echo($review['User']['firstname']); ?></td>	
    <td align="center"><a href="<?php echo($this->Html->url('/admin/reviews/review_edit/' . $review['Review']['id'])); ?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" /></td>

    <td><a class="changeStatus" path="<?php echo($this->Html->url('/admin/reviews/review_changeStatus/' . $review['Review']['id'])); ?>" id="<?php echo $review['Review']['id']; ?>"><?php
            if ($review['Review']['status'] == 0)
                echo "<img src='" . $this->Html->url('/img/unpublish.png') . "' border='0'>"; else
                echo "<img src='" . $this->Html->url('/img/publish.png') . "' border='0'>";
            ?></a></td>

    <td><?php echo $this->Html->link('<img src="' . $this->Html->url('/img/delete.gif') . '" />', array('action' => 'review_delete', $review['Review']['id']), array('class' => 'confirm_delete', 'id' => $review['Review']['id'], 'escape' => false)); ?>
        </tr>
        <?php
    }
    ?>

</table>


<?php
if (count($reviews) > 0) {
    /* Display paging info */
    ?>
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
    <?php
}
?>