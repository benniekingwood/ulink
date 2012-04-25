<?php

class ReviewsController extends AppController {

    var $name = 'Reviews';
    var $uses = array('Review', 'Country', 'School', 'User');
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax', 'Fck');
    var $paginate_limit = '20';
    var $paginate_limit_front = '10';
    var $paginate = "";

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    // function admin_index() {
    //    $this->redirect(array('action' => 'review_index'));
    //}
//ef 	

    function admin_review_index() {
        //if(isset($_GET['mode'])){
        //$this->log('here in admin_review_index.', 'debug');//}

        $this->layout = "admin_dashboard";

        $this->paginate = array(
            'limit' => $this->paginate_limit_front
        );

        if (isset($this->data['Review']['searchText'])) {
            $this->Session->write('advancedReviewSearch', $this->data['Review']['searchText']);
            $searchText = $this->data['Review']['searchText'];
        } elseif ($this->Session->check('advancedReviewSearch')) {

            if (isset($this->params['named']['page'])) {
                $searchText = $this->data['AdvancedSearch'] = $this->Session->read('advancedReviewSearch');
            } else {
                $this->Session->delete('advancedReviewSearch');
                $searchText = $this->data['Review']['searchText'];
            }
        } else {

            $searchText = $this->data['Review']['searchText'];
        }

        if (empty($this->data)) {
            $this->paginate = array('order' => array('Review.id DESC'));
            $review_listing = $this->paginate('Review');
        } else {
            $review_listing = $this->paginate = array('conditions' => array('or' => array(
                        'Review.title LIKE' => '%' . $searchText . '%',
                        'School.name LIKE' => '%' . $searchText . '%',
                        'User.email LIKE' => '%' . $searchText . '%',
                        'User.firstname LIKE' => '%' . $searchText . '%'
                    )
                ),
                'fields' => array('Review.id', 'Review.title', 'Review.status', 'Review.type', 'Review.rating', 'School.name', 'User.firstname', 'User.lastname', 'User.email'),
                'limit' => $this->paginate_limit_front
            );

            $review_listing = $this->paginate('Review');
        }

        $page_no_arr = explode(":", $_REQUEST['url']);
        if (isset($page_no_arr[1]))
            $this->set("page_no", $page_no_arr[1]);

        $this->set('Review', $review_listing);
        $this->set("paginate_limit", $this->paginate_limit_front);
    }

    function set_paginate_limit() {

        $this->paginate = array('limit' => $this->paginate_limit);
    }

    function admin_review_changeStatus($id=null) {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;

        $review = $this->Review->find('first', array('conditions' => array('Review.id=' . $id)));



        $allReviews = $this->Review->find('first', array('conditions' => array('Review.user_id' => $review['Review']['user_id'], 'Review.id!=' . $id, 'Review.type' => 'text')));




        if (!empty($allReviews)) {

            $this->Review->delete($allReviews['Review']['id']);
        }


        if ($review['Review']['status']) {
            $newStatus = "0";
        } else {
            $newStatus = "1";
        }

        $data = array(
            'Review' => array(
                'id' => $id,
                'status' => $newStatus
            )
        );

        $schoolId = $review['Review']['school_id'];
        $revew_rate = $review['Review']['rating'];
        $rateSchool = $this->School->find('all', array('conditions' => 'School.id=' . $schoolId . ''
                        )
        );

        $currunt_rate = $rateSchool[0]['School']['rating'];
        if ($currunt_rate == 0) {
            $currunt_rate = $revew_rate;
        }  // to handle if the review is first review

        if ($newStatus) {
            $new_rate = round(($currunt_rate + $revew_rate) / 2);
            $data1 = array('School' => array(
                    'id' => $schoolId,
                    'rating' => $new_rate
                )
            );

            $this->School->save($data1);
        }


        if ($this->Review->save($data)) {
            echo $newStatus;
        } else {
            echo 2;
        }
    }

//ef

    function admin_reviews_changeStatus($id=null) {
        $review = $this->Review->find('Review.id=' . $id);

        if ($review['Review']['status']) {
            $newStatus = "0";
        } else {
            $newStatus = "1";
        }

        $data = array(
            'Review' => array(
                'id' => $id,
                'status' => $newStatus
            )
        );




        if ($this->Review->save($data)) {
            $this->Session->setFlash('Review status has been changed.');
            $this->redirect(array('action' => 'review_index'));
        }
    }

//ef

    function admin_review_edit($id = null) {
        $this->layout = 'admin_dashboard';
        $review = $this->Review->find('Review.id=' . $id);

        if (empty($this->data)) {
            $edirRev = $this->data = $this->Review->read('', $id);


            $this->set('ShowRating', $edirRev['Review']['rating']);
            $this->set('status', $edirRev['Review']['status']);
            $this->set('link', $edirRev['Review']['link']);
        } else {

            if ($this->Review->save($this->data)) {
                $this->Session->setFlash('Your Review has been has been updated.');
                $this->redirect(array('action' => 'review_index'));
            }
        }
    }

//ef
    // function to delete the reviews from admin

    function admin_review_delete($id=null) {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;
        // check id is valid
        if ($id != null && is_numeric($id)) {
            // get the Item
            $data_del = $this->Review->read(null, $id);

            // check Item is valid
            if (!empty($data_del)) {
                // try deleting the item
                if ($this->Review->delete($id)) {
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

    function index() {
        $this->layout = "default1";
        $this->log('here in index.', 'debug');
    }

// ef

    function alltextreview($id=null) {

        $this->checkValidSchool($id, 'void');

        $sessVar = $this->Auth->user();
        if ($this->Auth->user()) {
            $usertextreview = $this->Review->find('all', array('conditions' => 'Review.school_id=' . $id . ' and Review.status=1 and Review.type="text"',
                        'order' => 'Review.id DESC and user_id =' . $sessVar['User']['id']
                            )
            );
            $this->set('usertextreview', $usertextreview);
        }



        $this->layout = "default1";

        $alltextreview = $this->Review->find('all', array('conditions' => 'Review.school_id=' . $id . ' and Review.status=1 and Review.type="text"',
                    'order' => 'Review.id DESC'
                        )
        );


        $mytextreview = $this->Review->find('first', array('conditions' => 'Review.school_id=' . $id . ' and Review.type="text" and Review.user_id=' . $this->Auth->user('id'),
                    'order' => 'Review.id DESC'
                        )
        );


        $revCount = count($alltextreview);


        $schoolImage = $this->School->find('all', array('conditions' => 'School.id=' . $id,
                    'fields' => array('School.id', 'School.image_url', 'School.name', 'School.rating', 'School.address')
                        )
        );
        $currentPageHeading = "All Written Reviews of" . " " . $schoolImage[0]['School']['name'];
        $this->pageTitle = $schoolImage[0]['School']['name'] . ' Reviews';
        $this->set('currentPageHeading', $currentPageHeading);
        $this->set('Alltextreview', $alltextreview);
        $this->set('Firstreview', $revCount);
        $this->set('SchoolImage', $schoolImage);
        if (!empty($mytextreview)) {
            $this->set('MyReview', 1);

            if ($mytextreview['Review']['status'] == "0") {
                $this->set('ApprovalPending', 1);
            }
        }

        if ($this->Auth->user('school_id') == $id) {
            $this->set('MySchool', 1);
        }
    }

//ef alltextreview

    function writereview() {
        if (!empty($this->data)) {
            $edit = 0;
            $this->autoRender = false;
            $this->layout = null;
            $this->Review->create();

            $this->data['Review']['rating'] = $this->data['Review']['ratingnew'];
            $revtype = $this->data['Review']['type'];
            $revSid = $this->data['Review']['school_id'];
            $revUid = $this->data['Review']['user_id'];

            $school_id = $this->User->find('all', array('conditions' => array('User.id' => $revUid)));

            if ($school_id[0]['User']['school_id'] != $revSid) {

                die('Sorry, You can only write review about your school.');
            } else {

                $text_review = $this->Review->find('first', array('conditions' => array('Review.user_id' => $this->Auth->user('id') . ' and Review.type="text"')));

                if (!empty($text_review)) {
                    //	$this->data['Review']['id']		=	$text_review['Review']['id'];
                    $edit = 1;
                }


                $this->Review->save($this->data);

                if ($edit) {
                    echo "1";

                    exit();
                } else {
                    echo "2";

                    exit();
                }
            }
        }
    }

//ef
    //Recent added reviews 
    function recentreviews() {
        $this->layout = null;
        $recentReview = $this->Review->find('all', array('conditions' => 'Review.status=1',
                    'order' => 'Review.id DESC',
                    'limit' => '16'
                        )
        );

        $this->set('Review', $recentReview);
    }

    function searchform() {
        $this->layout = null;
    }

// ef    
    ##############################################################  

    function searchresults($page_no = '') {
        $this->layout = 'default1';
        $this->set("page_no", $page_no);
        if (isset($this->data['Map']['search'])) {
            $search_srting = $this->data['Map']['search'];
        } else if (isset($this->data['User']['search'])) {
            $search_srting = $this->data['User']['search'];
        } else if (isset($this->data['Review']['search'])) {
            $search_srting = $this->data['Review']['search'];
        }

        $this->set("search_srting", $search_srting);
        $this->set('type', 'Reviews');
        $this->set('actionType', 'searchresults');
        $this->set('createTypeForm', 'Review');

        $this->set('currentPageHeading', 'Search Reviews');
    }

// ef   

    function search_ajax($search_srting='') {

        $search_srting = str_replace("-", " ", $search_srting);

        $this->set_paginate_limit_search($search_srting); // Setting Paginate Limit 

        $this->layout = null;
        Configure::write('debug', 0);

        $data = $this->paginate();
        $this->set("serchResultsReviews", $data);

        $this->set("paginate_limit", $this->paginate_limit_front);

        // Finding Page No (for Sr. No.)
        $page_no_arr = explode(":", $_REQUEST['url']);

        $this->set("page_no", $page_no_arr[1]);
        $this->set("search_srting", $search_srting);
    }

    function uploadreview_step($item_id = null) {


        Configure::write('debug', 0);
        if (!empty($this->data)) {

            $this->data['Review']['description'] = str_replace('<p>', '', $this->data['Review']['description']);
            $this->data['Review']['description'] = str_replace('</p>', '', $this->data['Review']['description']);
            //	echo $this->data['Review']['description'];


            $this->Session->write("title_data", $this->data['Review']['title']);
            $this->Session->write("description", $this->data['Review']['description']);
            $this->Session->write("rating", $_COOKIE['reviewRating']);
            $this->redirect(array('controller' => 'reviews', 'action' => 'uploadvideoreview/' . $item_id));
        }

        $this->set('currentPageHeading', 'Upload Video Review');
        $this->layout = 'default1';
        if ($this->Auth->user('school_id') != $item_id) {
            $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
        } else {

            $pending_review = $this->Review->find('first', array('conditions' => array('Review.status' => 0, 'Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));
            if (!empty($pending_review) && !$_GET['status']) {
                $this->Session->setFlash('Please wait for the administrator approval');
                $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
            }
        }

        $item = $item_id;

        $reviewnum = $this->Review->find('count', array('conditions' => array('Review.user_id' => $this->Auth->user('id'), 'Review.school_id' => $item_id, 'Review.type' => 'video')));

        $reviews = $this->Review->find('all', array('conditions' => array('Review.user_id' => $this->Auth->user('id'), 'Review.school_id' => $item_id, 'Review.type' => 'video')));


        $this->set('reviews', $reviews);
        if ($_GET['status'] != "200" && $_GET['status'] != "400") {

            $schoolId = $item;
            $shoolreview = $this->School->find('all', array('conditions' => 'School.id=' . $schoolId . ''
                            )
            );
            $randCaptcha = rand(10000, 20000);
            $this->set('RandCaptcha', $randCaptcha);
            $this->set('Shoolreview', $shoolreview);
            $this->set('MyShoolID', $this->Auth->user('school_id'));
        }
    }

    function set_paginate_limit_search($search_srting = '') {

        if ($search_srting == '') {
            $this->paginate = array('conditions' => array('Review.status' => 1), 'order' => array('Review.id desc'), 'limit' => $this->paginate_limit_front);
        } else {
            $this->paginate = array('conditions' => array('or' => array(
                        'Review.title LIKE' => '%' . $search_srting . '%',
                        'Review.rating LIKE' => '%' . $search_srting . '%',
                        'Review.description LIKE' => '%' . $search_srting . '%',
                        'School.name LIKE' => '%' . $search_srting . '%'
                    ),
                    'Review.status' => 1
                ),
                'fields' => array('Review.id', 'Review.title', 'Review.type', 'Review.rating', 'Review.description', 'School.id', 'School.name', 'School.image_url', 'User.firstname', 'User.email'),
                'limit' => $this->paginate_limit_front
            );
        }  // else ends here
    }

// ef
###############################################################	 

    function textreview($id=null) {

        $this->checkValidReview($id, "void", "and Review.status=1 and Review.type='text'");

        $this->layout = "default1";
        $review = $this->Review->find('Review.id=' . $id);
        $this->set('Review', $review);


        $csid = $review['School']['id'];
        $this->pageTitle = $review['School']['name'] . ' Review';

        $otherreview = $this->Review->find('all', array('conditions' => 'Review.id !=' . $id . ' and School.id=' . $csid . ' and Review.status=1 and Review.type="text"',
                    'order' => 'RAND()',
                    'limit' => '3'
                        )
        );
        $this->set('Othereview', $otherreview);


        $othervideoreview = $this->Review->find('all', array('conditions' => 'Review.id !=' . $id . ' and School.id=' . $csid . ' and Review.status=1 and Review.type="video"',
                    'fields' => array('Review.id', 'Review.title', 'Review.link', 'Review.rating', 'School.name'),
                    'order' => 'RAND()',
                    'limit' => '3'
                        )
        );
        $this->set('OtheerVideoReview', $othervideoreview);


        // to incude and perform the youtube zend functions 
        require_once 'Zend/Loader.php'; // setting up the file required
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

        $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                        $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                        $loginToken   = null, $loginCaptcha = null, $authenticationURL
        );
        $developerKey = $this->youtube_dev_key;
        $applicationId = 'Video uploader v1';
        $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
        $yt->setMajorProtocolVersion(2);

        //ends

        for ($j = 0; $j < count($othervideoreview); $j++) {
            $videoEntry = $yt->getVideoEntry($othervideoreview[$j]['Review']['link']);
            $zap[$j] = $this->printVideoEntry($videoEntry);
        } // eof loop to show video thubnails

        $this->set('VideoReviewCaps', $zap);
    }

// ef
    //  video reviews
    function videoreview($id=null) {

        $this->checkValidReview($id, "void", "and Review.status=1 and Review.type='video'");

        $this->layout = 'default1';

        $videoReview = $this->Review->find('all', array('conditions' => 'Review.id=' . $id));
        $this->set('VideoReview', $videoReview);

        $csid = $videoReview[0]['School']['id'];
        $this->pageTitle = $videoReview['School']['name'] . ' Review';

        $otherVideoReview = $this->Review->find('all', array('conditions' => 'School.id=' . $csid . ' and Review.status=1 and Review.type="video"',
                    'order' => 'RAND()'
                        )
        );
        $this->set('OtherVideoReview', $otherVideoReview);

        $otherWrittenReview = $this->Review->find('all', array('conditions' => 'School.id=' . $csid . ' and Review.status=1 and Review.type="text"',
                    'order' => 'RAND()',
                    'limit' => 5
                        )
        );
        $this->set('OtherWrittenReview', $otherWrittenReview);
        $currentPageHeading = "Video Review of" . " " . $videoReview[0]['School']['name'];
        $this->set('currentPageHeading', $currentPageHeading);

        // to brint the particular video caps na dmake them to show in frontend 

        require_once('Zend/Loader.php'); // setting up the file required
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

        $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                        $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                        $loginToken   = null, $loginCaptcha = null, $authenticationURL
        );
        $developerKey = $this->youtube_dev_key;
        $applicationId = 'Video uploader v1';
        $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);

        $yt->setMajorProtocolVersion(2);

        for ($j = 0; $j < count($otherVideoReview); $j++) {
            $videoEntry = $yt->getVideoEntry($otherVideoReview[$j]['Review']['link']);
            $zap[$j] = $this->printVideoEntrySlider($videoEntry);
        } // eof loop to show video thubnails

        $this->set('VideoReviewCaps', $zap);
    }

//ef

    function allvideoreview($id=null) {


        $this->layout = "default1";

        $allvideoreview = $this->Review->find('all', array('conditions' => 'Review.school_id=' . $id . ' and Review.status=1 and Review.type="video"',
                    'order' => 'Review.id DESC'
                        )
        );

        $revCount = count($allvideoreview);


        $schoolImage = $this->School->find('all', array('conditions' => 'School.id=' . $id,
                    'fields' => array('School.id', 'School.image_url', 'School.name', 'School.rating', 'School.address')
                        )
        );

        $myvideoreview = $this->Review->find('first', array('conditions' => 'Review.school_id=' . $id . ' and Review.type="video" and Review.user_id=' . $this->Auth->user('id'),
                    'order' => 'Review.id DESC'
                        )
        );
        $currentPageHeading = "All Video Reviews of" . " " . $schoolImage[0]['School']['name'];
        $this->pageTitle = $schoolImage[0]['School']['name'] . ' Video Reviews';
        $this->set('currentPageHeading', $currentPageHeading);
        if (!empty($myvideoreview)) {
            $this->set('MyReview', 1);
            if ($myvideoreview['Review']['status'] == "0") {
                $this->set('ApprovalPending', 1);
            }
        }

        if ($this->Auth->user('school_id') == $id) {
            $this->set('MySchool', 1);
        }

        $this->set('Allvideoreview', $allvideoreview);
        $this->set('Firstreview', $revCount);
        $this->set('SchoolImage', $schoolImage);



        // to brint the particular video caps na dmake them to show in frontend 

        require_once 'Zend/Loader.php'; // setting up the file required
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

        $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                        $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                        $loginToken   = null, $loginCaptcha = null, $authenticationURL
        );
        $developerKey = $this->youtube_dev_key;
        $applicationId = 'Video uploader v1';
        $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);

        $yt->setMajorProtocolVersion(2);

        for ($j = 0; $j < count($allvideoreview); $j++) {
            $videoEntry = $yt->getVideoEntry($allvideoreview[$j]['Review']['link']);
            $zap[$j] = $this->printVideoEntry($videoEntry);
        } // eof loop to show video thubnails

        $this->set('VideoReviewCaps', $zap);
    }

//ef allvideoreview	

    function printVideoFeed($videoFeed) {
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

    function printVideoEntrySlider($videoEntry) {
        $caps['count'][] = $videoEntry->getVideoViewCount();
        $videoThumbnails = $videoEntry->getVideoThumbnails();

        foreach ($videoThumbnails as $videoThumbnail) {

            $caps['image_thumb'][] = "<img src=" . $videoThumbnail['url'] . " height='97' width='111' />";
            break;
        }
        return $caps;
    }

//ef 

    function getAndPrintUserUploads($userName) {
        $yt = new Zend_Gdata_YouTube();
        $yt->setMajorProtocolVersion(2);
        $this->printVideoFeed($yt->getuserUploads($userName));
    }

    ////////////////////
    // function to edit video 


    function editvideo_step($item_id = null) {
        Configure::write('debug', 0);
        if (!empty($this->data)) {



            // to incude and perform the youtube zend functions 
            require_once 'Zend/Loader.php'; // setting up the file required
            Zend_Loader::loadClass('Zend_Gdata_YouTube');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

            $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                            $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                            $loginToken   = null, $loginCaptcha = null, $authenticationURL
            );
            $developerKey = $this->youtube_dev_key;
            $applicationId = 'Video uploader v1';
            $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
            $yt->setMajorProtocolVersion(2);

            //ends
            echo "<pre>";
            // print_r($this->data);
            // echo "mintu";

            $token = $this->data['Review']['link'];

            $videoEntry = $yt->getVideoEntry($token);

            //  echo "<pre>";
            // print_r($videoEntry->getEditLink()->getHref());
            // echo "himanshi";

            /*  if ($videoEntry->getEditLink() !== null) {
              echo "Video is editable by current user.\n";
              } else {
              echo "nahi chala";
              } */

            $putUrl = $videoEntry->getEditLink()->getHref();
            //echo "<pre>";
            // echo "shakti" . $putUrl;
            //  print_r($putUrl);
            // die('hello');

            $item = $this->data['Review']['school_id'];
            $videoEntry->setVideoDescription($this->data['Review']['description']);
            $videoEntry->setVideoTitle($this->data['Review']['title']);
            $yt->updateEntry($videoEntry, $putUrl);
            if ($this->Review->save($this->data)) {
                $this->Session->setFlash('Your video review has been uploaded and the request has been sent to the administrator for its approval');
                $this->redirect(array('action' => 'editvideo_step/' . $item));
            }




            $this->Session->write("title_data", $this->data['Review']['title']);
            $this->Session->write("description", $this->data['Review']['description']);
            $this->Session->write("rating", $_COOKIE['reviewRating']);
            $this->redirect(array('controller' => 'reviews', 'action' => 'uploadvideoreview/' . $item_id));
        }

        $this->set('currentPageHeading', 'Upload Video Review');
        $this->layout = 'default1';
        if ($this->Auth->user('school_id') != $item_id) {
            $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
        } else {
            $pending_review = $this->Review->find('first', array('conditions' => array('Review.status' => 0, 'Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));
            if (!empty($pending_review) && !$_GET['status']) {
                $this->Session->setFlash('Please wait for the administrator approval');
                $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
            }
        }

        $item = $item_id;

        $reviewnum = $this->Review->find('count', array('conditions' => array('Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));

        $reviews = $this->Review->find('all', array('conditions' => array('Review.user_id' => $this->Auth->user('id'), 'Review.school_id' => $item_id, 'Review.type' => 'video')));
        $this->set('reviews', $reviews);
        if ($_GET['status'] != "200" && $_GET['status'] != "400") {


            $schoolId = $item;
            $shoolreview = $this->School->find('all', array('conditions' => 'School.id=' . $schoolId . ''
                            )
            );
            $randCaptcha = rand(10000, 20000);
            $this->set('RandCaptcha', $randCaptcha);
            $this->set('Shoolreview', $shoolreview);
            $this->set('MyShoolID', $this->Auth->user('school_id'));
        }
    }

    ////////////////








    function uploadvideoreview($item_id=null) {

        $title_data = $this->Session->read('title_data');
        $description = $this->Session->read('description');
        $rating = $this->Session->read('rating');

        $this->set('currentPageHeading', 'Upload Video Review');
        $this->layout = 'default1';
        $sessVar = $this->Auth->user();

        if ($this->Auth->user('school_id') != $item_id) {
            $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
        } else {

            $pending_review = $this->Review->find('first', array('conditions' => array('Review.status' => 0, 'Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));


            if (!empty($pending_review) && !$_GET['status']) {
                $this->Session->setFlash('Your video is being reviewed by an administrator, please check back shortly.');
                $this->redirect(array('controller' => 'reviews', 'action' => 'allvideoreview/' . $item_id));
            }
        }

        $item = $item_id;

        $reviewnum = $this->Review->find('count', array('conditions' => array('Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));

        $reviews = $this->Review->find('all', array('conditions' => array('Review.user_id' => $sessVar['User']['id'], 'Review.school_id' => $item_id, 'Review.type' => 'video')));


        $this->set('reviews', $reviews);
        if ($_GET['status'] != "200" && $_GET['status'] != "400") {

            $schoolId = $item;
            $shoolreview = $this->School->find('all', array('conditions' => 'School.id=' . $schoolId . ''
                            )
            );
            $randCaptcha = rand(10000, 20000);
            $this->set('RandCaptcha', $randCaptcha);
            $this->set('Shoolreview', $shoolreview);
            $this->set('MyShoolID', $this->Auth->user('school_id'));


            require_once 'Zend/Loader.php'; // setting up the file required
            Zend_Loader::loadClass('Zend_Gdata_YouTube');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
            $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';

            $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                            $username = $this->youtube_username, $password = $this->youtube_password, $service = 'youtube', $client = null, $source = 'ulink', // a short string identifying your application
                            $loginToken   = null, $loginCaptcha = null, $authenticationURL
            );



            $developerKey = $this->youtube_dev_key;
            $applicationId = 'Video uploader v1';
            $clientId = '';

            // Note that this example creates an unversioned service object.
            // You do not need to specify a version number to upload content
            // since the upload behavior is the same for all API versions.
            $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);

            // create a new VideoEntry object
            $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();


            $myVideoEntry->setVideoTitle($title_data);
            $myVideoEntry->setVideoDescription($description);

            // The category must be a valid YouTube category!
            $myVideoEntry->setVideoCategory('Education');

            // Set keywords. Please note that this must be a comma-separated string
            // and that individual keywords cannot contain whitespace
            $myVideoEntry->SetVideoTags('schools, reviews');

            $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
            $tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
            $tokenValue = $tokenArray['token'];
            $postUrl = $tokenArray['url'];

            // place to redirect user after upload
            $nextUrl = DEFAULT_URL . '/reviews/uploadvideoreview/' . $item;
            //$nextUrl =  'http://'.$_SERVER['SERVER_NAME'].'/ulink/reviews/uploadvideoreview/'.$item;								  //'http://dev.zapbuild.com/ulink/reviews/uploadvideoreview/'.$item;

            $actionToupload = $postUrl . '?nexturl=' . $nextUrl;
            $this->set('ActionToupload', $actionToupload);
            $this->set('Token', $tokenValue);
        } else if ($_GET['status'] == "200") {
            $sessVar = $this->Auth->user();
            $this->data['Review']['user_id'] = $sessVar['User']['id'];
            $this->data['Review']['school_id'] = $item;
            $this->data['Review']['link'] = $_GET['id'];
            $this->data['Review']['rating'] = $rating;
            $this->data['Review']['title'] = $title_data;
            $this->data['Review']['description'] = $description;
            $this->data['Review']['id'] = $_COOKIE['reviewid'];
            $revtype = $this->data['Review']['type'];
            $revSid = $this->data['Review']['school_id'];
            $revUid = $this->data['Review']['user_id'];
            $this->data['Review']['status'] = 0;
            $school_id = $this->User->find('all', array('conditions' => array('User.id' => $revUid)));
            if ($school_id[0]['User']['school_id'] != $revSid) {
                $this->Session->setFlash('Sorry, You can only submit a review about your school.');
                $this->redirect(array('action' => 'allvideoreview/' . $item));
            }


            $reviewnum = $this->Review->find('first', array('conditions' => array('Review.user_id' => $revUid, 'Review.school_id' => $revSid, 'Review.type' => 'video')));




            if (count($reviewnum)) {

                $this->data['Review']['id'] = $reviewnum['Review']['id'];




                //echo "<pre>";print_r($this->data);exit;
                $this->Review->save($this->data);
                $this->Session->setFlash('Your video review has been uploaded and has been sent to the administrator for its approval');


                $this->redirect(array('action' => 'allvideoreview/' . $item));
            } else {

                unset($this->data['Review']['id']);
                if ($this->Review->save($this->data)) {
                    $this->Session->setFlash('Your video review has been uploaded and has been sent to the administrator for its approval');
                    $this->redirect(array('action' => 'allvideoreview/' . $item));
                } else {
                    $this->Session->setFlash('There was some problem while saving your file. Please try again');
                    $this->redirect(array('action' => 'allvideoreview/' . $item));
                }
            }
        } else if ($_GET['status'] == "400") {
            $this->Session->setFlash('There was a problem uploading your review. Please try again later.');
            $this->redirect(array('action' => 'allvideoreview/' . $item));
        } else {
            $this->Session->setFlash('There was a problem uploading your review. Please try again');
            $this->redirect(array('action' => 'allvideoreview/' . $item));
        }
    }

// ef of function to upload video on youtube
    // to check the valid video

    function checkValidReview($id=null, $returntype, $conditions=null) {

        //$this->autoRender=false;
        if (isset($this->data['Review']['id'])) {           // this is set id if manipulation is done in html page
            $id = $this->data['Review']['id'];
        }

        if (!isset($id) || !is_numeric($id)) {

            if ($returntype == 'return') {
                return false;
            } else {
                $this->redirect(array('controller' => 'pages', 'action' => 'notfound'));
            }
        } else {

            $result = $this->Review->find('first', array('conditions' => 'Review.id=' . $id . ' ' . $conditions,
                        'fields' => array('Review.id')
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

    function checkValidSchool($id=null, $returntype) {

        if (isset($this->data['School']['id'])) {           // this is set id if manipulation is done in html page
            $id = $this->data['School']['id'];
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

    function admin_video() {
        // $this->log('here in admin_video.', 'debug');
        $this->layout = null;
    }

//e 

    function path() { //to check server pathinfo
        // $this->log('here in path.', 'debug');
    }

//e
}

// eoc
?>