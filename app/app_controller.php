<?php

App::import('Vendor', 'facebook/facebook');
define('_UNIT_MILES', 'm');
define('_UNIT_KILOMETERS', 'k');

// constants for passing $sort to get_zips_in_range()
define('_ZIPS_SORT_BY_DISTANCE_ASC', 1);
define('_ZIPS_SORT_BY_DISTANCE_DESC', 2);
define('_ZIPS_SORT_BY_ZIP_ASC', 3);
define('_ZIPS_SORT_BY_ZIP_DESC', 4);

// constant for miles to kilometers conversion
define('_M2KM_FACTOR', 1.609344);

/**
 * Overriden 
 */
class AppController extends Controller {

    var $uses = array('School', 'User', 'Review', 'Article');
    var $helpers = array('Html', 'Javascript', 'Ajax', 'Session');
    var $components = array('RequestHandler', 'Auth', 'Cookie', 'Session');
    var $last_error = "";            // last error message set by this class
    var $units = _UNIT_MILES;        // miles or kilometers
    var $decimals = 2;               // decimal places for returned distance
    var $facebook;
    var $__fbApiKey = FACEBOOK_APP_ID;
    var $__fbSecret = FACEBOOK_APP_SECRET;
    var $youtube_dev_key = YOUTUBE_DEV_KEY;
    var $youtube_username = YOUTUBE_USERNAME;
    var $youtube_password = YOUTUBE_PASSWORD;
    var $emailCheckExpression = '/^\s*[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}\s*$/';

    /**
     * Default constructor, will instantiate a facebook client
     */
    function __construct() {
        parent::__construct();
        // Prevent the 'Undefined index: facebook_config' notice from being thrown.
        $GLOBALS['facebook_config']['debug'] = NULL;

        // Create a Facebook client API object.
        $this->facebook = new Facebook($this->__fbApiKey, $this->__fbSecret);
    }

    function beforeFilter() {

        $this->Auth->allow = array('*');
        $this->Auth->userModel = 'User';  // to set the table to use with authentication
        $this->Auth->fields = array('username' => 'username', 'password' => 'password');

        //check to see if user is signed in with facebook
        $this->__checkFBStatus();
        if (isset($this->params['admin'])) {
            if ($this->params['admin'] == 1 && $this->action != 'admin_forgot_password') {
                if ($this->action != 'admin_login' && $this->action != 'admin_logout') {
                    if (!$this->Session->read('admin_id')) {
                        // $this->autoRender = false;						
                        $this->redirect(array('controller' => 'admins', 'action' => 'login'));
                        //$this->redirect('login');
                    }
                }
            }
        } else {
            if (isset($_POST['username'])) {
                $this->data['User']['username'] = $_POST['username'];
                $this->data['User']['password'] = $_POST['password'];
            } 
               // $this->set('loggedInFacebookId', $this->Auth->user('fbid'));
            

            $this->Auth->loginError = "<font color='#fff'></font>";

            $this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'home');
            $this->Auth->allow('*');
            //$this->Auth->authorize = 'controller';
            $this->Auth->allow = array('*');

            $this->Auth->userScope = array('User.activation' => '1');
            $this->set('loggedInId', $this->Auth->user('id'));
            $this->set('loggedInName', $this->Auth->user('firstname').' '.$this->Auth->user('lastname'));
            $this->set('userSchoolId', $this->Auth->user('school_id'));
            $this->set('loggedInUserName', $this->Auth->user('username'));
            $this->set('loggedInFacebookId', $this->Auth->user('fbid'));
            $this->set('profileImgURL', $this->Auth->user('image_url'));
            $this->Auth->autoRedirect = false;
            $this->Cookie->name = 'Ulink';


            if ($this->Auth->user('id')) {// echo "<pre>"; print_r( $this->Auth->user());
                $this->PermitModel = ClassRegistry::init("School");


                $Shoolreview = $this->PermitModel->find('all', array('conditions' => array('School.id' => $this->Auth->user('school_id'))));



                $this->set('Shoolreview', $Shoolreview);
                $this->PermitModel = ClassRegistry::init("Review");
                $usertextreview = $this->PermitModel->find('all', array('conditions' => array('Review.school_id' => $this->Auth->user('school_id'), 'Review.type' => 'text', 'Review.user_id' => $this->Auth->user('id'))));

                foreach ($usertextreview as $userReview) {
                    if ($userReview['Review']['status'] == 0) {
                        $this->set('ApprovalPending', 1);
                    }
                }



                $this->set('usertextreview', $usertextreview);
                $randCaptcha = rand(10000, 20000);
                $this->set('RandCaptcha', $randCaptcha);
            }

            if (!$this->Auth->user('id')) {
                $cookie = $this->Cookie->read('User');
                if ($cookie) {
                    $this->Auth->login($cookie);
                }
            }
        }// else end here	
    }

    /**
     * uploads files to the server
     * 		will return an array with the success of each file upload
     */
    function uploadFiles($folder, $formdata, $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;


        //echo "<br>".print_r($formdata);
        // create the folder if it does not exist
        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }


        // if itemId is set create an item folder
        if ($itemId) {

            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png');

        // loop through and deal with the files
        foreach ($formdata as $file) {
            // replace spaces with underscores
            $filename = str_replace(' ', '_', $formdata['name']);
            // assume filetype is false
            $typeOK = false;
            // check filetype is ok

            foreach ($permitted as $type) {
                if ($type == $formdata['type']) {
                    $typeOK = true;

                    break;
                }
            }
            // if file type ok upload the file
            if ($typeOK) {

                // switch based on error code
                switch ($file['error']) {
                    case 0:
                        // check filename already exists
                        if (!file_exists($folder_url . '/' . $filename)) {
                            // create full filename


                            $full_url = $folder_url . '/' . $filename;
                            $url = $filename;
                            // upload the file
                            $success = move_uploaded_file($formdata['tmp_name'], $full_url);
                        } else {
                            // create unique filename and upload file
                            ini_set('date.timezone', 'Europe/London');
                            $now = date('Y-m-d-His');
                            $full_url = $folder_url . '/' . $now . $filename;
                            $url = $now . $filename;
                            $success = move_uploaded_file($formdata['tmp_name'], $full_url);
                        }
                        // if upload was successful
                        if ($success) {
                            // save the url of the file
                            $result['urls'][] = $url;
                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif ($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }
        }
        return $result;
    }

//ef

    function createCookies($user_id) {

        $this->Cookie->write('admin_id', $user_id, false, '72 hour');
    }

    function get_distance($zip1Lat, $zip2Lat, $zip1Long, $zip2Long) {

        $details1[0] = $zip1Lat;
        $details2[0] = $zip2Lat;
        $details1[1] = $zip1Long;
        $details2[1] = $zip2Long;

        $miles = AppController::calculate_mileage($details1[0], $details2[0], $details1[1], $details2[1]);

        if ($this->units == "k")
            return round($miles * (1.609344), $this->decimals);
        else
            return round($miles, $this->decimals);       // must be miles
    }

//ef 

    function calculate_mileage($lat1, $lat2, $lon1, $lon2) {

        // Convert lattitude/longitude (degrees) to radians for calculations
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Find the deltas
        $delta_lat = $lat2 - $lat1;
        $delta_lon = $lon2 - $lon1;

        // Find the Great Circle distance 
        $temp = pow(sin($delta_lat / 2.0), 2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon / 2.0), 2);
        $distance = 3956 * 2 * atan2(sqrt($temp), sqrt(1 - $temp));

        return $distance;
    }

//ef

    function chkAutopass() {
        $sessVar = $this->Auth->user();




        $userDetails = ClassRegistry::init('User')->find('first', array('conditions' => array('User.id' => $sessVar['User']['id'])));

        if ($userDetails['User']['autopass'] == 1) {

            $this->Session->setFlash('Your password is auto generated, please change your password to have full access to uLink.');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }
    }



// ef

    private function __checkFBStatus() {


        $this->facebook->get_loggedin_user();

        //check to see if a user is not logged in, but a facebook user_id is set
        if (!$this->Auth->User() && $this->facebook->get_loggedin_user()):

            //see if this facebook id is in the User database; if not, create the user using their fbid hashed as their password
            $user_record =
                    $this->User->find('first', array(
                        'conditions' => array('fbid' => $this->facebook->get_loggedin_user()),
                        'fields' => array('User.fbid', 'User.fbpassword', 'User.password', 'User.activation'),
                        'contain' => array()
                    ));

            //create new user
            if (empty($user_record)):

                /* $friends = $facebook->api_client->friends_get();
                  $fields = array('name','pic_square');
                  $info = $facebook->api_client->users_getInfo($friends, $fields);
                  print_r($info);exit; */


                $user_record['User']['fbid'] = $this->facebook->get_loggedin_user();
                $fc = new FacebookRestClient(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET, $facebook->api_client->session_key);

                $fUserData = $fc->users_getInfo($user_record['User']['fbid'], 'last_name,first_name,sex,current_location,email');
                $user_record['User']['fbpassword'] = $this->getRandomString();
                $user_record['User']['password'] = $this->Auth->password($user_record['User']['fbpassword']);
                $user_record['User']['lastname'] = $fUserData[0]['last_name'];
                $user_record['User']['firstname'] = $fUserData[0]['first_name'];
                $user_record['User']['activation'] = '0';
                $user_record['User']['username'] = $fUserData[0]['first_name'] . " " . $fUserData[0]['last_name'];
                // print_r($user_record);exit;
                $this->User->create();
                //print_r($user_record);exit;
                $this->User->save($user_record);
            endif;

            if ($user_record['User']['activation'] == '0') {

                //change the Auth fields
                $this->Auth->fields = array('username' => 'fbid', 'password' => 'password');

                $this->Auth->login($user_record);
                //$this->Session->setFlash('Please enter a valid email id');

                $this->redirect(array('controller' => 'users', 'action' => 'register/' . $user_record['User']['fbid']));
            } else {
                $this->Auth->fields = array('username' => 'fbid', 'password' => 'password');

                $this->Auth->login($user_record);
                
              

                // redirect to the previous page, else forward to homepage
                $redirect = $this->Session->read('Auth.redirect');
                if ($redirect) {
                    $this->redirect($redirect);
                } else {
                    $this->redirect(array('controller' => 'pages', 'action' => 'home'));
                }
            }
        endif;
    }

    /**
     * This function will generate a random String based on the passed in parameters
     * @param int $minLength
     * @param int $maxLength
     * @param bool $useUpper
     * @param bool $useSpecial
     * @param bool $useNumbers
     * @return string
     */
    function getRandomString($minLength = 20, $maxLength = 20, $useUpper = true, $useSpecial = false, $useNumbers = true) {
        $charset = "abcdefghijklmnopqrstuvwxyz";
        $key = '';

        if ($useUpper) {
            $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        if ($useNumbers) {
            $charset .= "0123456789";
        }
        if ($useSpecial) {
            $charset .= "~@#$%^*()_+-={}|][";
        }
        if ($minLength > $maxLength) {
            $length = mt_rand($maxLength, $minLength);
        } else {
            $length = mt_rand($minLength, $maxLength);
        }

        /*
         *  iterate over the desired length of the string
         *  appending a random char from the charset.
         */
        for ($i = 0; $i < $length; $i++) {
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        }
        return $key;
    }

    /**
     * This function will set the error layout before
     * any page loads
     */
    function beforeRender() {
        //to set the not found page
        $this->_setErrorLayout();
    }

    /*
     * This function will set the not found layout and render it
     */
    function _setErrorLayout() {
        if ($this->name == 'CakeError') {
            $this->layout = 'not_found';
        }
    }
}
?>