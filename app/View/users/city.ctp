<?php 
if(!empty($cities)){ 
    echo $form->input('User.city_id',array('type'=>'select','label'=>'City','options'=>$cities,'empty'=>'Please Select'));
} else { 
    echo $form->input('User.city_id',array('type'=>'select','label'=>'City','options'=>$cities,'empty'=>'No Cities Found'));
} 
?>