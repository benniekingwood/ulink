<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: Mar 22, 2012
 * Description: This class is the User model object
 ********************************************************************************/
class User extends AppModel {

    var $name = 'Users';
    var $uses = array('User');
    var $belongsTo = array(
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        )
        ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        )
        ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id'
        )
        ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id'
        )
    );
    var $validate = array(
        'username' => array(
            'notempty' => array(
                'rule' => array('minLength', 1),
                'allowEmpty' => false,
                'message' => 'Please enter a username.'
            ),
            'unique' => array(
                'rule' => array('checkUnique', 'username'),
                'message' => 'That username is already being used, please try another.'
            )
        ),
        'password' => array(
            'rule' => array('minLength', 6),
            'message' => 'Password must be at least six characters long.'
        ),
        'school_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a school.'
        ),
        'school_status' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select your school status.'
        ),
        'email' => array(
            'emailRule-1' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter an email address.',
                'last' => false
            ),
            'emailRule-2' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            ),
            'unique' => array(
                'rule' => array('checkUnique', 'email'),
                'message' => 'The email address is already in use, you might have already signed up.'
            )
        )
    );

    /**
     * This method verifies that the confirmation and
     * regular password fields are matching
     *
     * @param $data
     */
    function confirmPassword($data) {
        $retVal = false;
        $value = $_REQUEST['data']['User']['confirm_password'];
        if ($value == $_REQUEST['data']['User']['password']) {
            $retVal = true;
        }
    }

    /**
     * This method verifies that the passed in field is unique
     * @param $data
     * @param $fieldName
     * @return bool
     */
    function checkUnique($data, $fieldName) {
        $valid = false;
        if (isset($fieldName) && $this->hasField($fieldName)) {
            $valid = $this->isUnique(array($fieldName => $data));
        }
        return $valid;
    }
}
?>