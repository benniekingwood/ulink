<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: Mar 22, 2012
 * Description: This controller handles all page
 *              actions for the uCampus module
 ********************************************************************************/
class UCampusController extends AppController {

    var $name = 'Ucampus';
    var $uses = array('Event', 'Trend', 'User');
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Js');

    /**
     * Function that is called before every action
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'tweets', 'trends');
        $this->Security->csrfCheck = false;
        $this->Security->validatePost = false;
    }

    /******************************************************/
    /*          UCAMPUS API FUNCTIONS                    */
    /******************************************************/
    /**
     * GET API function that will return the tweets based
     * on the passed in school id
     * @param $school_id
     * @return json @retVal
     */
    public function tweets($school_id = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = "";

        // if null attempt to grab from querystring
        if($school_id == null) {
            $school_id = $this->request->query['school_id'];   
        }

        try {
            // grab the school based on the passed in id
            $school = $this->School->find('first', array('conditions' => array('School.id' => $school_id), 'fields' => array('woeid', 'name')));
            $schoolName = "";
            if ($school != null) {
                $schoolName = $school['School']['name'];
            }

            // grab the tweets for the school
            $tweets = $this->getTweetsBySchool($schoolName, $school_id);

            // if the tweets are null, try one more time
            if($tweets==null || count($tweets)==0) {
                $this->log("{UCampusController#tweets}- The tweets loaded from Twitter are empty, retrying.");
                $tweets = $this->getTweetsBySchool($schoolName, $school_id);
                if($tweets==null || count($tweets)==0) {
                    $this->log("{UCampusController#tweets}- On the second attempt, the tweets returned by Twitter were still empty.");
                }
            }
            $retVal['schoolName'] = $schoolName;
            $retVal['result'] = "true";
            $retVal['response'] = $tweets;
        } catch (Exception $e) {
            $this->log("{UCampusController#trends}-An exception was thrown when loading the index page: " . $e->getMessage());
        }
        return json_encode($retVal);
    } // tweets

    /**
     * GET API function that will return the trends based
     * on the passed in school id
     * @param $school_id
     * @return json @retVal
     */
    public function trends($school_id = null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
        $retVal['result'] = "false";
        $retVal['response'] = "";

        // if null attempt to grab from querystring
        if($school_id == null) {
            $school_id = $this->request->query['school_id'];   
        }

        try {
            // grab the school based on the passed in id
            $school = $this->School->find('first', array('conditions' => array('School.id' => $school_id), 'fields' => array('woeid', 'name')));
            $trends = $this->getTrendsByWOEID($school['School']['woeid'], $school_id);
            $retVal['result'] = "true";
            $retVal['response'] = $trends;
        } catch (Exception $e) {
            $this->log("{UCampusController#trends}-An exception was thrown when loading the trends " . $e->getMessage());
        }
        return json_encode($retVal);
    } // trends

    /******************************************************/
    /*          END UCAMPUS API FUNCTIONS                 */
    /******************************************************/

    /**
     * Handles the uCampus splash page load
     */
    public function index() {
        // check to see if the user is logged in, if not, redirect them to login page
        if (!$this->Auth->User()) {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        try {
            $this->chkAutopass();

            // grab the logged in user off the session
            $activeUser = $this->Auth->User();

            // create a yesterday date for retrieving events
            $yesterday = date('Y-m-d', time() - 60*60*24);

            // load the regular events for the logged in user's college
            $events = $this->Event->find('all', array('fields' => array('collegeID', 'eventTitle', 'eventDate', '_id', 'eventInfo', 'userID'), 'order' => array('Event.eventDate' => 'ASC'), 'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 0, 'active' => 1, 'eventDate >' => $yesterday)));
            $this->set('events', $events);

            // grab the tweets for the school
             // grab the school based on the passed in id
            $school = $this->School->find('first', array('conditions' => array('School.id' => $activeUser['school_id']), 'fields' => array('woeid', 'name')));
            $schoolName = "";
            if ($school != null) {
                $schoolName = $school['School']['name'];
            }
            $this->set('schoolName', $schoolName);

            // grab the tweets for the school
            $tweets = $this->getTweetsBySchool($schoolName, $activeUser['school_id']);

            // if the tweets are null, try one more time
            if($tweets==null || count($tweets)==0) {
                $this->log("{UCampusController#index}- The tweets loaded from Twitter are empty, retrying.");
                $tweets = $this->getTweetsBySchool($schoolName, $activeUser['school_id']);
                if($tweets==null || count($tweets)==0) {
                    $this->log("{UCampusController#index}- On the second attempt, the tweets returned by Twitter were still empty.");
                }
            }
            $this->set('tweets', $tweets);

            $json = $this->trends($activeUser['school_id']);
            $result = json_decode($json);
            $trends = $result->response;
            if ($trends != null && (count($trends) > 0)) {
                $this->set('trends', $trends);
            }

            // load the featured events for the logged in user's college
            $featureEvents = $this->Event->find('all', array('order' => array('Event.eventDate' => 'ASC'), 'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 1, 'active' => 1, 'eventDate >' => $yesterday)));
            $this->set('featureEvents', $featureEvents);
        } catch (Exception $e) {
            $this->log("{UCampusController#index}-An exception was thrown when loading the index page: " . $e->getMessage());
        }

        $this->layout = "v2_ucampus";
        $this->set('title_for_layout', 'Your college everything.');
        $this->autoRender = true;
    } // index

    /**
     * This function will build up the queries that will
     * hit Twitter's Search API.  It will randomly choose 25
     * ulink users for the search along with the school name.
     * @param $schoolName
     * @param $schoolID
     */
    private function buildTwitterSearchQueries($schoolName, $schoolID) {
        $retVal = array();
        try {
            // first grab up to 100 Twitter enabled users from uLink
            $twitUsers = $this->User->find('all', array('conditions' => array('twitter_enabled' => 1, 'school_id' => $schoolID), 'fields' => array('twitter_username')));
            if($twitUsers != null) {
                // mix up the users
                shuffle($twitUsers);
                $count = count($twitUsers);
                $query = '';
                for ($i = 0; $i < $count; $i++) {
                    if ($i==0) {
                        $query .= 'from:' . $twitUsers[$i]['User']['twitter_username'];
                    } else {
                        $query .= '+OR+from:' . $twitUsers[$i]['User']['twitter_username'];
                    }
                    if ($count > 10 && $i > 0 && $i % 10 == 0) {
                        // only pull tweets from today
                        $query .= ' since:'.date('Y-m-d');
                        array_push($retVal, $query);
                        // reset the query
                        $query = '';
                    }
                    // break if we hit our limit
                    if($i == 100) {
                        break;
                    }
                }

                // if there are less than 10 users just add the query here
                if($count < 10) {
                    // only pull tweets from today
                    $query .= ' since:'.date('Y-m-d');
                    array_push($retVal, $query);
                }
            }
            // finally add the school to the queries
            array_push($retVal, $schoolName);
        } catch (Exception $e) {
            $this->log("{UCampusController#buildTwitterSearchQuery} - An exception was thrown: " . $e->getMessage());
        }

        return $retVal;
    } // buildTwitterSearchQuery

    /**
     * This method will return the tweets for the passed
     * in school param
     *
     * @param $schoolName
     * @param $schoolID
     * @return array
     */
    private function getTweetsBySchool($schoolName, $schoolID) {
        $tmhOAuth = new tmhOAuth(array());
        $pageCount = '2';
        $tweetsPerPage = '50';
        $showUser = 'true';
        $resultType = 'recent';
        $includeEntities = '1';

        try {
            // build up the search queries
            $queries = $this->buildTwitterSearchQueries($schoolName, $schoolID);
            $results = array();

            // for each query, perform a search against Twitter
            for ($i = 0; $i < count($queries); $i++) {
                $params = array('q' => $queries[$i], 'pages' => $pageCount, 'rpp' => $tweetsPerPage, 'show_user' => $showUser, 'result_type' => $resultType, 'include_entities' => $includeEntities,);
                $tmhOAuth->request('GET', 'http://search.twitter.com/search.json', $params, false);

                // TODO: 8.3.12 - potentially add retry logic if this fails alot
                if ($tmhOAuth->response['code'] == 200) {
                    $data = json_decode($tmhOAuth->response['response'], true);
                    $results = array_merge((array)$results, (array)$data['results']);
                } else {
                    $data = htmlentities($tmhOAuth->response['response']);
                    $this->log('There was an error getting the response back from twitter, response was:' . $tmhOAuth->response['response']);
                    break;
                }
            } // end for

            // sort the results based on their created times
            usort($results, function($a, $b) {
                $start = strtotime($a['created_at']);
                $end = strtotime($b['created_at']);
                if ($start == $end) {
                    return 0;
                }
                return ($start - $end > 0) ? -1 : 1;
            });

            /*
             * Iterate through results grabbing ulink usernames based on
             * twitter username.  If present, add a new entry in the array record
             * In the UI, check to see if uLink username is present if so, set the
             * view profile link, make a link, else show twitter username without link
             */
            $retVal = array();
            foreach ($results as $tweet) {
                // look for ulink username based on the twitter username
                $user = $this->getuLinkUserByTwitterName($tweet['from_user']);
                if ($user != null && $user['User'] != null) {
                    $tweet['ulinkname'] = $user['User']['username'];
                    $tweet['ulinkUserId'] = $user['User']['id'];
                    $tweet['ulinkImageURL'] = $user['User']['image_url'];
                    $tweet['ulinkuser'] = $user['User'];
                }
                // create the short time based on the current time for the tweet (i.e. 2m)
                $tweetTime = strtotime($tweet['created_at']);
                $diff = time() - $tweetTime;
                if ($diff < 60*60) {
                    $tweet['age'] = floor($diff/60) . 'm';
                } elseif ($diff < 60*60*24) {
                    $tweet['age'] = floor($diff/(60*60)) . 'h';
                }
                array_push($retVal, $tweet);
            }
        } catch (Exception $e) {
            $this->log("{UCampusController#getTweetsBySchool} - An exception was thrown: " . $e->getMessage());
        }
        return $retVal;
    } // getTweetsBySchool

    /**
     * This function will retrieve the
     * Twitter trends based on the
     * "where on earth id" (woeid)
     *
     * @param $woeid
     * @param $schoolID
     * @return array
     */
    private function getTrendsByWOEID($woeid, $schoolID) {
        $retVal = array();
        try {
            // First check the cache for Trends.
            $trends = $this->Trend->getTrendBySchoolID($schoolID);
            // if there are trends, check to see if they are stale
            if ($trends != null && $this->trendsAreNotStale($trends)) {
                // grab all the trends for the school
                foreach ($trends as $trend) {
                    array_push($retVal, $trend['Trend']['name']);
                }
            } else { // we can search for new trends
                // first remove the stale trends from the cache if there were trends
                if ($trends != null) {
                    $this->Trend->deleteBySchoolID($schoolID);
                }

                $tmhOAuth = new tmhOAuth(array());
                $exclude = '';
                $params = array('woeid' => $woeid, 'exclude' => $exclude);

                foreach ($params as $k => $v) :
                    $p[$k] = $v;
                    if (empty($p[$k])) {
                        unset($p[$k]);
                    }
                endforeach;

                // send the request to Twitter
                $tmhOAuth->request('GET', 'https://api.twitter.com/1/trends/1.json', $params, false);

                if ($tmhOAuth->response['code'] == 200) {
                    $data = json_decode($tmhOAuth->response['response'], true);
                } else {
                    $data = htmlentities($tmhOAuth->response['response']);
                    $this->log('There was an error getting the response back from twitter, response was:' . $tmhOAuth->response['response']);
                }

                for ($idx = 0; $idx < 5; $idx++) {
                    array_push($retVal, $data[0]['trends'][$idx]['name']);
                     // save the updated trends to the db
                    $this->Trend->create();
                    $schoolTrends =  array('Trend' => array());
                    $schoolTrends['Trend']['created'] = date('Y-m-d H:i:s');
                    $schoolTrends['Trend']['name'] = $data[0]['trends'][$idx]['name'];
                    $schoolTrends['Trend']['collegeID'] = $schoolID;
                    $this->Trend->save($schoolTrends);
                }
            }
        } catch (Exception $e) {
            $this->log("{UCampusController#getTrendsByWOEID} - An exception was thrown: " . $e->getMessage());
        }
        return $retVal;
    } // getTrendsByWOEID

    /**
     * This function will determine if the trends are stale
     * based on their created time stamp.  As of now
     * we are saying for a trend to be stale it has to
     * be older than 2 hours.
     *
     * @param $trends
     */
    private function trendsAreNotStale($trends) {
        $staleLimit = 120; // minutes
        $trendTime = strtotime($trends[0]['Trend']['created']);
        $trendAge = round(abs(time() - $trendTime) / 60, 0);
        return ($trendAge <= $staleLimit);
    } // trendsAreNotStale

    /**
     * This function will return the uLink user
     * based on the passed in Twitter name
     * The user has to be enabled for tweets as well.
     * @param $twitName
     * @return User
     */
    private function getuLinkUserByTwitterName($twitName) {
        $user = null;
        try {
            $user = $this->User->find('first', array('fields' => array('User.username', 'User.id', 'User.image_url', 'User.firstname', 'User.lastname', 'User.bio', 'User.school_status', 'User.year'), 'conditions' => array('User.twitter_username' => $twitName, 'User.twitter_enabled' => 1)));
        } catch (Exception $e) {
            $this->log("{UCampusController#getuLinkUserByTwitterName}-An exception was thrown:" . $e->getMessage());
        }
        return $user;
    } // getuLinkUserByTwitterName
}

?>
