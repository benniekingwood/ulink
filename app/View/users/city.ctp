<?php 
if(!empty($cities)){ 
    echo $this->Form->input('User.city_id',array('type'=>'select','label'=>'City','options'=>$cities,'empty'=>'Please Select'));
} else { 
    echo $this->Form->input('User.city_id',array('type'=>'select','label'=>'City','options'=>$cities,'empty'=>'No Cities Found'));
} 
?>