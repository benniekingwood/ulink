<?php

/**
 * The main controller for schools
 */
class SchoolsController extends AppController {

    var $name = 'Schools';
    var $uses = array('School', 'State', 'City', 'Country', 'Suggestion', 'Image', 'Review', 'User');
    var $components = array('Email', 'Auth', 'Session', 'RequestHandler');
    var $helpers = array('Fck', 'Html', 'Form', 'Js');
    var $paginate_limit = '20';
    var $paginate_limit_front = '5';
    var $paginate_limit_front_compact = '10';
    var $paginate_limit_admin = '20';
    var $paginate = "";

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    /**
     * This function will add a school suggestion
     * to the database
     *
     * @param null $id
     */
    function suggestion($id=NULL) {
        $this->autoRender = false;
        $this->layout=null;
        $retVal = "false";
        if (!empty($this->request->data)) {
            $this->request->data['Suggestion']['name'] = $this->request->data['School']['name'];
            if ($this->Suggestion->save($this->request->data)) {
                $retVal = "true";
            }
            Configure:: write('debug', 0);
            return $retVal;
            exit();
        }
    }

    // listing o fsuggested schools
    function admin_school_index() {
        $this->layout = "admin_dashboard";

        $this->paginate = array(
            'limit' => $this->paginate_limit_front
        );

        if (isset($this->request->data['School']['searchText'])) {
            $this->Session->write('advancedSchoolSearch', $this->request->data['School']['searchText']);
            $searchText = $this->request->data['School']['searchText'];
        } elseif ($this->Session->check('advancedSchoolSearch')) {

            if (isset($this->request->params['named']['page'])) {
                $this->request->data['AdvancedSearch'] = $this->Session->read('advancedSchoolSearch');
                $searchText =    $this->request->data['AdvancedSearch'];
            } else {
                $this->Session->delete('advancedSchoolSearch');
                $searchText = $this->request->data['School']['searchText'];
            }
        } else {

            $searchText = $this->request->data['School']['searchText'];
        }

        if (empty($this->request->data)) {
            $school_listing = $this->paginate('School');
        } else {
            $school_listing = $this->paginate = array('conditions' => array('or' => array(
                        'School.name LIKE' => '%' . $searchText . '%',
                        'School.address LIKE' => '%' . $searchText . '%',
                        'School.zipcode LIKE' => '%' . $searchText . '%'
                    )
                ),
                'fields' => array('School.id', 'School.name', 'School.address', 'School.attendence', 'School.zipcode'),
                'limit' => $this->paginate_limit_front
            );

            $school_listing = $this->paginate('School');
        }

        $page_no_arr = explode(":", $_REQUEST['url']);
        if (isset($page_no_arr[1]))
            $this->set("page_no", $page_no_arr[1]);

        $this->set('School', $school_listing);
        $this->set("paginate_limit", $this->paginate_limit_front);
    }

    function detail($id = null) {


        $this->checkValidSchool($id, 'void');

        $this->layout = "default1";

        $school = $this->School->find('School.id=' . $id);


        $this->set('School', $school);

        $this->pageTitle = $school['School']['name'];


        $recentvideoreview = $this->Review->find('all', array('conditions' => 'School.id =' . $id . ' and Review.status=1 and Review.type="video"',
                    'fields' => array('Review.id', 'Review.title', 'Review.link', 'Review.rating', 'School.name'),
                    'order' => 'Review.created',
                    'LIMIT' => '4'
                        )
        );
        $this->set('RecentVideoReview', $recentvideoreview);


        $otherWrittenReview = $this->Review->find('all', array('conditions' => 'School.id=' . $id . ' and Review.status=1 and Review.type="text"',
                    'order' => 'RAND()',
                    'limit' => 3
                        )
        );
        $this->set('OtherWrittenReview', $otherWrittenReview);


        // prd(FULL_BASE_URL);
        // to brint the particular video caps na dmake them to show in frontend 
        //  App::import('Vender', 'Zend/Loader.php');
        require_once('Zend/Loader.php'); // setting up the file required
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

        $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                        $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                        $loginToken    = null, $loginCaptcha = null, $authenticationURL
        );
        $developerKey = 'AI39si78GbHXtfpGsJye-tKZtlqOqs51Hcw_tERXRU0cH6xME8LQ-YMEIh9qguU53m8MSZw-LJPmlWZ9V_poL0t1mD-ThOmFpw';
        $applicationId = 'Video uploader v1';

        $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, '', $developerKey);
        $yt->setMajorProtocolVersion(2);

        $zap = array();
        for ($j = 0; $j < count($recentvideoreview); $j++) {
            $videoEntry = $yt->getVideoEntry($recentvideoreview[$j]['Review']['link']);
            $zap[$j] = $this->printVideoEntry($videoEntry);
            if ($j == 2) {
                break;
            }
        } // eof loop to show video thubnails

        $this->set('VideoReviewCaps', $zap);
    }

//ef

    function printVideoFeed($videoFeed) {
        //$count = 1;
        foreach ($videoFeed as $videoEntry) {
            $this->printVideoEntry($videoEntry);
            echo "<br>";
        }
    }

// ef

    function printVideoEntry($videoEntry) {
        $caps['count'][] = $videoEntry->getVideoViewCount();
        $videoThumbnails = $videoEntry->getVideoThumbnails();

        foreach ($videoThumbnails as $videoThumbnail) {
            $caps['image_thumb'][] = "<img src=" . $videoThumbnail['url'] . " height='50' width='68' />";
            break;
        }
        return $caps;
    }

//ef 

    function admin_index() {
        $this->redirect(array('action' => 'school_index'));
    }

//ef 	

    function set_paginate_limit() {
        $this->paginate = array('limit' => $this->paginate_limit);
    }

    function admin_school_add() {
        $this->layout = "admin_dashboard";
        if (!empty($this->request->data)) {
            // echo "<pre>";
            //	 print_r($this->request->data);
            //	 die('xx');
            $this->School->create();

            $fileOK = $this->uploadFiles('img/files/schools', $this->request->data['School']['file']);

            if (array_key_exists('urls', $fileOK)) {
                $this->request->data['School']['image_url'] = $fileOK['urls'][0];
            }

            $this->School->set($this->request->data);
            if ($this->School->validates()) {
                $this->School->save($this->request->data);
                $last_insert_id = $this->School->id;

                for ($i = 0; $i < count($_SESSION['extra_image']); $i++) {
                    $sql = "INSERT INTO images (url,school_id) VALUES ('" . $_SESSION['extra_image'][$i] . "','$last_insert_id')";
                    mysql_query($sql);
                }
                unset($_SESSION['extra_image']);
                $this->Session->setFlash('School is Added!', true);
                $this->redirect(array('action' => 'school_index'));
            }
        } else {
            
        }
        $countries = array();
        $states = array();
        $cities = array();
        $data_countries = $this->Country->find('all');
        $data_states = $this->State->find('all');
        $data_cities = $this->City->find('all');

        foreach ($data_countries as $country) {
            $countries[$country['Country']['id']] = $country['Country']['countries_name'];
        }

        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }


        $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
    }

// ef

    function admin_school_state($id=null) {
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

    function admin_school_city($id=null) {
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

    function admin_school_edit($id = null) {
        $this->layout = "admin_dashboard";
        $school = $this->School->find('School.id=' . $id);

        if (empty($this->request->data)) {
            $this->request->data = $this->School->read('', $id);
        } else {

            $fileOK = $this->uploadFiles('img/files/schools', $this->request->data['School']['file']);
            if (array_key_exists('urls', $fileOK)) {
                // save the url in the form data
                $this->request->data['School']['image_url'] = $fileOK['urls'][0];
            }
            if ($this->School->save($this->request->data)) {
                $last_insert_id = $this->School->id;

                for ($i = 0; $i < count($_SESSION['extra_image']); $i++) {
                    $sql = "INSERT INTO images (url,school_id) VALUES ('" . $_SESSION['extra_image'][$i] . "','$last_insert_id')";
                    mysql_query($sql);
                }
                unset($_SESSION['extra_image']);

                $this->Session->setFlash('Your School has been updated.');
                $this->redirect(array('action' => 'school_index'));
            }
        }

        $countries = array();
        $states = array();
        $cities = array();
        $data_countries = $this->Country->find('all');
        $data_states = $this->State->find('all');
        $data_cities = $this->City->find('all');

        foreach ($data_countries as $country) {
            $countries[$country['Country']['id']] = $country['Country']['countries_name'];
        }
        foreach ($data_states as $state) {
            $states[$state['State']['id']] = $state['State']['name'];
        }
        foreach ($data_cities as $city) {
            $cities[$city['City']['id']] = $city['City']['name'];
        }
        for ($i = 1980; $i <= date("Y"); $i++) {
            $years[$i] = $i;
        }

        $this->set('countries', $countries);
        $this->set('countries_id', $school['School']['country_id']);
        $this->set('states', $states);
        $this->set('states_id', $school['School']['state_id']);
        $this->set('cities', $cities);
        $this->set('cities_id', $school['School']['city_id']);
        $this->set('years', $years);
        $this->set('years_id', $school['School']['year']);
    }

//ef

    function admin_school_delete($id=null) {
        // set default class & message for setFlash
        $class = 'flash_bad';
        $msg = 'Invalid List Id';

        // check id is valid
        if ($id != null && is_numeric($id)) {
            // get the Item
            $school = $this->School->read(null, $id);
            $img_old = $school['School']['image_url'];

            // check Item is valid
            if (!empty($school)) {
                // try deleting the item
                $user_exist = $this->User->find('count', array('conditions' => array('User.School_id' => $id)));
                if ($user_exist == 0) {
                    $this->School->delete($id);
                    $class = 'flash_good';
                    $msg = 'Your Item was successfully deleted';
                    Configure::write('debug', 0);
                    unlink("" . WWW_ROOT . "/img/files/schools/" . $img_old);
                    $this->autoRender = false;
                    $this->layout = null;

                    //echo "true";
                } if ($user_exist > 0) {
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    $this->layout = null;
                    $msg = 'There are users associated with this School,You cant delete it';
                    //  echo "false";
                }
            }
            $this->Session->setFlash($msg);
            $this->redirect(array('action' => 'school_index'));
        }
    }

//ef

    function admin_school_delimage($id=null, $image_url=null) {
        $school = $this->School->find('School.id=' . $id);
        $data = array(
            'School' => array(
                'id' => $id,
                'image_url' => ""
            )
        );
        if ($this->School->save($data)) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            unlink("" . WWW_ROOT . "/img/files/schools/" . $image_url);
            echo "true";
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
        }
    }

//ef

    function admin_school_extdelimage($id=null, $image_url=null) {        // to delte the extra images of the school
        if ($this->Image->delete($id)) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            unlink("" . WWW_ROOT . "/img/files/test/" . $image_url);
            echo "true";
        } else {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = null;
            echo "false";
        }
    }

// ef

    function admin_school_suggestion() {
        $this->layout = 'admin_dashboard';
        $data = $this->Suggestion->find('all');
        $this->set('Suggestion', $data);
    }

// ef

    function admin_suggestion_delete($id=null) {
        // set default class & message for setFlash
        $class = 'flash_bad';
        $msg = 'Invalid List Id';
        // check id is valid
        if ($id != null && is_numeric($id)) {

            // get the Item
            $suggestion = $this->Suggestion->read(null, $id);

            // check Item is valid
            if (!empty($suggestion)) {
                // try deleting the item
                if ($this->Suggestion->delete($id)) {
                    $class = 'flash_good';
                    $msg = 'Your Item was successfully deleted';
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    $this->layout = null;
                    echo "true";
                } else {
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    $this->layout = null;
                    $msg = 'There was a problem deleting your Item, please try again';
                    echo "false";
                }
            }
        }
    }

//ef

    function autocomplete() {
        $this->layout = null;
        $this->autoRender = false;
        if (isset($_POST['queryString'])) {

            $queryString = mysql_real_escape_string($_POST['queryString']);

            // Is the string length greater than 0?

            if (strlen($queryString) > 0) {

                $query = mysql_query("SELECT name FROM schools WHERE name LIKE '$queryString%' LIMIT 10");

                if ($query) {
                    // While there are results loop through them - fetching an Object (i like PHP5 btw!).
                    echo "<ul style='list-style:none; outside none;'>";
                    while ($result = mysql_fetch_array($query)) {
                        echo '<li onClick="fill(\'' . $result['name'] . '\');">' . $result['name'] . '</li>';
                    }
                    echo "</ul>";
                } else {
                    echo 'ERROR: There was a problem with the query.';
                }
            } else {
                // Dont do anything.
            } // There is a queryString.
        } else {
            echo 'There should be no direct access to this script!';
        }
    }

// ef
    //Recent added schools       
    function recentaddedschools() {

        $this->layout = null;
        $recentSchool = $this->School->find('all', array('order' => 'School.id DESC',
                    'limit' => '15'
                        )
        );
        $this->set('School', $recentSchool);
    }

//ef
    //Top rated schools       
    function topratedschools() {
        $this->layout = null;
        $topRatedSchool = $this->School->find('all', array('conditions' => 'School.rating > 0',
                    'order' => 'School.rating DESC',
                    'limit' => '10'
                        )
        );
        $this->set('TopRatedSchool', $topRatedSchool);
    }

//ef

    function admin_school_extimage($id=null) {
        $this->layout = null;
        $this->autoRender = false;
        $_SESSION['ct'] = time();
        $uploaddir = WWW_ROOT . 'img/files/test/';

        $_FILES['uploadfile']['name'] = str_replace(' ', '_', $_FILES['uploadfile']['name']);

        $file = $uploaddir . $_SESSION['ct'] . basename($_FILES['uploadfile']['name']);



        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
            $_SESSION['extra_image'][] = $_SESSION['ct'] . basename($_FILES['uploadfile']['name']);
            echo "success/" . $_SESSION['ct'];
        } else {
            echo "error";
        }
    }

//ef
    // to check the url hit is has a valid record or not

    function checkValidSchool($id=null, $returntype) {

        //$this->autoRender=false;
        if (isset($this->request->data['School']['id'])) {           // this is set id if manipulation is done in html page
            $id = $this->request->data['School']['id'];
        }

        if (!isset($id) || !is_numeric($id)) {

            if ($returntype == 'return') {
                return false;
            } else {
                $this->redirect(array('controller' => 'pages', 'action' => 'notfound'));
            }
        } else {

            $result = $this->School->find('first', array('conditions' => 'School.id=' . $id,
                        'fields' => array('School.id')
                            )
            );

            if (!empty($result)) {
                return;
                exit();
            } else {
                if ($returntype == 'return') {
                    return false;
                } else {
                    $this->redirect(array('controller' => 'pages', 'action' => 'notfound'));
                }
            }
        }
    }

// eof
}

//ec
?>