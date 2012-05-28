<?php echo ($javascript->link(array('jquery-common'))); //includes .JS files?>

<div id="ajax_msg"></div>

<table border="0" cellspacing="0" cellpadding="0" class="listing edit" >
			<tr class="ListHeading">
				<td width="10%" align="center">Sr. No.</th>
				<td width="20%" align="center">Firstname
					<span id="pagination">
					<?php
					
					$arrURL = explodecho("direction:", $_REQUEST['url']);
                                        
					$arrSort = explodecho("sort:", $_REQUEST['url']);
					if( $arrSort[1] != "" )
					{
						$arrSortSub = explodecho("/", $arrSort[1]);
						$arrSortSub = $arrSortSub[0];
					}
					
					if( $arrSortSub == "firstname" )
					{
						if( isset($arrURL['1']) )
						{
							if( $arrURL['1'] != "desc" )
								$sortingImage = "<img src='".$this->Html->url('/img/aroow2.gif')."' alt='Desc' title='Desc' />";
								
							else
								$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
						}
					}
					else
					{
						$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
					}

					?>
					<?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'firstname');?>
					</span>
				</th>
					<td width="20%" align="center">Last Name
					<span id="pagination">
					<?php
					
					$arrURL = explodecho("direction:", $_REQUEST['url']);
                                        
					$arrSort = explodecho("sort:", $_REQUEST['url']);
					if( $arrSort[1] != "" )
					{
						$arrSortSub = explodecho("/", $arrSort[1]);
						$arrSortSub = $arrSortSub[0];
					}
					
					if( $arrSortSub == "lastname" )
					{
						if( isset($arrURL['1']) )
						{
							if( $arrURL['1'] != "desc" )
								$sortingImage = "<img src='".$this->Html->url('/img/aroow2.gif')."' alt='Desc' title='Desc' />";
								
							else
								$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
								
						}
					}
					else
					{
						$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
					}

					?>
					<?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'lastname');?>
					</span>
				</th>
				
				<td width="20%" align="center">Email
					<span id="pagination">
					<?php
					
					$arrURL = explodecho("direction:", $_REQUEST['url']);
                                        
					$arrSort = explodecho("sort:", $_REQUEST['url']);
					if( $arrSort[1] != "" )
					{
						$arrSortSub = explodecho("/", $arrSort[1]);
						$arrSortSub = $arrSortSub[0];
					}
					
					if( $arrSortSub == "email" )
					{
						if( isset($arrURL['1']) )
						{
							if( $arrURL['1'] != "desc" )
								$sortingImage = "<img src='".$this->Html->url('/img/aroow2.gif')."' alt='Desc' title='Desc' />";
								
							else
								$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
								
						}
					}
					else
					{
						$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
					}

					?>
					<?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'email');?>
					</span>
				</th>
				
                <td width="20%" align="center">Active/In active
					<span id="pagination">
					<?php
					
					$arrURL = explodecho("direction:", $_REQUEST['url']);
                                        
					$arrSort = explodecho("sort:", $_REQUEST['url']);
					if( $arrSort[1] != "" )
					{
						$arrSortSub = explodecho("/", $arrSort[1]);
						$arrSortSub = $arrSortSub[0];
					}
					
					if( $arrSortSub == "activation" )
					{
						if( isset($arrURL['1']) )
						{
							if( $arrURL['1'] != "desc" )
								$sortingImage = "<img src='".$this->Html->url('/img/aroow2.gif')."' alt='Desc' title='Desc' />";
								
							else
								$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
								
						}
					}
					else
					{
						$sortingImage = "<img src='".$this->Html->url('/img/aroow1.gif')."' alt='Asc' title='Asc' />";
					}

					?>
					<?php echo $paginator->sort(html_entity_decodecho($sortingImage), 'activation');?>
					</span>
				</th>
				
				
                
                
                
				<td width="10%" align="center">Edit</th>
				
				<td width="10%" align="center">Delete</th>
			</tr>
		<?php
		
			$i = 0;
                         
			foreach( $users as $user )
			{ 
				
				if( $page_no )
					$sr_no = ($page_no * $paginate_limit) - $paginate_limit + 1;
				else
					$sr_no = 1;
				
				$class = "";
				if( $i%2 != 0 )
					$class = 'class="gr-row"';
				?>
				<tr <?php echo($class); ?> id="<?php echo $user['User']['id'] ?>">
					<td align="center"><?php echo($i++ + $sr_no ); ?>. </td>
					<td align="left"><?php echo($user['User']['firstname']); ?></td>
					<td align="left">
					<?php echo($user['User']['lastname']); ?></td>
					<td align="left">
					<?php echo($user['User']['email']); ?></td>
							
					<td><a class="changeStatus" path="<?php echo($this->Html->url('/admin/users/user_changeStatus/'.$user['User']['id'])); ?>" id="<?php echo $user['User']['id'];?>"><?php if($user['User']['activation']==0) echo "<img src='".$this->Html->url('/img/unpublish.png')."' border='0'>"; else echo "<img src='".$this->Html->url('/img/publish.png')."' border='0'>";?></a></td>
                    
                    <td align="center"><a href="<?php echo($this->Html->url('/admin/users/user_edit/'.$user['User']['id']));?>"><img src="<?php echo($this->Html->url('/img/edit-icon.png')); ?>" /></td>
					
					<td><?php echo $this->Html->link('<img src="'.$this->Html->url('/img/delete.gif').'" />',array('action'=>'user_delete',$user['User']['id']),array('class'=>'confirm_delete','id'=>$user['User']['id'],'escape'=>false));?>
				</tr>
				<?php
			}
		?>
		
		</table>


		<?php
		if ( count($users)>0 ) {
		     /* Display paging info */
		?>
<div id="pagination">		
		<div class="bottom-text">		
		<?php
		
		//      echo $paginator->prev();
		//      echo $paginator->numbers(array('separator'=>' - '));
		//      echo $paginator->next();

		      echo $paginator->first("<<", array('class'=>'footer_nav'));
		      echo '&nbsp;&nbsp;';
		      echo $paginator->prev("<", array('class'=>'footer_nav'));
			  echo '&nbsp;&nbsp;'; 
		      echo $paginator->numbers(array('separator'=>' | '));
			  echo '&nbsp;&nbsp;'; 
		      echo $paginator->next(">", array('class'=>'footer_nav'));
		      echo '&nbsp;&nbsp;';
		      echo $paginator->last(">>", array('class'=>'footer_nav'));
		
		?>
		</div>

</div>
		<?php
		}
		?> 

