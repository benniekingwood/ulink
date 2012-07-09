<?php
/**
 * This controller handles all basic main page 
 * navigation in uLink
 */
class PagesController extends AppController {

    var $name = 'Pages';
    var $uses = array();
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Js');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    /**
     * Home uLink homepage loader.
     */
    public function home() {
        $this->layout = 'v2';
        $this->set('title_for_layout','Your college everything.');
    }

    /**
     *
     */
    function validate_data() {
        if (isset($this->request->data)) {
            if (!eregi('^[A-Za-z0-9_]+$', $this->request->data['Message']['url'])) {
                echo "Please enter a valid url";
            } else {
                echo "done";
            }
            die('ss');
        }
    }

    /**
     * Success page loader for new users activating
     */
    public function success() {
        $this->layout = "v2";
        $this->set('title_for_layout','Your college everything.');
    }

    /**
     * Help page loader
     */
    public function help() {
        $this->layout = "v2_light";
        $this->set('title_for_layout','Help');
    }

    /**
     * Advertise page loader
     */
    public function advertise() {
        $this->layout = "v2";
        $this->set('title_for_layout', 'Advertise');
    }

    /**
     * Terms page loader
     */
    public function terms() {
        $this->layout = "v2";
        $this->set('title_for_layout', 'Terms and Conditions');
    }

    /**
     * About page loader
     */
    public function about() {
        $this->layout = "v2_light";
        $this->set('title_for_layout',  'About Us');
    }
    
    /**
     * UCampus home page loader
     */
    public function ucampus() {
        if (!$this->Auth->User()) {
            $this->redirect(array('controller' => 'users','action' => 'login'));
        }

        // redirect to uCampus splash page
        $this->redirect(array('controller' => 'ucampus', 'action' => 'index'));
    }
}
?>