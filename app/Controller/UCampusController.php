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
        $this->Auth->allow();
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

        // load the events
        $events = array();
        $events = $this->Event->getAll();
        $this->set('events', $events );
        // load the featured events
    }
}
?>