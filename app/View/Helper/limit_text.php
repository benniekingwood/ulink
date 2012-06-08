<?php 
class LimitTextHelper extends AppHelper{ 
	
	public function showText ($text=null,$length=8,$showDots=true,$cutFirstWord=true ) {
		$textArr	=	explode(' ',$text);
		if($showDots){
			$dotString	=	'...';
		}else{
			$dotString	=	'';
		}
		
		if($length==0){
			echo ucfirst($text);
		}else{
			if(!$cutFirstWord && strlen($textArr[0])>$length ){
				echo ucfirst($textArr[0]).$dotString;	
			}elseif(strlen($textArr[0])>$length){
				echo ucfirst(substr($textArr[0],0,$length)).$dotString;	
			}else{
				if(strlen($text)>$length){
					$newText	=	substr($text,0,$length);
					$newText 	= 	substr($newText,0,strrpos($newText," "));
					echo ucfirst($newText).$dotString;
				}else{
					echo ucfirst($text);
				}
			}
		}	
	}//eof
			
}
?>