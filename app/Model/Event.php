<?php
class Event extends AppModel {
        var $name = 'Event';
        var $primaryKey = '_id';
        var $useDbConfig = 'mongo';

         /*function schema() {
        $this->_schema = array(
            '_id' => array('type' => 'integer', 'primary' => true, 'length' => 40),
            'firstName' => array('type' => 'string'),
                        'lastName' => array('type' => 'string'),
        );
        return $this->_schema;
    }*/


}
?>