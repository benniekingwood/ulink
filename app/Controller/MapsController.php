<?php

class MapsController extends AppController {

    var $name = 'Maps';
    var $uses = array('School', 'Review');
    var $ip;
    protected $api = "http://66.84.41.158/ip/?ip=";
    var $curl;

    function map_index($mapid=NULL) {

        $this->pageTitle = 'Map of schools';
        App::import('Vendor', 'ipinfodb');
        $ipinfodb = new ipinfodb;
        $ipinfodb->setKey(IPINFODB_KEY);
        $userLatitiude = 0;
        $userLongitude = 0;
        //Get errors and locations
        $this->chkAutopass();

        $locations = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);
        if (!empty($locations) && is_array($locations)) {
            foreach ($locations as $field => $val) {
                if (strtolower($field) == 'latitude') {
                    //  echo $field . ' : ' . $val . "<br />\n";
                    $userLatitiude = $val;
                }
                if (strtolower($field) == 'longitude') {
                    //echo $field . ' : ' . $val . "<br />\n";
                    $userLongitude = $val;
                }
            }
        }


        if ($this->Auth->user($id = NULL)) {
            $myTextReview = $this->Review->find('all', array('conditions' => array('Review.school_id' => $this->Auth->user('school_id'), 'Review.type' => 'text', 'Review.user_id' => $this->Auth->user('id'))));
        }
        if (!empty($myTextReview)) {
            foreach ($myTextReview as $myReview) {
                if ($myReview['Review']['status'] == 0) {
                    $this->set('MyReview', 0);
                } else if ($myReview['Review']['status'] == 1) {
                    $this->set('MyReview', 1);
                }
            }
        } else {
            $this->set('MyReview', 2);
        }

        $this->set('UserLatitiude', $userLatitiude);
        $this->set('UserLongitude', $userLongitude);

        $this->set('currentPageHeading', 'Search Map');


        if (empty($this->request->data)) {

            $this->School->bindModel(array(
                'hasMany' => array(
                    'Review' => array(
                        'foreignKey' => 'school_id',
                        'type' => 'RIGHT',
                        'conditions' => array('Review.status =1')
                    )
                )
                    ), false
            );

            if (isset($mapid)) {

                $data = $this->School->find('all', array('conditions' => array('School.id' => $mapid)));
                if ($data[0]['School']['longitude'] != "") {         // to set the center on map for the search result
                    $this->set('UserLatitiude', $data[0]['School']['latitude']);
                    $this->set('UserLongitude', $data[0]['School']['longitude']);
                }

                // $data=$this->School->find('all');
                $this->set('schools', $data);
            } else {
                $data = $this->School->find('all');

//                if ($data[0]['School']['longitude'] != "") {         // to set the center on map for the search result
//                    $this->set('UserLatitiude', $data[0]['School']['latitude']);
//                    $this->set('UserLongitude', $data[0]['School']['longitude']);
//                }

                $this->set('schools', $data);
            }
        } else {

            if (isset($this->request->data['Map']['search'])) {
                $searchText = $this->request->data['Map']['search'];
            } else if (isset($this->request->data['User']['search'])) {
                $searchText = $this->request->data['User']['search'];
            } else if (isset($this->request->data['Review']['search'])) {
                $searchText = $this->request->data['Review']['search'];
            }

            $this->set('search_srting', $searchText);
            $this->set('type', 'Map');
            $this->School->bindModel(array(
                'hasMany' => array(
                    'Review' => array(
                        'foreignKey' => 'school_id',
                        'type' => 'RIGHT',
                        'conditions' => array('Review.status =1')
                    )
                )
                    ), false
            );

            $data = $this->School->find('all', array('conditions' => array('or' => array(
                                'School.name LIKE' => '%' . $searchText . '%',
                                'School.year LIKE' => '%' . $searchText . '%',
                                'School.type LIKE' => '%' . $searchText . '%',
                                'School.description LIKE' => '%' . $searchText . '%',
                                'School.address LIKE' => '%' . $searchText . '%',
                                'Country.countries_name LIKE' => '%' . $searchText . '%',
                                'State.name LIKE' => '%' . $searchText . '%',
                                'City.name LIKE' => '%' . $searchText . '%')))
            );


            if ($data[0]['School']['longitude'] != "") {         // to set the center on map for the search result
                $this->set('UserLatitiude', $data[0]['School']['latitude']);
                $this->set('UserLongitude', $data[0]['School']['longitude']);
            }

            // $data = $this->School->find('all');
            //echo "<pre>";
            //print_r($data);
            //die('hello');

            if ($data != null) {
                $this->set('currentPageHeading', count($data) . ' schools found.');
            } else {
                $this->set('currentPageHeading', 'No schools found.');
            }

            $this->set('schools', $data);
        }
    }

//ef

    function index() {
        $this->redirect(array('action' => 'map_index'));
    }

//ef

    function searchform() {
        $this->layout = null;
    }

// ef
    ####################Functions to Find latitude and longitude according to the ip address

    public function ipdetails($ipaddress) {

        $this->ip = $ipaddress;
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $this->api . $this->ip);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        return true;
    }

//ef

    public function scan() {
        $this->xml = curl_exec($this->curl);
        preg_match_all('/<([a-zA-Z0-9].*)>(.*)<\/([a-zA-Z0-9].*?)>\n/', $this->xml, $detail);
        $this->details = null;
        $this->details = array();
        for ($i = 0; $i <= count($detail[1]) - 1; $i++) {
            $this->details[trim($detail[1][$i])] = $detail[2][$i];
        }
        return true;
    }

//ef

    public function get_latitude() {
        return $this->details[Latitude];
    }

//ef

    /**
     * Return the Longitude of the given ip address
     * @access public
     * @return void
     */
    public function get_longitude() {
        return $this->details[Longitude];
    }

    public function close() {
        curl_close($this->curl);
        return true;
    }

//ef
    #######################
}

?>