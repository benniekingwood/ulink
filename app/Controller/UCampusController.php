<?php
/**
 * This controller handles all page
 * actions for the uCampus module
 */
class UCampusController extends AppController {

    var $name = 'UCampus';
    var $uses = array('Event', 'Trend', 'User');
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Js');

    /**
     * Function that is called before every action
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    /**
     * Handles the uCampus splash page load
     */
    public function index() {

        if (!$this->Auth->User()) {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->layout = "v2_ucampus";
        $this->set('title_for_layout', 'Your college everything.');
        $this->chkAutopass();

        // grab the logged in user off the session
        $activeUser = $this->Auth->User();

        // load the regular events for the logged in user's college
        $events = $this->Event->find('all', array('fields' => array('collegeID', 'eventTitle', 'eventDate', '_id', 'eventInfo'), 'order' => array('Event.eventDate' => 'DESC'), 'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 0, 'active' => 1, 'eventDate.date' => array('$gte' => date("Y-m-d h:m:s")))));
        $this->set('events', $events);


        $schoolName = "";
        // grab the user's school
        $school = $this->School->find('first', array('conditions' => array('School.id' => $activeUser['school_id']), 'fields' => array('woeid', 'name')));
        if ($school != null) {
            $schoolName = $school['School']['name'];
        }
        $this->set('schoolName', $schoolName);

        // grab the tweets for the school
        $tweets = $this->getTweetsBySchool($schoolName, $activeUser['school_id']);
        $this->set('tweets', $tweets);

        // grab the trends based on the school's woeid
        $trends = $this->getTrendsByWOEID($school['School']['woeid'], $activeUser['school_id']);
        if ($trends != null && (count($trends) > 0)) {
            $this->set('trends', $trends);
        }

        // load the featured events for the logged in user's college
        $featureEvents = $this->Event->find('all', array('order' => array('Event.eventDate' => 'ASC'), 'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 1, 'active' => 1, 'eventDate.date' => array('$gte' => date("Y-m-d h:m:s")))));
        $this->set('featureEvents', $featureEvents);
    }


    /**
     * Helper function for comparing tweets based on
     * their created dates
     * @param $a
     * @param $b
     * @return mixed
     */
    public function compareTweetDates($a, $b) {
        $start = strtotime($a['create_at']);
        $end = strtotime($b['create_at']);
        if ($start == $end) {
            return 0;
        }
        return ($start - $end > 0) ? 1 : -1;
    }

    /**
     * This function will build up the queries that will
     * hit Twitter's Search API.  It will randomly choose 25
     * ulink users for the search along with the school name.
     * @param $schoolName
     * @param $schoolID
     */
    private function buildTwitterSearchQueries($schoolName, $schoolID) {
        $retVal = array();
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

        // build up the search queries
        $queries = $this->buildTwitterSearchQueries($schoolName, $schoolID);
        $results = array();
        for ($i = 0; $i < count($queries); $i++) {
            $params = array('q' => $queries[$i], 'pages' => $pageCount, 'rpp' => $tweetsPerPage, 'show_user' => $showUser, 'result_type' => $resultType, 'include_entities' => $includeEntities,);
            $tmhOAuth->request('GET', 'http://search.twitter.com/search.json', $params, false);

            if ($tmhOAuth->response['code'] == 200) {
                $data = json_decode($tmhOAuth->response['response'], true);
                $results = array_merge((array)$results, (array)$data['results']);
            } else {
                $data = htmlentities($tmhOAuth->response['response']);
                $this->log('There was an error.' . PHP_EOL);
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
            }
            array_push($retVal, $tweet);
        }
        return $retVal;
    }

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
        $retVal = null;
        // First check the cache for Trends.
        $trends = $this->Trend->getTrendBySchoolID($schoolID);

        // if there are trends, check to see if they are stale
        if ($trends != null && $this->trendsAreNotStale($trends)) {
            $retVal = $trends[0]['Trend']['trends'];
        } else { // we can search for new trends
            // first remove the stale trends from the cache if there were trends
            if ($trends != null) {
                $this->Trend->delete($trends[0]['Trend']['_id']);
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

            $tmhOAuth->request('GET', 'https://api.twitter.com/1/trends/1.json', $params, false);

            if ($tmhOAuth->response['code'] == 200) {
                $data = json_decode($tmhOAuth->response['response'], true);
            } else {
                $data = htmlentities($tmhOAuth->response['response']);
                $this->log('There was an error.' . PHP_EOL);
            }

            $retVal = array();
            foreach ($data[0]['trends'] as $trend) {
                array_push($retVal, $trend['name']);
            }

            // save the updated trends to the mongo cache
            $schoolTrends = array();
            $schoolTrends['created'] = date("F j, Y, g:i a");
            $schoolTrends['trends'] = $retVal;
            $schoolTrends['collegeID'] = $schoolID;
            $this->Trend->save($schoolTrends);
        }
        return $retVal;
    }

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
    }

    /**
     * This function will return the uLink user
     * based on the passed in Twitter name
     * TODO: only grab users who are not enabled since we will have another method that grabs users that are enabled to prevent duplicate listings
     * @param $twitName
     * @return User
     */
    private function getuLinkUserByTwitterName($twitName) {
        $user = $this->User->find('first', array('fields' => array('User.username', 'User.id', 'User.image_url'), 'conditions' => 'User.twitter_username="' . $twitName . '"'));
        return $user;
    }
}

?>