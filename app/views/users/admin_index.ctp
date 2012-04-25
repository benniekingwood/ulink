<script>
/**
 * Loads in a URL into a specified divName, and applies the function to
 * all the links inside the pagination div of that page (to preserve the ajax-request)
 * @param string href The URL of the page to load
 * @param string divName The name of the DOM-element to load the data into
 * @return boolean False To prevent the links from doing anything on their own.
 */
function loadPiece(href,divName) {    
    $(divName).load(href, {}, function(){
        var divPaginationLinks = divName+" #pagination a";
        $(divPaginationLinks).click(function() {     
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
        });
    });
} 
</script>
<div>

     <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
	     <td><b>S.No</b></td>
		 <td><b>First Name</b></td>
		 <td><b>Last Name</b></td>
		 <td><b>E-Mail</b></td>
		 <td><b>Edit</b></td>
		 <td><b>Remove</b></td>
	     </tr>
	     <?php $row =0 ; foreach($User as $user){ $row++;?>
	     <tr>    
                 <td><?php echo $row;?></td>
		 <td><?php echo $user['User']['firstname'];?></td>
		 <td><?php echo $user['User']['lastname'];?></td>
		 <td><?php echo $user['User']['email'];?></td>
		 <td><a href="<?php e($html->url('/admin/users/user_edit/'.$user['User']['id'])); ?>">Edit</a></td>
		 <td><a href="<?php e($html->url('/admin/users/user_delete/'.$user['User']['id'])); ?>">Remove</a></td>                 
              </tr>
		<?php } ?>
     </table>

  
    <script type="text/javascript">
          $(document).ready(function() {
            loadPiece("<?php echo $html->url(array('controller'=>'Users','action'=>'admin_index'));?>","#imageList");
             });
    </script>
   <div id="imageList">

   </div> 

</div>