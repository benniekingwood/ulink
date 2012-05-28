<?php 
class Review extends AppModel {
    var $name        = 'Reviews';
    var $belongsTo = array(
        'School' => array(
            'className'    => 'School',
            'foreignKey'    => 'school_id'
        )
        ,
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        )
    );
}
?>