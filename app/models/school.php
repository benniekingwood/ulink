<?php
/**
 * Model class for the Schools
 *
 */
class School extends AppModel {

    var $name = 'School';
    var $hasMany = array('Review', 'Image');
    var $belongsTo = array('Country', 'State', 'City');
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Name should not be empty.'
        ),
        'description' => array(
            'rule' => 'notEmpty',
            'message' => 'Description should not be empty.'
        ),
         'short_description' => array(
            'rule' => 'notEmpty',
            'message' => 'Short Description should not be empty.'
        ),
        'attendence' => array(
            'rule' => 'notEmpty',
            'message' => 'Attendence should not be empty.'
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'message' => 'Address should not be empty.'
        ),
        'zipcode' => array(
            'rule' => 'notEmpty',
            'message' => 'Zip code should not be empty.'
        ),
        'year' => array(
            'rule' => 'notEmpty',
            'message' => 'Year should not be empty.'
        ),
        'school_id' => array(
            'rule' => 'notEmpty',
            'message' => 'School should not be empty.'
        ),
        'domain' => array(
            'rule' => 'notEmpty',
            'message' => 'Domain should not be empty.'
        ),
        'country_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Country should not be empty.'
        ),
        'longitude' => array(
            'rule' => 'notEmpty',
            'message' => 'Longitude should not be empty.'
        ),
        'latitude' => array(
            'rule' => 'notEmpty',
            'message' => 'Latitude should not be empty.'
        )
    );

}

?>
