<?php
/**
 * class for the uLink articles
 */
class Article extends AppModel
{
    var $name = 'Article';
    var $uses = array('Article');

    var $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Title should not be empty.'
        ),
        'description' => array(
            'rule' => 'notEmpty',
            'message' => 'Description should not be empty.'
        ),
        'status' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select status.'
        )
    );
}

?>