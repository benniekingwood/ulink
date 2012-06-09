<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: Mar 22, 2012
 * Description: This class handles all the User object business logic
 ********************************************************************************/
class UsersController extends AppController {

    var $name = 'Users';
    var $uses = array('User', 'Country', 'State', 'City', 'School', 'Review', 'Domain');
    var $helpers = array('Html', 'Form', 'Js');
    var $components = array('Email', 'Auth', 'Session', 'RequestHandler');
    var $paginate_limit = '20';
    var $paginate_limit_front = '10';
    var $paginate_limit_front_compact = '10';
    var $paginate_limit_admin = '20';
    var $paginate = "";

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    /**
     * Handles the login action
     */
    function login() {
        if (isset($_POST['username'])) {
            $this->autoRender = false;
            $this->layout = null;
        } else {
            $this->layout = "v2_no_login_header";
        }
        // if the user is already authenticated or there is post data...
        if ($this->Auth->user() || (isset($_POST['username']) && isset($_POST['password']))) {
            // if there is data set from the form
            if (!empty($this->request->data)) {
                // if "remember_me" was not clicked, removed any user data from the Cookie
                if (empty($this->request->data['User']['remember_me'])) {
                    $this->Cookie->del('User');
                } else {
                    // add the user info as a Cookie for 2 weeks
                    $cookie = array();
                    $cookie['username'] = $this->request->data['User']['username'];
                    $cookie['password'] = $this->request->data['User']['password'];
                    $this->Cookie->write('User', $cookie, true, '+2 weeks');
                }
                // remove the remember_me form data from the data object
                unset($this->request->data['User']['remember_me']);
            }

            // grab the user activation status based on the passed in username/password
            $userActCheck = $this->User->find('all', array('conditions' => 'User.username="' . $_POST['username'] . '"', 'fields' => array('User.activation','User.deactive')));


            // authenticate the user
            $getInfo = $this->Auth->user();
	
            // if a user was retrieved...success
            if ($getInfo) {
                // if the user was deactivated, reactivate them
                if ($userActCheck[0]['User']['deactive'] == "1") {
                    $this->User->id = $getInfo['User']['id'];
                    $this->User->saveField('deactive', '0');
                }

				$this->set('username',$getInfo->username);
                if (!empty($_POST['loginMain'])) {
                    echo "main";
                }  else {
                    echo "yes";
                }
            } else if ($userActCheck[0]['User']['activation'] == "0") {    // user is not active
                echo "std";
            } else {   // finally it must be an invalid login
                echo "in-valid";
            }
        }
        
    } // login

    /**
     * Handles the logout action
     */
    function logout() {
        $this->layout = "v2";
        $this->redirect($this->Auth->logout());
    } // logout

    /**
     * Handles the forgot password action.  This will verify that
     * the inputted user email exists, and will
     * reset the password for that user and send them an email.
     */
    function forgotpassword() {
        $this->pageTitle = 'Forgot Password';
        $this->layout = "v2";
        $this->set('currentPageHeading', 'Forgot your password?');

        // if the user is already authenticated, redirect to homepage
        if ($this->Auth->user()) {
            $this->redirect($this->Auth->redirect());
            exit();
        }

        // if there is form data, continue with the process
        if (!empty($this->request->data)) {

            // if the email was provided
            if (!empty($this->request->data['User']['email'])) {
                $useremail = $this->request->data['User']['email'];

                // grab the user from the db based on the passed in email
                $user = $this->User->find('all', array('conditions' => 'User.email="' . $useremail . '"'));

                // if a user was successfully retrieved
                if ($user) {
                    // grab a random string for the auto password
                    $autopass = UsersController::getRandomString();

                    // set password and user information to be saved in db
                    $this->request->data['User']['password2hashed'] = $this->Auth->password($autopass);
                    $this->request->data['User']['password'] = $this->request->data['User']['password2hashed'];
                    // remove the updated autopass from the user object so that it is not saved in the db
                    unset($this->request->data['User']['password2hashed']);

                    // set the user id, username, and autopass status to be saved
                    $this->User->id = $user[0]['User']['id'];
                    $this->request->data['User']['username'] = $user[0]['User']['username'];
                    $this->request->data['User']['autopass'] = 1;

                    // if saving the user
                    if ($this->User->save($this->request->data)) {
                        $this->Email->to = $useremail;
                        $this->Email->subject = 'Your uLink temporary password';
                        $this->Email->replyTo = 'noreply@theulink.com';
                        $this->Email->from = 'uLink <noreply@theulink.com>';
                        $this->Email->sendAs = 'html';
                        $this->Email->template = 'forgotpassword';
                        /* SMTP Options */
                        $this->Email->smtpOptions = array('port' => '587',
                            'timeout' => '30',
                            'host' => 'mail.theulink.com',
                            'username' => 'bennie.kingwood@theulink.com',
                            'password' => 'iPhone1983');
                        /* Set delivery method */
                        $this->Email->delivery = 'smtp';

                        // if the email was sent successfully
                        if ($this->Email->send()) {
                            $this->Session->setFlash('Your new password was sent to ' . $useremail . '.');

                            // TODO: here have the same page just show a panel with a green check box 
                            // saying the message above about the new password being sent
                            //$this->redirect(array('controller' => 'users', 'action' => 'login'));
                        } else {
                            $this->set('forgotError', 'true');
                            $this->Session->setFlash('There was a problem sending the password email. Please try again later, or contact help@theulink.com', 'default', array('class' => 'help-inline error'));
                        }
                    } else {  // saving of the user failed
                        $this->set('forgotError', 'true');

                        $this->Session->setFlash('There was an issue with your account,  please try again later.');
                        $this->request->data = null;
                    }
                } else {  // no user was retrieved for that specified email
                    $this->set('forgotError', 'true');
                    $this->Session->setFlash('There is no uLink account associated with this email, please try another.', 'default', array('class' => 'help-inline error'));
                   // $this->redirect(array('controller' => 'users', 'action' => 'forgotpassword'));
                }
            } else {  // no email was provided for the user
                $this->set('forgotError', 'true');
                $this->Session->setFlash('Please enter your email address.',  'default', array('class' => 'help-inline error'));
               // $this->redirect(array('controller' => 'users', 'action' => 'forgotpassword'));
            }
        }
    } // forgotpassword

    /**
     * This function will handle the main registration of new users
     * to the site.  If an id is passed in, we know that this
     * is for facebook users.
     *
     * @param null $id
     */
    function register($id = null) {
        $this->pageTitle = 'Sign up with uLink';
        $this->layout = "v2_no_login_header";
        $this->set('currentPageHeading', 'Join uLink');

        /*
         * If an id was passed in, it will be for fb.  Grab
         * the first user that has the passed in fb id, and
         * set it to be used in the view.
         */
        if (isset($id)) {
            $user_record =
                $this->User->find('first', array(
                    'conditions' => array('fbid' => $id),
                    'fields' => array('User.id'),
                ));
            $this->set('id', $user_record['User']['id']);
        }

        // if there is data to be saved
        if (!empty($this->request->data)) {
            // check against the email here
            if ($this->emailExists($this->request->data['User']['email'])) {
                $this->Session->setFlash('Email already exists in uLink.  Please try another email address.');
            } else {
                // get the user's password
                $this->request->data['User']['password2hashed'] = $this->Auth->password($this->request->data['User']['password']);
                // create their activation key
                $this->request->data['User']['activation_key'] = String::uuid();

                // save the user
                if ($this->User->save($this->request->data)) {
                    // build an email to be sent to the user for account activation
                    $this->Email->to = $this->request->data['User']['email'];
                    $this->Email->subject = 'uLink Account Activation';
                    $this->Email->replyTo = 'noreply@theulink.com';
                    $this->Email->from = 'uLink <noreply@theulink.com>';
                    $this->Email->sendAs = 'html';
                    $this->Email->template = 'confirmation';
                    /* SMTP Options */
                    $this->Email->smtpOptions = array('port' => '587',
                        'timeout' => '30',
                        'host' => 'mail.theulink.com',
                        'username' => 'bennie.kingwood@theulink.com',
                        'password' => 'iPhone1983');
                    /* Set delivery method */
                    $this->Email->delivery = 'smtp';

                    // now set various info to be used in the view
                    $this->set('name', $this->request->data['User']['username']);
                    $this->set('server_name', $_SERVER['SERVER_NAME']);
                    if (isset($this->request->data['User']['id'])) {
                        $this->set('id', $this->request->data['User']['id']);
                    } else {
                        $this->set('id', $this->User->getLastInsertID());
                    }
                    $this->set('code', $this->request->data['User']['activation_key']);

                    // send off the email, and redirect to the successful signup page
                    if ($this->Email->send()) {
                        $this->redirect(array('controller' => 'pages', 'action' => 'success'));
                    } else {
                        $this->User->del($this->User->getLastInsertID());
                        $this->Session->setFlash('There was a problem sending the confirmation email. Please try again, or contact help@thelink.com.');
                    }
                } else {  // there was an error when trying to save the user
                    if($this->User->invalidFields() != null) {
                        $errors = '';
                        foreach($this->User->invalidFields() as $key => $value) {
                            $errors .= $value . '<br />';
                        }
                        $this->Session->setFlash($errors);
                    } else {
                        $this->Session->setFlash('Opps, there was a problem getting your account setup. Please try again, or contact help@theulink.com.');
                    }
                }
            }
        }

        $schools = array();

        // grab all of the schools from the db
        $data_schools = $this->School->find('all');

        // use all the schools in the system  for the form
        foreach ($data_schools as $school) {
            $schools[$school['School']['id']] = $school['School']['name'];
        }

        // set various data to be used in the register view
        $this->set('schools', $schools);
    }  // register

    /**
     *
     */
    function message() {
        $this->autoRender = false;
        $this->layout = null;
    }

    /**
     * @param null $user_id
     * @param null $code
     */
    function confirm($user_id = null, $code = null) {
        $this->pageTitle = 'Account confirmation';
        $this->layout = "v2";

        if (empty($user_id) || empty($code)) {
            $this->set('confirmed', 0);
            $this->render();
        }

        $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'User.activation_key' => $code)
            )
        );
        if (empty($user)) {
            $this->set('confirmed', 0);
        } else {
            $this->User->id = $user_id;
            $this->User->saveField('activation', '1');

            // setting it to blank so that key can be access only once
            $this->User->saveField('activation_key', '');
            $this->set('confirmed', 1); // represents success
        }
    }  // confirm

    /**
     * This function will delete the image
     * from the user's profile
     *
     * @param null $image_url
     */
    function removeImage($image_url = null) {
        // grab the current logged in user
        $sessVar = $this->Auth->user();

        // create a data object with the user's info
        $data = array(
            'User' => array(
                'id' => $sessVar['User']['id'],
                'username' => $sessVar['User']['username'],
                'image_url' => ""
            )
        );

        // update the user's profile in the db
        if ($this->User->save($data)) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            unlink("" . WWW_ROOT . "/img/files/users/" . $image_url);
            echo "true";
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
        }
    } // removeImage

    /**
     * Password page loader
     */
    function password() {

        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = "v2";
        $this->pageTitle = 'Your college everything.';
    }

    /**
     * This function will update the password
     * in the user's profile
     */
    function updatePassword() {
        $validateError = 0;

        // if the user is changing their password, perform validation
        if (!empty($this->request->data['User']['oldpass'])) {
            // if the user is changing their password make sure the confirm matches the new
            if (!empty($this->request->data['User']['newpass'])) {
                if ($this->request->data['User']['newpass'] != $this->request->data['User']['newconfirmpass']) {
                    $this->User->invalidate('newconfirmpass', "The verify password does not match the new password.");
                    $validateError++;
                }
            }
            if($validateError == 0) {
                $cuser = $this->User->find('first', array('conditions' => 'User.id=' . $this->Auth->user('id'),
                    'fields' => array('User.password')));
                if ($this->Auth->password($this->request->data['User']['oldpass']) == $cuser['User']['password']) {
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newconfirmpass']);
                    $this->request->data['User']['autopass'] = 0;
                } else {
                    $this->User->invalidate('oldpass', 'The current password entered was incorrect, please try again.');
                    $validateError++;
                }
            }
        }

        // grab the current logged in user
        $sessVar = $this->Auth->user();

        // create a data object with the user's info
        $data = array(
            'User' => array(
                'id' => $sessVar['User']['id'],
                'username' => $sessVar['User']['username']
            )
        );

        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;

        // check for validation errors
        if($validateError > 0) {
            if($this->User->invalidFields() != null) {
                $errors = '';
                foreach($this->User->invalidFields() as $key => $value) {
                    $errors .= $value . '<br />';
                }
                $this->set('errors', $errors);
            }
            echo $errors;
        }  else {
            // update the user's profile in the db
            if ($this->User->save($data)) {
                echo "true";
            } else {
                echo "There was an issue saving your password.  Please try again, or contact help@theulink.com";
            }
        }

    } // updatePassword

    /**
     * This function will show the user's information
     * to the client based on the passed in user id
     *
     * @param null $id
     */
    function viewprofile($id = null) {
        $this->layout = null;
        // if the user is not logged in, redirect them to the login screen
        if (!$this->Auth->user()) {
            $this->Session->setFlash('Please login to gain full access to uLink.');
            $this->redirect(array('action' => 'login'));
        }
        $this->chkAutopass();
        // grab the user from the db
        $user = $this->User->find('User.id=' . $id);
        echo json_encode($user);
        exit;
    }

    /**
     * This function will check if the email exists or not
     * @param $email
     * @return bool
     */
    function emailExists($email) {
        $chkuserExist = $this->User->find('first', array('conditions' => 'User.email=' . "'$email'" . ''));
        return !empty($chkuserExist);
    }

    /**
     * This function will handle the user
     * updating their profile
     */
    function index() {
        $this->pageTitle = 'Your college everything';
        $this->layout = "v2";

        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }
        $validateError = 0;
        // grab the user off the session
        $user = $this->Auth->user();
        // if their is no data set, the client is viewing the profile
        if (empty($this->request->data)) {

            // grad the user off the session
            $this->request->data = $this->User->read('', $user['User']['id']);

            // build up the schools data
            $schools = array();
            $data_schools = $this->School->find('all');

            foreach ($data_schools as $school) {
                $schools[$school['School']['id']] = $school['School']['name'];
            }

            // grab the years starting from 1960
            for ($i = 1960; $i <= date("Y") + 10; $i++) {
                $years[$i] = $i;
            }

            $this->set('schools_id', $user['School']['school_id']);
            $this->set('schools', $schools);
            $this->set('years_id', $user['User']['year']);
            $this->set('years', $years);
            $this->set('status', $user['User']['school_status']);
            $this->set('school_status', $status);
        } else { // user hit the "update" button

            // set the saved data on the user
            $this->User->set($this->request->data);
            // validate the user data
            $this->User->validate();

            // validate the first name
            if (empty($this->request->data['User']['firstname'])) {
                $this->User->invalidate('firstname', 'Please enter your first name');
                $validateError++;
            }
            // validate teh last name
            if (empty($this->request->data['User']['lastname'])) {
                $this->User->invalidate('lastname', 'Please enter your last name');
                $validateError++;
            }
            // validate the graduation year
            if (empty($this->request->data['User']['year'])) {
                $this->User->invalidate('year', 'Please select your year of graduation');
                $validateError++;
            }
            // validate the school status
            if (empty($this->request->data['User']['school_status'])) {
                $this->User->invalidate('school_status', 'Please choose your school status');
                $validateError++;
            }
            // validate the email
            if ($this->emailExists($this->request->data['User']['email'])) {
                $this->User->invalidate('email', 'Email already exists in uLink.  Please submit another.');
                $validateError++;
            }

            // if there are no validation errors
            if (empty($this->User->validationErrors)) {

                // upload the users picture
                $fileOK = $this->uploadFiles('img/files/users', $this->request->data['User']['file']);
                if (array_key_exists('urls', $fileOK)) {
                    // save the url in the form data
                    $this->request->data['User']['image_url'] = $fileOK['urls'][0];
                }

                // update the user in the db
                if ($this->User->save($this->request->data)) {
                    $this->Auth->login($this->User->read());
                    $this->Session->setFlash('<span class="profile-success">Your profile has been updated.</span>');
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                if($this->User->invalidFields() != null) {
                    $errors = '';
                    foreach($this->User->invalidFields() as $key => $value) {
                        $errors .= $value . '<br />';
                    }
                    $this->set('errors', $errors);
                }
            }

            // grab the schools, and years for form display
            $schools = array();
            $data_schools = $this->School->find('all');

            foreach ($data_schools as $school) {
                $schools[$school['School']['id']] = $school['School']['name'];
            }

            for ($i = 1960; $i <= date("Y") + 10; $i++) {
                $years[$i] = $i;
            }

            $this->set('schools_id', $user['School']['school_id']);
            $this->set('schools', $schools);
            $this->set('years_id', $user['User']['year']);
            $this->set('years', $years);
            $this->set('status', $user['User']['school_status']);
            $this->set('school_status', $status);
        }
    }

    function log($msg, $type = LOG_ERROR) {
        return parent::log($msg, $type);
    } // log

    /**
     * Deactivate page loader
     */
    public function deactivate() {

        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = "v2_no_login_header";
        $this->pageTitle = 'Your college everything.';
    }  // deactivate

    /**
     * This function will deactivate the
     * user's account
     */
    public function deactivateaccount() {
        // grab the current logged in user
        $sessVar = $this->Auth->user();

        // create a data object with the user's info
        $data = array('User' => array('id' => $sessVar['User']['id'], 'username' => $sessVar['User']['username'], 'deactive' => 1));

        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;

        // update the user's profile in the db
        if ($this->User->save($data)) {
            $this->Auth->logout();
            echo "true";
        } else {
            echo "There was an issue deactivating your account.  Please try again, or contact help@theulink.com";
        }
    }  // deactivateaccount

    function admin_index()
    {
        $this->redirect(array('action' => 'user_index'));
    }

    function ajax_pagination()
    {
        $data = $this->User->find('all');
        $this->set('user', $data);
    }

    function admin_user_index()
    {

        $this->layout = "admin_dashboard";

        // set/get search to session

        $this->paginate = array(
            'limit' => $this->paginate_limit_front
        );

        if (isset($this->request->data['User']['searchText'])) {
            $this->Session->write('advancedUserSearch', $this->request->data['User']['searchText']);
            $searchText = $this->request->data['User']['searchText'];
        } elseif ($this->Session->check('advancedUserSearch')) {

            if (isset($this->request->params['named']['page'])) {
                $searchText = $this->request->data['AdvancedSearch'] = $this->Session->read('advancedUserSearch');
            } else {
                $this->Session->delete('advancedUserSearch');
                $searchText = $this->request->data['User']['searchText'];
            }
        } else {

            $searchText = $this->request->data['User']['searchText'];
        }

        if (empty($this->request->data)) {
            $this->paginate = array('order' => array('User.id DESC'));
            $user_listing = $this->paginate('User');
        } else {

            $user_listing = $this->paginate = array('conditions' => array('or' => array(
                'User.firstname LIKE' => '%' . $searchText . '%'
            )
            ),
                'fields' => array('User.id', 'User.firstname', 'User.lastname', 'User.email', 'User.activation'),
                'limit' => $this->paginate_limit_front,
                'order' => array('User.id DESC')
            );


            $user_listing = $this->paginate('User');
        }

        $page_no_arr = explode(":", $_REQUEST['url']);
        if (isset($page_no_arr[1]))
            $this->set("page_no", $page_no_arr[1]);

        $this->set('User', $user_listing);
        $this->set("paginate_limit", $this->paginate_limit_front);
    }

    function admin_listing_ajax()
    {
        $this->set_paginate_limit(); // Setting Paginate Limit 

        $this->setLayout = null;
        Configure::write('debug', 0);
        $data = $this->paginate();
        $this->set("users", $data);
        $this->set("paginate_limit", $this->paginate_limit);

        // Finding Page No (for Sr. No.)
        $page_no_arr = explode(":", $_REQUEST['url']);

        $this->set("page_no", $page_no_arr[1]);
    }

    function set_paginate_limit()
    {

        $this->paginate = array('order' => array('User.id'), 'limit' => $this->paginate_limit);
    }

    function admin_user_add()
    {

        $this->layout = "admin_dashboard";
        if (!empty($this->request->data)) {
            $this->request->data['User']['password2hashed'] = $this->Auth->password($this->request->data['User']['password']);
            $this->request->data['User']['activation_key'] = String::uuid();
            $this->User->create();

            $fileOK = $this->uploadFiles('img/files/users', $this->request->data['User']['file']);

            if (array_key_exists('urls', $fileOK)) {
                // save the url in the form data
                $this->request->data['User']['image_url'] = $fileOK['urls'][0];
            }
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $this->User->save($this->request->data);
                $this->Session->setFlash('New User is added');
                $this->redirect(array('action' => 'user_index'));
            } else {
                $this->Session->setFlash('There was an error Adding User. Please, try again.');
                $this->request->data = null;
            }
        } else {

        }
        $schools = array();
        $countries = array();
        $states = array();
        $cities = array();

        $data_countries = $this->Country->find('all');
        $data_states = $this->State->find('all');
        $data_cities = $this->City->find('all');
        $data_schools = $this->School->find('all');

        foreach ($data_countries as $country) {
            $countries[$country['Country']['id']] = $country['Country']['countries_name'];
        }

        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }

        foreach ($data_schools as $school) {
            $schools [$school['School']['id']] = $school['School']['name'];
        }

        for ($i = 1960; $i <= date("Y") + 10; $i++) {
            $years[$i] = $i;
        }

        $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
        $this->set('years', $years);
        $this->set('schools', $schools);
    }

//ef

    function admin_user_edit($id = null)
    {
        $this->layout = "admin_dashboard";
        $user = $this->User->find('User.id=' . $id);

        if (empty($this->request->data)) {
            $this->request->data = $this->User->read('', $id);
        } else {
            $fileOK = $this->uploadFiles('img/files/users', $this->request->data['User']['file']);
            if (array_key_exists('urls', $fileOK)) {
                // save the url in the form data
                $this->request->data['User']['image_url'] = $fileOK['urls'][0];
            }
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The User has been updated.');
                $this->redirect(array('action' => 'user_index'));
            }
        }
        $countries = array();
        $states = array();
        $cities = array();
        $schools = array();
        $data_countries = $this->Country->find('all');
        $data_states = $this->State->find('all');
        $data_cities = $this->City->find('all');
        $data_schools = $this->School->find('all');

        foreach ($data_countries as $country) {
            $countries[$country['Country']['id']] = $country['Country']['countries_name'];
        }
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }
        foreach ($data_schools as $school) {
            $schools[$school['School']['id']] = $school['School']['name'];
        }

        for ($i = 1960; $i <= date("Y") + 10; $i++) {
            $years[$i] = $i;
        }

        $this->set('countries', $countries);
        $this->set('countries_id', $user['User']['country_id']);
        $this->set('states', $states);
        $this->set('states_id', $user['User']['state_id']);
        $this->set('cities', $cities);
        $this->set('cities_id', $user['User']['city_id']);
        $this->set('years', $years);
        $this->set('schools_id', $user['User']['school_id']);
        $this->set('schools', $schools);
        $this->set('years_id', $user['User']['year']);
        $this->set('username', $user['User']['username']);

        //	die('xx');
    }

//ef
    // to delete a user from ajax

    function admin_user_delete($id = null)
    {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;
        // check id is valid
        if ($id != null && is_numeric($id)) {
            // get the Item
            $data_del = $this->User->read(null, $id);

            // check Item is valid
            if (!empty($data_del)) {
                // try deleting the item
                if ($this->User->delete($id)) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        } else {
            echo "false";
        }
    }

//ef

    function admin_user_state($id = null)
    {
        $this->layout = null;
        $data_states = $this->State->find('all', array('conditions' => 'State.country_id =' . $id . '',
                'order' => 'State.name ASC'
            )
        );

        $country = $id;
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        $this->set('states', $states);
    }

//ef

    function admin_user_city($id = null)
    {
        $this->layout = null;
        $data_cities = $this->City->find('all', array('conditions' => 'City.state_id =' . $id . '',
                'order' => 'City.name ASC'
            )
        );

        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }
        $this->set('cities', $cities);
    }

//ef

    /**
     * Get the state based on the passed in
     * country id
     * @param null $id
     */
    function state($id = null) {
        $this->layout = null;
        // grab the list of states by the country id
        $data_states = $this->State->find('all', array('conditions' => 'State.country_id =' . $id . '',
                'order' => 'State.name ASC'
            )
        );
        $country = $id;
        // build up the states list and set in view
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        $this->set('states', $states);
    }   // state

    /**
     * Get the states based on the country
     * code
     * @param null $code
     */
    function states($code = null) {
        $this->layout = null;
        // grab the list of states by the country code
        $data_states = $this->State->find('all', array('contain' => array (
            'Country' => array(
                'conditions' => array (
                    'countries_iso_code' => $code)))));
        $this->log('here', 'debug');

        // build up the states list and set in view
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
            $this->log($state['State']['name'], 'debug');
        }
        $this->set('states', $states);
    } // getStatesByCountryCode

    /**
     * Get the city based on the passed in
     * statid id
     * @param null $id
     */
    function city($id = null) {
        $this->layout = null;

        // grab the list of cities by the state id
        $data_cities = $this->City->find('all', array('conditions' => 'City.state_id =' . $id . '',
                'order' => 'City.name ASC'
            )
        );

        // build up the city list and set in view
        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }
        $this->set('cities', $cities);
    } // city

    /**
     * This function will delete the image
     * from the user's profile
     *
     * @param null $image_url
     */
    function delimage($image_url = null) {
        // grab the current logged in user
        $sessVar = $this->Auth->user();
        $school = $this->User->find('User.id=' . $sessVar['User']['id']);
        $data = array(
            'User' => array(
                'id' => $sessVar['User']['id'],
                'username' => $sessVar['User']['username'],
                'image_url' => ""
            )
        );

        if ($this->User->save($data)) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            unlink("" . WWW_ROOT . "/img/files/users/" . $image_url);
            echo "true";
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
        }
    } // delimage

    function admin_user_delimage($id = null, $image_url = null)
    {

        $user = $this->User->find('User.id=' . $id);
        $user['User']['username'];

        $data = array(
            'User' => array(
                'id' => $id,
                'username' => $user['User']['username'],
                'image_url' => ""
            )
        );
        if ($this->User->save($data)) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            unlink("" . WWW_ROOT . "/img/files/users/" . $image_url);
            echo "true";
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
        }
    }

//ef

    function checkuser($username = null)
    {
        $this->layout = null;
        $this->autoRender = false;

        $chkuser = $this->User->find('all', array('conditions' => 'User.username=' . "'$username'" . ''
            )
        );

        if (count($chkuser) == 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

//ef

    function admin_checkuser($username = null)
    {
        $this->layout = null;
        $this->autoRender = false;

        $chkuser = $this->User->find('all', array('conditions' => 'User.username=' . "'$username'" . ''
            )
        );

        if (count($chkuser) == 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

//ef

    function checkdomain()
    {


        $this->layout = null;
        $this->autoRender = false;
        $status = 0;

        $email = $_POST['data']['User']['email'];
        $schoolSelect = $_POST['school_id'];
        $schoolStatus = $_POST['school_status'];
        // $this->log('schoolstatus-' . $schoolStatus . '-', 'debug');


        /*  $chkuserExist = $this->User->find('first', array('conditions' => 'User.email=' . "'$email'" . ''
            )
        );*/

        /**
         * If the user doesn't exist AND
         * the user is not an Alumni, make
         * sure they have an approved emails domain for the school
         * in which they are registering.
         */
        // if (empty($chkuserExist)) {

        if ($schoolStatus != 'Alumni') {
            $this->log('here in checking out -', 'debug');
            $chkuser = $this->School->find('all', array('conditions' => 'School.id=' . $schoolSelect
                )
            );

            $domains = explode(',', $chkuser[0]['School']['domain']);
            foreach ($domains as $val) { //echo $val;
                $lookdomain = explode('.', $lookdomain = $val);
                /* 	echo "<pre>";
               print_r($lookdomain);
               exit('xx'); */
                if ((eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@" . $lookdomain[0] . "." . $lookdomain[1] . "$", $email))) {

                    $status = 1;
                    break;
                } else {

                    $status = 0;
                }
            }
            if ($status == 1) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            $this->log('it is an alumn, returing true', 'debug');
            echo "true";
        }
        //  } else {
        //     echo "false";
        //}
    }

//ef
    //function to check username
    function checkUsername()
    {
        $this->setLayout = null;
        Configure::write('debug', 0);


        $username = $_POST['data']['User']['username'];

        $userdetails = $this->User->find('count', array('conditions' => array('User.username' => $username)));


        if ($userdetails) {
            echo "false";
            exit();
        } else {
            echo "true";
            exit();
        }
    }

    //

    function admin_checkdomain($email = null, $schoolSelect = null)
    {


        $this->layout = null;
        $this->autoRender = false;
        $status = 0;


        $chkuserExist = $this->User->find('first', array('conditions' => 'User.email=' . "'$email'" . ''
            )
        );


        if (empty($chkuserExist)) {


            $chkuser = $this->School->find('all', array('conditions' => 'School.id=' . "'$schoolSelect'" . ''
                )
            );

            $domains = explode(',', $chkuser[0]['School']['domain']);
            foreach ($domains as $val) { //echo $val;
                $lookdomain = explode('.', $lookdomain = $val);
                if ((eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@" . $lookdomain[0] . "." . $lookdomain[1] . "$", $email))) {

                    $status = 1;
                    break;
                } else {

                    $status = 0;
                }
            }
            if ($status) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "2";
        }
    }

//ef
    // function to change the status of a user

    function admin_user_changeStatus($id = null)
    {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;

        $user = $this->User->find('first', array('conditions' => 'User.id=' . $id,
                'fields' => array('User.id', 'User.activation')
            )
        );

        if ($user['User']['activation']) {
            $newStatus = "0";
        } else {
            $newStatus = "1";
        }

        $data = array(
            'User' => array(
                'id' => $id,
                'activation' => $newStatus
            )
        );


        if ($this->User->save($data)) {
            echo $newStatus;
        } else {
            echo "2";
        }
    }

//ef

    function searchform()
    { // to display the ajax loaded search form
        $this->layout = null;
    }

// ef 
    ########################################### to do ajax pagination  

    function searchresults($page_no = '')
    {
        $this->layout = 'default1';
        $this->set("page_no", $page_no);

        if (isset($this->request->data['Map']['search'])) {
            $search_srting = $this->request->data['Map']['search'];
        } else if (isset($this->request->data['User']['search'])) {
            $search_srting = $this->request->data['User']['search'];
        } else if (isset($this->request->data['Review']['search'])) {
            $search_srting = $this->request->data['Review']['search'];
        }


        $this->set("search_srting", $search_srting);
        $this->set('type', 'Profiles');
        $this->set('actionType', 'searchresults');
        $this->set('createTypeForm', 'User');
        $this->set('currentPageHeading', 'Search Users');
    }

// ef   

    function search_ajax($search_srting = '')
    {

        $search_srting = str_replace("-", " ", $search_srting);
        $this->set_paginate_limit_search($search_srting); // Setting Paginate Limit 

        $this->layout = null;
        Configure::write('debug', 0);

        $data = $this->paginate();
        $this->set("serchResultsUsers", $data);

        $this->set("paginate_limit", $this->paginate_limit_front);

        // Finding Page No (for Sr. No.)
        $page_no_arr = explode(":", $_REQUEST['url']);
        $this->set("page_no", $page_no_arr[1]);
        $this->set("search_srting", $search_srting);
    }

    function set_paginate_limit_search($search_srting = '')
    {

        if ($search_srting == '') {
            $this->paginate = array('conditions' => array('User.activation' => 1),
                'fields' => array('User.id', 'User.firstname', 'User.lastname', 'User.email', 'User.image_url', 'User.school_status', 'School.id', 'School.name', 'Country.countries_name'), 'limit' => $this->paginate_limit_front);
        } else {
            $checkstring = array();

            $checkstring = explode(" ", $search_srting);


            if (count($checkstring) == 1) {

                $checkstring = str_replace("889988", " ", $checkstring);

                $this->paginate = array('conditions' => array('or' => array(
                    'User.firstname LIKE' => '%' . $checkstring[0] . '%',
                    'User.lastname LIKE' => '%' . $checkstring[0] . '%',
                    'User.school_status  LIKE' => '%' . $checkstring[0] . '%'
                ),
                    'User.activation' => 1
                ),
                    'fields' => array('User.id', 'User.firstname', 'User.lastname', 'User.email', 'User.image_url', 'User.school_status', 'School.id', 'School.name', 'Country.countries_name'),
                    'limit' => $this->paginate_limit_front
                );
            } else {


                //$search_srting = str_replace("889988", " ", $search_srting);

                $this->paginate = array('conditions' => array('and' => array(
                    'User.firstname LIKE' => $checkstring[0],
                    'User.lastname LIKE' => '%' . $checkstring[1] . '%'
                ),
                    'User.activation' => 1
                ),
                    'fields' => array('User.id', 'User.firstname', 'User.lastname', 'User.email', 'User.image_url', 'User.school_status', 'School.id', 'School.name', 'Country.countries_name'),
                    'limit' => $this->paginate_limit_front
                );
            }
        } // else ends here
    }

// ef

    function admin_search($page_no = '')
    {
        //  print_r($this->request->data);exit;
        $this->layout = "admin";
        $search_srting = "";

        if ($this->request->data) {
            $search_srting .= "type=adv,";
            $search_srting .= "firstname=" . $this->request->data['User']['search'];
        }
        $search_srting = trim($search_srting);

        $search_srting = str_replace(" ", "889988", $search_srting);

        $this->set("search_srting", $search_srting);

        $this->set("page_no", $page_no);
    }

    function admin_all_search_ajax($search_srting = '')
    {

        $this->set_paginate_limit_front($search_srting); // Setting Paginate Limit 

        $this->setLayout = null;

        Configure::write('debug', 0);

        $data = $this->paginate();

        $this->set("users", $data);

        $this->set("paginate_limit", $this->paginate_limit_front);

        // Finding Page No (for Sr. No.)
        $page_no_arr = explode(":", $_REQUEST['url']);

        $this->set("page_no", $page_no_arr[1]);


        $this->set("search_srting", $search_srting);
    }

    function set_paginate_limit_front($search_srting = '')
    {
        $condition = "";

        if ($search_srting == '') {

            //$this->paginate = array('conditions'=>'1=1', 'order'=>array('Suggestion.id desc'), 'limit' => $this->paginate_limit_front);
        } else {
            $search_srting = str_replace("889988", " ", $search_srting);


            $search_srting_arr = explode(",", $search_srting);

            if ($search_srting_arr[0] == "type=adv") {
                for ($i = 1; $i <= count($search_srting_arr) - 1; $i++) { //echo $search_srting_arr[$i];exit;
                    $search_sub_srting_arr = explode("=", $search_srting_arr[$i]);

                    switch ($search_sub_srting_arr[0]) {
                        case "firstname":
                            if (!empty($search_sub_srting_arr[1]))
                                $condition = $condition . " User.firstname like '%" . $search_sub_srting_arr[1] . "%'";

                            break;
                    }
                }
            }


            $this->paginate = array('conditions' => $condition, 'order' => array('User.id  desc'), 'limit' => $this->paginate_limit_front);
        }
    }
}

?>
