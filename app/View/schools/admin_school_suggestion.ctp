<?php echo $javascript->link(array('jquery-1.4.2.min.js')); ?>
<?php echo $javascript->link(array('jquery-common.js')); ?>
<?php echo $javascript->link(array('tableSort.js')); ?>

<script type="text/javascript">
 				 
    $(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 

</script> 
<div id="ajax_msg"></div>
<div id="suggestionList">
    <table border="1" cellpadding="0" cellspacing="0" width="99%" id="myTable">
        <thead> 
        <td><center><b>S.No</b></center></td>
        <th><b>Name</b></th>
        <th><b>Attendence</b></th>
        <th><b>Address</b></th>
        <td><center><b>Delete</b></center></td>
        </thead>
        <?php $row = 0;
        foreach ($Suggestion as $suggestion) {
            $row++; ?>
            <tr style='background-color:yellow;' id="<?php echo $suggestion['Suggestion']['id'] ?>">    
                <td><?php echo $row; ?></td>
                <td><?php echo $suggestion['Suggestion']['name']; ?></td>
                <td><?php echo $suggestion['Suggestion']['attendence']; ?></td>
                <td><?php echo $suggestion['Suggestion']['address']; ?></td>
                <td><?php echo $this->Html->link('Delete', array('action' => 'suggestion_delete', $suggestion['Suggestion']['id']), array('class' => 'confirm_delete', 'id' => $suggestion['Suggestion']['id'])); ?></td>        
            </tr>
<?php } ?>
    </table>

    <div id="pagination">
        <?php
        /* echo $paginator->prev(); 
          echo $paginator->numbers(array('separator'=>' - '));
          echo $paginator->next(); */
        ?>
    </div>	
    <div><a href="<?php echo($this->Html->url('/admin/admins/index/')); ?>">Back</a><br/>
    </div>
</div>