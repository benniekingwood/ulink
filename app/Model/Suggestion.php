<?php

class Suggestion extends AppModel {

    var $name = 'Suggestion';
    var $uses = array('Suggestion');
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'School name should not be empty.'
        ),
        'attendence ' => array(
            'rule' => 'notEmpty',
            'message' => 'Attendence should not be empty.'
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'message' => 'Address should not be empty.'
        )
    );

}

?>