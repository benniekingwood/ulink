<?php
/**
 * This controller handles all page
 * actions for the uCampus module
 */
class UCampusController extends AppController {

    var $name = 'UCampus';
    var $uses = array('Event');
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
            $this->redirect(array('controller' => 'users','action' => 'login'));
        }
        $this->layout = "v2_ucampus";
        $this->set('title_for_layout', 'Your college everything.');
        $this->chkAutopass();

        // grab the logged in user off the session
        $activeUser = $this->Auth->User();

        // load the regular events for the logged in user's college
        $events = $this->Event->find('all', array('fields' => array('collegeID','eventTitle', 'eventDate', '_id', 'eventInfo'),'order'=>array('Event.eventDate'=>'DESC'),'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 0, 'active' => 1,'eventDate.date' => array('$gte' => date("Y-m-d h:m:s")))));
        $this->set('events', $events);

        // load the featured events for the logged in user's college
        $featureEvents = $this->Event->find('all', array('order'=>array('Event.eventDate'=>'ASC'),'conditions' => array('collegeID' => $activeUser['school_id'], 'featured' => 1, 'active' => 1,'eventDate.date' => array('$gte' => date("Y-m-d h:m:s")))));
        $this->set('featureEvents', $featureEvents );

        $schoolName = "";
        // grab the user's school
        if($events != null) {
             $schoolName= $events[0]['Event']['collegeName'];
        }
        $this->set('schoolName', $schoolName);
    }
}
?>