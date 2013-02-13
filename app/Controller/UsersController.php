<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: Mar 22, 2012
 * Description: This class handles all the User object business logic
 ********************************************************************************/
class UsersController extends AppController {

    var $name = 'Users';
    var $uses = array('User', 'Country', 'State', 'City', 'School', 'Review', 'Domain', 'Event', 'Snapshot');
    var $helpers = array('Html', 'Form', 'Js');
    public $components = array('Email', 'Session', 'RequestHandler', 'Security', 'Cookie','Auth');
    var $paginate_limit = '20';
    var $paginate_limit_front = '10';
    var $paginate_limit_front_compact = '10';
    var $paginate_limit_admin = '20';
    var $paginate = "";

    /**
     * This method will be called before every action executes
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('user','update_user', 'update_social','validate_email_domain', 'validate_username', 'register', 'forgotpassword', 'reset_password', 'sign_up', 'checkUsername', 'checkdomain', 'confirm', 'removeImage', 'viewprofile');
        $this->Security->csrfCheck = false;
        $this->Security->validatePost = false;
    }

    /******************************************************/
    /*          USER API FUNCTIONS                         */
    /******************************************************/
    /**
     * POST API function that handles resetting a user's password  This will verify that
     * the inputted user email exists, and will
     * reset the password for that user and send them an email.     *
     */
    public function reset_password($data = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        try {
            if($data != null) {
                $this->request->data = $data;
            }
            // if there is form data, continue with the process
            if (!empty($this->request->data)) {
                // if the email was provided
                if (!empty($this->request->data['User']['email'])) {
                    $useremail = $this->request->data['User']['email'];

                    // grab the user from the db based on the passed in email
                    $user = $this->User->find('all', array('conditions' => 'User.email="' . $useremail . '"'));

                    // if a user was successfully retrieved
                    if ($user != null) {

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

                            // create the email object
                            $email = new CakeEmail('gmail');
                            $email->to($useremail);
                            $email->subject('Your uLink Temporary Password');
                            $email->replyTo('noreply@theulink.com');
                            $email->emailFormat('html');
                            $email->template('forgotpassword');

                            // set the variables that will be needed in the template
                            $email->viewVars(array(
                                                   'username' => $user[0]['User']['username'],
                                                   'name' => $user[0]['User']['firstname']. ' ' .$user[0]['User']['lastname'],
                                                   'auto_pass' => $autopass
                                                   ));
                            try {
                                // if the email was sent successfully
                                if ($email->send()) {
                                    $retVal['result'] = "true";
                                    $retVal['response'] = 'Your new password was sent to ' . $useremail . '.';
                                } else {
                                    $retVal['result'] = "false";
                                    $retVal['response'] = 'There was a problem sending the password email. Please try again later, or contact help@theulink.com';
                                }
                            } catch (Exception $e) {
                                $this->log('{UsersController#reset_password} - An exception was thrown when attempting to send the forgot password email: ' . $e->getMessage());
                                $retVal['result'] = "false";
                                $retVal['response'] = 'There was a problem sending the password email. Please try again later, or contact help@theulink.com';
                            }
                        } else {  // saving of the user failed
                            $retVal['result'] = "false";
                            $retVal['response'] = 'There was an issue with your account,  please try again later.';
                            $this->request->data = null;
                        }
                    } else {  // no user was retrieved for that specified email
                        $retVal['result'] = "false";
                        $retVal['response'] = 'There is no uLink account associated with this email, please try another.';
                    }
                } else {  // no email was provided for the user
                    $retVal['result'] = "false";
                    $retVal['response'] = 'Please enter your email address.';
                }
            }
        } catch (Exception $ee) {
            $this->log("{UsersController#reset_password} - An exception was thrown: " . $ee->getMessage());
            $retVal['result'] = "false";
            $retVal['response'] = 'There was a problem resetting your password,  please try again later.';
        }
        return json_encode($retVal);
    } // reset_password

    /**
     * POST API function that will create a new
     * user account, and send a confirmation email
     * to the user to activate their new account.
     * @return json $retVal
     */
    public function sign_up($data = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        if($data != null) {
            $this->request->data = $data;
        }
        // if there is data to be saved
        if (!empty($this->request->data)) {
            $domainData = array();
              // grab the post data
            $domainData['User']['email'] = $this->request->data['User']['email'];;
            $domainData['User']['school_id'] = $this->request->data['User']['school_id'];
            $domainData['User']['school_status'] = $this->request->data['User']['school_status'];
            $domainValid = json_decode($this->validate_email_domain($domainData));
            $userNameValid = json_decode($this->validate_username($this->request->data['User']['username']));
            // check against the email here
            if ($this->emailExists($this->request->data['User']['email'])) {
                $retVal['response'] = 'Email already exists in uLink.  Please try another email address.';
            } else if ($userNameValid->result == "false") {
                $retVal['response'] = 'That username is already being used, please try another.';
            } else if ($domainValid->result == "false") {
                $retVal['response'] = 'The email provided is not valid for the school selected.';
            } else {
                // hash the user's password from the post
                $this->request->data['User']['password2hashed'] = AuthComponent::password($this->request->data['User']['password']);
                // set the hashed password on the new user
                $this->request->data['User']['password'] = $this->request->data['User']['password2hashed'];
                // remove the updated autopass from the user object so that it is not saved in the db
                unset($this->request->data['User']['password2hashed']);
                // create their activation key
                $this->request->data['User']['activation_key'] = String::uuid();

                // save the user
                if ($this->User->save($this->request->data)) {
                    $deleteUser = TRUE;
                    try {
                        // build an email to be sent to the user for account activation
                        $email = new CakeEmail('gmail');
                        $email->to($this->request->data['User']['email']);
                        $email->subject( 'uLink Account Activation');
                        $email->replyTo('noreply@theulink.com');
                        $email->emailFormat('html');
                        $email->template('confirmation');

                        $userId = null;
                        if (isset($this->request->data['User']['id'])) {
                            $userId = $this->request->data['User']['id'];
                        } else {
                            $userId = $this->User->getLastInsertID();
                        }

                        // set the variables that will be needed in the template
                        $email->viewVars(array(
                               'name' => $this->request->data['User']['username'],
                               'server_name' => $_SERVER['SERVER_NAME'],
                               'code' => $this->request->data['User']['activation_key'],
                               'id' =>  $userId
                         ));

                        // send off the email, and redirect to the successful signup page
                        if ($email->send()) {
                            $retVal['result'] = "true";
                        } else {
                            // if the email failed, let's delete the user
                            $this->User->delete($this->User->getLastInsertID());
                            $deleteUser = FALSE;
                            $retVal['response'] = 'There was a problem sending the confirmation email. Please try again, or contact help@thelink.com.';
                        }
                    } catch (Exception $e) {
                        if($deleteUser) {
                            $this->User->delete($this->User->getLastInsertID());
                        }
                        $this->log('{UsersController#sign_up} - An exception was thrown when attempting to send the confirmation email: ' . $e->getMessage());
                        $retVal['response'] ='There was a problem sending the confirmation email. Please try again, or contact help@thelink.com.';
                    }
                } else {  // there was an error when trying to save the user
                    if($this->User->invalidFields() != null) {
                        $errors = '';
                        foreach($this->User->invalidFields() as $key => $value) {
                            $errors .= $value . '<br />';
                        }
                        $retVal['response'] =$errors;
                    } else {
                        $retVal['response'] = 'There was a problem getting your account setup. Please try again, or contact help@theulink.com.';
                    }
                }
            }
        }
        return json_encode($retVal);
    } // sign_up

    /**
     * POST API function that will update the user's social information
     * @return array $retVal
     */
    public function update_social($data = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        if($data != null) {
            $this->request->data = $data;
        }
        if(!empty($this->request->data)) {
            // create a data object with the user's info
            $newData = array(
                'User' => array(
                    'id' => $this->request->data['User']['id'],
                    'twitter_username' => $this->request->data['User']['twitter_username'],
                    'twitter_enabled' => $this->request->data['User']['twitter_enabled']
                )
            );
            // update the user's profile in the db
            if ($this->User->save($newData)) {
                $retVal['result'] = "true";
            } else {
                $retVal['response'] = "There was an issue saving your account information.  Please try again, or contact help@theulink.com";
            }
        }
        return json_encode($retVal);
    } // update_social
    /**
     * POST API function that will validate if the username is unique
     * @return array $retVal
     */
    public function validate_username($data = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        // attempt to retrieve a user with the same username
        $userdetails = $this->User->find('count', array('conditions' => array('User.username' => $data)));
        if($userdetails == null) {
            $retVal['result'] = "true";
        }
        return json_encode($retVal);
    } // validate_username

    /**
     * POST API function that will validate if the username is unique
     * @return array $retVal
     */
    public function validate_email_domain($data = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = 'The email provided is not valid for the school selected.';
        if($data != null) {
            /**
             * If the user is not an Alumni, make
             * sure they have an approved emails domain for the school
             * in which they are registering.
             */
            if ($data['User']['school_status'] != 'Alumni') {
                $chkuser = $this->School->find('all', array('conditions' => 'School.id=' . $data['User']['school_id'] ));

                // grab all the valid domains for the school
                $domains = explode(',', $chkuser[0]['School']['domain']);

                // iterate over the domains, verifying the posted email's domain matchs one in the list
                foreach ($domains as $val) {
                    $lookdomain = explode('.', $lookdomain = $val);

                    $domain = '';
                    $first = TRUE;
                    foreach($lookdomain as $dom) {
                        if($first) {
                           $first = FALSE; 
                           $domain .= $dom;
                        } else {
                            $domain .= ".".$dom;
                        }
                    }

                    // break the loop if we find a match
                    if ((eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@" . $domain. "$", $data['User']['email'] ))) {
                        $retVal['result'] = "true";
                        $retVal['response'] = '';
                        break;
                    }
                }
            } else { // do NOT validate domain's if user is Alumni
               $retVal['result'] = "true";
               $retVal['response'] = '';
            }
        }
        return json_encode($retVal);
    } // validate_email_domain

    /**
     * POST API function will update the password
     * in the user's profile
     * @param $data
     * @return json $retVal
     */
    public function update_password($data=null) {
        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        $validateError = 0;
         if($data != null) {
            $this->request->data = $data;
        }
        // if the user is changing their password, perform validation
        if (!empty($this->request->data['User']['oldpass'])) {
            $cuser = null;
            // if the user is changing their password make sure the confirm matches the new
            if (!empty($this->request->data['User']['newpass'])) {
                if ($this->request->data['User']['newpass'] != $this->request->data['User']['newconfirmpass']) {
                    $this->User->invalidate('newconfirmpass', "The verify password does not match the new password.");
                    $validateError++;
                }
                if (strlen($this->request->data['User']['newpass']) < 6) {
                    $this->User->invalidate('newconfirmpass', "The new password must be at least six characters.");
                    $validateError++;
                }
            }

            if($validateError == 0) {
                $cuser = $this->User->find('first', array('conditions' => 'User.id=' . $this->request->data['User']['id']));
                if ($this->Auth->password($this->request->data['User']['oldpass']) == $cuser['User']['password']) {
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newconfirmpass']);
                } else {
                    $this->User->invalidate('oldpass', 'The current password entered was incorrect, please try again.');
                    $validateError++;
                }
            }
        } else {
            $this->User->invalidate('oldpass', "Please enter your old password.");
            $validateError++;
        }

        // grab the current logged in user
        //$sessVar = $this->Auth->user();

        // check for validation errors
        if($validateError > 0) {
            if($this->User->invalidFields() != null) {
                $errors = '';
                foreach($this->User->invalidFields() as $value) {
                    $errors .= $value[0] . '<br />';
                }
            }
            $retVal['response'] = $errors;
        } else {
            // create a data object with the user's info
            $newData = array(
              'User' => array(
                  'id' => $cuser['User']['id'],
                  'username' => $cuser['User']['username'],
                  'password' => $this->request->data['User']['password'],
                  'autopass' => 0
                  )
              );

            // update the user's profile in the db
            if ($this->User->save($newData)) {
                $retVal['result'] = "true";
            } else {
                $retVal['response'] = "There was an issue saving your password.  Please try again, or contact help@theulink.com";
            }
        }
        return json_encode($retVal);
    } // update_password

    /**
     * Handles the login action
     */
    public function login() {
        $this->set('title_for_layout','Login to uLink');
        // if the user is already authenticated or there is post data...
        if ($this->Auth->user() || (isset($_POST['username']) && isset($_POST['password']))) {
            $this->autoRender = false;
            $this->layout = null;
            $isMobileRequest = isset($_POST['mobile_login']);
            $retVal = array();
            $retVal['result'] = "false";
            $retVal['response'] = '';
            try {
                // if there is data set from the form
                if (!empty($this->request->data)) {
                    // if "remember_me" was not clicked, removed any user data from the Cookie
                    if (!isset($_POST['username'])) {
                        $this->Cookie->delete('User');
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
            } catch (Exception $e) {
                $this->log("{UsersController#login} - An exception was thrown when setting the cookie: " . $e->getMessage()."::STACKTRACE::".$e->getTraceAsString());
            }

            try {
                /**
                 * Grab the authenticated user from the session
                 * Note: at this point the user has already been
                 * authenticated in the AppController::beforeFilter function
                 */
                $getInfo = $this->Auth->User();

                // if a user was retrieved...success
                if ($getInfo != null) {
                    if($isMobileRequest) {
                        $school = $this->School->findById($getInfo['school_id']);
                        if($school != null) {
                            $getInfo['school_name'] = $school['School']['name'];
                        }
                    }
                    // first check to see if the user is active
                    if ((int)$getInfo['activation'] == 0) {
                        // log the user out
                        $this->Auth->logout();
                        // user is not active
                        if($isMobileRequest) {
                            $retVal['result'] = "std";
                        } else {
                            echo "std";
                            exit;
                        }
                    } else if ((int)$getInfo['autopass'] == 1) { // if the user is active but might have reset their password
                        // user is active but needs to change their password
                        if($isMobileRequest) {
                            $retVal['result'] = "auto";
                            $retVal['response'] = $getInfo;
                        } else {
                            echo "auto";
                            exit;
                        }
                    } else {
                        // if the user was deactivated, reactivate them
                        if ((int)$getInfo['deactive'] == 1) {
                            $this->User->id = $getInfo['id'];
                            $this->User->saveField('deactive', 0);
                        }
                        // set the username to be used on the front end
                        $this->set('username',$getInfo['username']);

                        // if this was from the login page
                        if (isset($_POST['loginMain'])) {
                            echo "main";
                            exit;
                        }  
                        else 
                        { // else this was from the login modal
                            if($isMobileRequest) {
                                $retVal['result'] = "yes";
                                // grab the user's events and snapshots and set in object to be returned as json
                                $events =$this->Event->find('all', array('order'=>array('Event.eventDate'=>'DESC'),'conditions' => array('userID' => $getInfo['id'])));
                                $snaps = $this->Snapshot->find('all', array('order'=>array('Snapshot.created'=>'DESC'),'conditions' => array('userId' => $getInfo['id'])));
                                $getInfo['Events'] = $events;
                                $getInfo['Snaps'] = $snaps;
                                // grab the top snapper
                                $user = new User();
                                $getInfo['TopSnapper'] = $user->getTopSnapperBySchoolID($getInfo['school_id']);
                                $retVal['response'] = $getInfo;
                            } else {
                                echo "yes";
                                exit;
                            }
                        }
                    }
                } else {   
                    // finally it must be an invalid login
                    if($isMobileRequest) {
                        $retVal['result'] = "in-valid";
                    } else {
                        echo "in-valid";
                        exit;
                    }
                }
            } catch (Exception $e) {
                $this->log("{UsersController#login} - An exception was thrown: " . $e->getMessage() ."::STACKTRACE::".$e->getTraceAsString());
                if($isMobileRequest) {
                    $retVal['result'] = "in-valid";
                } else {
                    echo "in-valid";
                    exit;
                }
            }
            if($isMobileRequest) {
                return json_encode($retVal);
            }
        } else { // page is initially loading
            $this->layout = "v2_no_login_header";
        }
    } // login

    /**
     * GET API Function that will return the user
     * along with all their data based on the passed
     * in id parameter.
     * @param string $userId
     * @return array $retVal
     */
    public function user($userId = null) {
        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        try {
            if ($userId != null) {

                // first grab the user
                $user = $this->User->find('first', array('conditions' => 'User.id =' .  $userId));
                $school = $this->School->find('first', array('conditions' => 'School.id =' . $user['User']['school_id']));
                if($school != null) {
                    $user['User']['school_name'] = $school['School']['name'];
                }
                // remove any unneeded data
                unset($user['User']['password']);
                unset($user['School']['description']);
                // grab the user's events and snapshots and set in object to be returned as json
                $events =$this->Event->find('all', array('order'=>array('Event.eventDate'=>'DESC'),'conditions' => array('userID' => $userId)));
                $snaps = $this->Snapshot->find('all', array('order'=>array('Snapshot.created'=>'DESC'),'conditions' => array('userId' => $userId)));
                $user['User']['Events'] = $events;
                $user['User']['Snaps'] = $snaps;
                // grab the top snapper
                $newUser = new User();
                $user['User']['TopSnapper'] = $newUser->getTopSnapperBySchoolID($user['User']['school_id']);
                $retVal['response'] = $user['User'];
                $retVal['result'] = "true";
            }
        } catch (Exception $e) {
            $this->log("{UsersController#user} - An exception was thrown when retrieving the user: " . $e->getMessage());
        }
        return json_encode($retVal);
    } // user

    /**
     * POST API Function that will update the user's account information
     * @param $data
     * @return json array
     */
    public function update_user($data = null) {
        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;
        $isMobileRequest = isset($_POST['mobile_login']);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = '';
        try {
            if($data != null) {
                $this->request->data = $data;
            }

            // set the saved data on the user
            $this->User->set($this->request->data);
            $validateError = 0;
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

            // if there are no validation errors
            if (empty($this->User->validationErrors)) {
                // if there is a new image, delete the old one and save the new one
                if(isset($this->request->data['User']['file']['name']) && $this->request->data['User']['file']['name'] != "") {
                    $fileOK = $this->uploadFiles('img/files/users', $this->request->data['User']['file']);

                    if (array_key_exists('urls', $fileOK)) {
                        if( $this->request->data['User']['image_url']  != "" ||  $this->request->data['User']['image_url']  != null) {
                            $filePath = "" . WWW_ROOT . "img/files/users/" . $this->request->data['User']['image_url'];
                            if(file_exists($filePath)) {
                                // delete the event image from the server if there was one
                                unlink($filePath);
                            }
                            // remove the old thumb and medium images
                            $thumbsURL = "" . WWW_ROOT . "img/files/users/thumbs/" . $this->request->data['User']['image_url'];
                            if(file_exists($thumbsURL)) {
                                // delete the old image
                                unlink($thumbsURL);
                            }
                             $mediumFilePath = "" . WWW_ROOT . "img/files/users/medium/" .$this->request->data['User']['image_url'];
                            if(file_exists($mediumFilePath)) {
                                // delete the old image
                                unlink($mediumFilePath);
                            }
                        }

                        // save the url in the form data
                        $this->request->data['User']['image_url'] = $fileOK['urls'][0];
                    } else {
                        throw new Exception('The user image did not save correctly to the server.');
                    }
                    unset($this->request->data['User']['file'] );
                }

                // update the user in the db
                if ($this->User->save($this->request->data)) {
                    $retVal['result'] = "true";
                    if(!$isMobileRequest) {
                        // load the saved user back into the Auth component
                        $user = $this->User->read(null, $this->Auth->user('id'));

                        // update session and merge any differences
                        $this->Session->write('Auth.User', array_merge($this->Auth->user(), $this->request->data['User']) );
                    }
                    $responseData = array();
                    $userData = array();
                    $responseData['html'] = '<span class="profile-success">Your profile has been updated.</span>';
                    $userData['image_url'] = $this->request->data['User']['image_url'];
                    $responseData['userdata'] = $userData;
                    $retVal['response'] = $responseData;
                }
            } else {
                if($this->User->invalidFields() != null) {
                    $errors = '';
                    foreach($this->User->invalidFields() as $value) {
                        $errors .= $value[0] . '<br />';
                    }
                    $retVal['response'] = $errors;
                }
            }
        } catch (Exception $e) {
            $this->log("{UsersController#update_user} - An exception was thrown when updating the user: " . $e->getMessage());
        }
        return json_encode($retVal);
    } // update_user

    /******************************************************/
    /*          END USER API FUNCTIONS                     */
    /******************************************************/

    /**
     * Handles the logout action
     */
    public function logout() {
        $this->layout = null;
        $this->Auth->logout();
        $this->redirect("/");
    } // logout

    /**
     * Function that handles the forgot password action.  This will verify that
     * the inputted user email exists, and will
     * reset the password for that user and send them an email.
     * TODO: 8.3.12 - need to break this out into smaller atomic functions
     *
     */
    public function forgotpassword() {
        // if the user is already authenticated, redirect to homepage
        if ($this->Auth->user()) {
            $this->redirect($this->Auth->redirect());
            exit();
        }
        try {
            // if there is form data, continue with the process
            if (!empty($this->request->data)) {
                $retVal = $this->reset_password($this->request->data);
                $data = json_decode($retVal);
                if($data->result == 'true') {
                    $this->set('forgotError', 'false');
                    $this->Session->setFlash($data->response,'default', array('class' => 'help-inline success'));
                } else {
                    $this->set('forgotError', 'true');
                    $this->Session->setFlash($data->response,  'default', array('class' => 'help-inline error'));
                }
            } else { // this is just initial page load
                $this->set('forgotError', 'init');
            }
        } catch (Exception $ee) {
            $this->log("{UsersController#forgotpassword} - An exception was thrown: " . $ee->getMessage());
        }
        $this->autoRender = true;
        $this->set('title_for_layout','Forgot Password');
        $this->layout = "v2";
    } // forgotpassword

    /**
     * This function will handle the main registration of new users
     * to the site.  If an id is passed in, we know that this
     * is for facebook users.
     *
     * TODO: 8.3.12 - need to break this out into smaller atomic functions, and
     *  figure out what needs to be hard outs vs. continue on
     *
     * @param null $id
     */
    public function register($id = null) {
        try {
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
                $retVal = $this->sign_up($this->request->data);
                $data = json_decode($retVal);
                if($data->result == 'true') {
                    $this->redirect(array('controller' => 'pages', 'action' => 'success'));
                } else {
                    $this->Session->setFlash($data->response);
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
        } catch (Exception $ee) {
            $this->log('{UsersController#register} - An exception was thrown: ' . $e->getMessage());
            $this->Session->setFlash('There was a problem getting your account setup. Please try again, or contact help@theulink.com.');
        }
        $this->set('title_for_layout','Sign up with uLink');
        $this->layout = "v2_no_login_header";
        $this->autoRender = true;
    }  // register

    /**
     * This function will activate the new user's account
     * in the database.
     *
     * @param null $user_id
     * @param null $code
     */
    public function confirm($user_id = null, $code = null) {
        $this->set('title_for_layout','Account Activation');
        $this->layout = "v2";

        // if the userid and the code are not set throw error
        if (empty($user_id) || empty($code)) {
            $this->set('confirmed', 0);
            $this->render();
        }

        try {
            // grab the user based on the passed in code
            $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'User.activation_key' => $code)));

            // if no user was found they are not activated
            if (empty($user)) {
                $this->set('confirmed', 0);
            } else {
                // activate the user in the database
                $this->User->id = $user_id;
                $this->User->saveField('activation', '1');

                // setting it to blank so that key can be access only once
                $this->User->saveField('activation_key', '');
                $this->set('confirmed', 1); // represents success
            }
        } catch (Exception $e) {
            $this->log("{UsersController#confirm} - An exception was thrown: " . $e->getMessage());
            $this->set('confirmed', 0);
        }
    }  // confirm

    /**
     * This function will delete the image
     * from the user's profile
     *
     * @param null $image_url
     */
    public function removeImage($image_url = null) {
        try {
            // grab the current logged in user
            $sessVar = $this->Auth->user();

            // create a data object with the user's info
            $data = array(
                'User' => array(
                    'id' => $sessVar['id'],
                    'username' => $sessVar['username'],
                    'image_url' => ""
                )
            );

            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;

            // update the user's profile in the db
            if ($this->User->save($data)) {
                $fullFilePath = "" . WWW_ROOT . "img/files/users/" . $image_url;
                if(file_exists($fullFilePath)) {
                    unlink($fullFilePath);
                }
                // remove the old thumb and medium images
                $thumbsURL = "" . WWW_ROOT . "img/files/users/thumbs/" . $image_url;
                if(file_exists($thumbsURL)) {
                    // delete the old image
                    unlink($thumbsURL);
                }
                 $mediumFilePath = "" . WWW_ROOT . "img/files/users/medium/" .$image_url;
                if(file_exists($mediumFilePath)) {
                    // delete the old image
                    unlink($mediumFilePath);
                }
                echo "true";
                exit;
            } else {
                echo "false";
                exit;
            }
        } catch (Exception $e) {
            $this->log("{UsersController#removeImage} - An exception was thrown: " . $e->getMessage());
            echo "false";
            exit;
        }
    } // removeImage

    /**
     * Password page loader
     * @param null change
     */
    public function password($change=null) {
        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = "v2";
        $this->set('title_for_layout','Change Password');

        /*
        * If the user has an autogenerated password, we will
        * display a message for the user that they need to change
        * their password.
        */
        if($change != null) {
            $this->set('change',$change);
        }
    } // password

    /**
     * This function will be for the management of
     * the user's social integration to uLink
     */
    public function social() {
        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }

        try {
            // grab the current logged in user
            $sessionUser = $this->Auth->user();
            if(empty($this->data)) {
                $this->data = $this->User->read('', $sessionUser['id']);
            } else {
                $data = $this->request->data;
                $data['User']['id'] = $sessionUser['id'];
                $json = $this->update_social($data);
                $result = json_decode($json);
                // update the user's profile in the db
                if ($result->result == "true") {
                    $this->Session->setFlash('<span class="profile-success">Your profile has been updated.</span>');
                } else {
                    $this->Session->setFlash($result->response);
                }
            }
        } catch (Exception $e) {
            $this->log("{UsersController#social} - An exception was thrown: " . $e->getMessage());
            $this->Session->setFlash("There was an issue saving your account information.  Please try again, or contact help@theulink.com");
        }
        $this->layout = "v2";
        $this->set('title_for_layout','Social Management');
        $this->autoRender = true;
    }  // social

    /**
     * This function will update the password
     * in the user's profile
     */
    public function updatePassword() {
        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->layout = null;
        $validateError = 0;
        try {

            // if the user is changing their password, perform validation
            if (!empty($this->request->data['User']['oldpass'])) {

                // if the user is changing their password make sure the confirm matches the new
                if (!empty($this->request->data['User']['newpass'])) {
                    if ($this->request->data['User']['newpass'] != $this->request->data['User']['newconfirmpass']) {
                        $this->User->invalidate('newconfirmpass', "The verify password does not match the new password.");
                        $validateError++;
                    }
                    if (strlen($this->request->data['User']['newpass']) < 6) {
                        $this->User->invalidate('newconfirmpass', "The new password must be at least six characters.");
                        $validateError++;
                    }
                }

                if($validateError == 0) {
                    $cuser = $this->User->find('first', array('conditions' => 'User.id=' . $this->Auth->user('id'),
                        'fields' => array('User.password')));
                    if ($this->Auth->password($this->request->data['User']['oldpass']) == $cuser['User']['password']) {
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newconfirmpass']);
                    } else {
                        $this->User->invalidate('oldpass', 'The current password entered was incorrect, please try again.');
                        $validateError++;
                    }
                }
            } else {
                $this->User->invalidate('oldpass', "Please enter your old password.");
                $validateError++;
            }

            // grab the current logged in user
            $sessVar = $this->Auth->user();

            // check for validation errors
            if($validateError > 0) {
                if($this->User->invalidFields() != null) {
                    $errors = '';
                    foreach($this->User->invalidFields() as $value) {
                        $errors .= $value[0] . '<br />';
                    }
                }
                echo $errors;
                exit;
            }  else {
                // create a data object with the user's info
                $data = array(
                  'User' => array(
                      'id' => $sessVar['id'],
                      'username' => $sessVar['username'],
                      'password' => $this->request->data['User']['password'],
                      'autopass' => 0
                      )
                  );

                // update the user's profile in the db
                if ($this->User->save($data)) {
                    echo "true";
                    exit;
                } else {
                    echo "There was an issue saving your password.  Please try again, or contact help@theulink.com";
                    exit;
                }
            }
        } catch (Exception $e) {
            $this->log("{UsersController#updatePassword} - An exception was thrown: " . $e->getMessage());
            echo "There was an issue saving your password.  Please try again, or contact help@theulink.com";
            exit;
        }

    } // updatePassword

    /**
     * This function will show the user's information
     * to the client based on the passed in user id
     *
     * @param null $id
     */
    public function viewprofile($id = null) {
        $this->layout = null;
        try {
            // if the user is not logged in, redirect them to the login screen
            if (!$this->Auth->user()) {
                $this->Session->setFlash('Please login to gain full access to uLink.');
                $this->redirect(array('action' => 'login'));
            }
            $this->chkAutopass();
            // grab the user from the db
            $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            echo json_encode($user);
            exit;
        } catch (Exception $e) {
            $this->log("{UsersController#viewprofile} - An exception was thrown: " . $e->getMessage());
        }
    } // viewprofile


    /**
     * This function will check if the email exists or not
     * @param $email
     * @return bool
     */
    private function emailExists($email) {
        $chkuserExist = null;
        try {
            $chkuserExist = $this->User->find('first', array('conditions' => 'User.email=' . "'$email'" . ''));
        } catch (Exception $e) {
            $this->log("{UsersController#emailExists} - An exception was thrown: " . $e->getMessage());
        }
        return !empty($chkuserExist);
    } // emailExists

    /**
     * This function will handle the user
     * updating their profile
     */
    public function index() {
        $this->set('title_for_layout','Your college everything');
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
            try {
                // grab the user off the session
                $this->request->data = $this->User->read('', $user['id']);

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

                $this->set('schools_id', $user['school_id']);
                $this->set('schools', $schools);
                $this->set('years_id', $user['year']);
                $this->set('years', $years);
                $this->set('school_status', $user['school_status']);
            } catch (Exception $e) {
                $this->log("{UsersController#index} - An exception was thrown when loading the user: " . $e->getMessage());
            }
        } else { // user hit the "update" button
            try {
                $json = $this->update_user($this->request->data);
                $result = json_decode($json);

                if($result->result == "true") {
                    $this->Session->setFlash($result->response->html);
                    // redirect back to the my profile page
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->set('errors', $result->response);
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
                $this->set('schools_id', $user['school_id']);
                $this->set('schools', $schools);
                $this->set('years_id', $user['year']);
                $this->set('years', $years);
                $this->set('school_status', $user['school_status']);
            } catch (Exception $e) {
                $this->log("{UsersController#index} - An exception was thrown when updating the user: " . $e->getMessage());
            }
        }
    } // index

    /**
     * Deactivate page loader
     */
    public function deactivate() {

        // if the user is not logged in, make them
        if (!$this->Auth->user()) {
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = "v2_no_login_header";
        $this->set('title_for_layout','Your college everything.');
    }  // deactivate

    /**
     * This function will deactivate the
     * user's account
     */
    public function deactivateaccount() {
        try {
            // grab the current logged in user
            $sessVar = $this->Auth->user();

            // create a data object with the user's info
            $data = array('User' => array('id' => $sessVar['id'], 'username' => $sessVar['username'], 'deactive' => 1));

            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;

            // update the user's profile in the db
            if ($this->User->save($data)) {
                $this->Auth->logout();
                echo "true";
                exit;
            } else {
                echo "There was an issue deactivating your account.  Please try again, or contact help@theulink.com";
                exit;
            }
        } catch (Exception $e) {
            $this->log("{UsersController#deactivateaccount} - An exception was thrown: " . $e->getMessage());
            echo "There was an issue deactivating your account.  Please try again, or contact help@theulink.com";
            exit;
        }
    }  // deactivateaccount

    /**
     * This function will verify that the user has a matching
     * email domain with the school
     */
    public function checkdomain() {
        $this->layout = null;
        $this->autoRender = false;
        $status = 0;
        $data = array();
        try {
            // grab the post data
            $data['User']['email'] = $_POST['data']['User']['email'];;
            $data['User']['school_id'] = $_POST['school_id'];
            $data['User']['school_status'] = $_POST['school_status'];
            $json = $this->validate_email_domain($data);
            $results = json_decode($json);
            echo $results->result;
        } catch (Exception $e) {
            $this->log("{UsersController#checkdomain} - An exception was thrown: " . $e->getMessage());
            echo "false";
            exit();
        }
    } // checkdomain

    /**
     * This function will check to see if the username
     * already exists in the system.
     */
    public function checkUsername() {
        $this->setLayout = null;
        Configure::write('debug', 0);

        try {
            // grab the username from the post data
            $username = $_POST['data']['User']['username'];
            $json = $this->validate_username($username);
            $results = json_decode($json);
            // if a user was found with the same username, throw error
            echo $results->result;
            exit();
        } catch (Exception $e) {
            $this->log("{UsersController#checkUsername} - An exception was thrown: " . $e->getMessage());
            echo "false";
            exit();
        }
    } // checkUsername

    /**
     * This function checks to see if the user exists
     * based on the passed in username.
     * @param username
     */
    public function checkuser($username = null) {
        $this->layout = null;
        $this->autoRender = false;

        try {
            $chkuser = $this->User->find('all', array('conditions' => 'User.username=' . "'$username'" . ''));

            if (count($chkuser) == 0) {
                echo "1";
                exit;
            } else {
                echo "0";
                exit;
            }
        } catch (Exception $e) {
            $this->log("{UsersController#checkuser} - An exception was thrown: " . $e->getMessage());
            echo "0";
            exit();
        }
    }

    /**
     * TODO: 8.4.12 - From this point on is uReview and Admin
     * related functions.  This still needs to be refactored.
     */

    /**
     * This function will show the user's information
     * to the client based on the passed in user id
     * @param null $id
     */
    function userinfo($id = null) {
        // if the user is not logged in, redirect them to the login screen
        if (!$this->Auth->user()) {
            $this->Session->setFlash('Please login to view this user account');
            $this->redirect(array('action' => 'login'));
        }

        $this->chkAutopass();
        $this->layout = "v2";
        // grab the user from the db
        $user = $this->User->find('User.id=' . $id);
        $this->set('User', $user);
        $this->pageTitle = $user['username'] . '\'s profile';
    }

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

        if (isset($this->request->data['searchText'])) {
            $this->Session->write('advancedUserSearch', $this->request->data['searchText']);
            $searchText = $this->request->data['searchText'];
        } elseif ($this->Session->check('advancedUserSearch')) {

            if (isset($this->request->params['named']['page'])) {
                $searchText = $this->request->data['AdvancedSearch'] = $this->Session->read('advancedUserSearch');
            } else {
                $this->Session->delete('advancedUserSearch');
                $searchText = $this->request->data['searchText'];
            }
        } else {

            $searchText = $this->request->data['searchText'];
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
            $this->request->data['password2hashed'] = $this->Auth->password($this->request->data['User']['password']);
            $this->request->data['activation_key'] = String::uuid();
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

        // build up the states list and set in view
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
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
            $filePath = "" . WWW_ROOT . "img/files/users/" . $image_url;
            if(file_exists($filePath)) {
                unlink($filePath);
            }
              // remove the old thumb and medium images
            $thumbsURL = "" . WWW_ROOT . "img/files/users/thumbs/" . $image_url;
            if(file_exists($thumbsURL)) {
                // delete the old image
                unlink($thumbsURL);
            }
             $mediumFilePath = "" . WWW_ROOT . "img/files/users/medium/" .$image_url;
            if(file_exists($mediumFilePath)) {
                // delete the old image
                unlink($mediumFilePath);
            }
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
            $filePath = "" . WWW_ROOT . "img/files/users/" . $image_url;
            if(file_exists($filePath)) {
                unlink($filePath);
            }
            // remove the old thumb and medium images
            $thumbsURL = "" . WWW_ROOT . "img/files/users/thumbs/" . $image_url;
            if(file_exists($thumbsURL)) {
                // delete the old image
                unlink($thumbsURL);
            }
             $mediumFilePath = "" . WWW_ROOT . "img/files/users/medium/" .$image_url;
            if(file_exists($mediumFilePath)) {
                // delete the old image
                unlink($mediumFilePath);
            }
            echo "true";
            exit;
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
            exit;
        }
    }

    function admin_checkuser($username = null)
    {
        $this->layout = null;
        $this->autoRender = false;

        $chkuser = $this->User->find('all', array('conditions' => 'User.username=' . "'$username'" . ''
            )
        );

        if (count($chkuser) == 0) {
            echo "1";
            exit;
        } else {
            echo "0";
            exit;
        }
    }

//ef

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
                exit;
            } else {
                echo "0";
                exit;
            }
        } else {
            echo "2";
            exit;
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
            exit;
        } else {
            $newStatus = "1";
            exit;
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
