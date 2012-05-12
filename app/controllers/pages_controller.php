<?php
/**
 *
 */
class PagesController extends AppController {

    var $name = 'Pages';
    var $uses = array();
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Javascript');

    /**
     * Home uLink homepage loader.
     * @param null $msg
     */
    function home($msg=null) {
        if ($msg) {
            $this->set('msg', $msg);
        }

        $this->layout = 'v2';
        $this->pageTitle = 'Your college everything.';
        $this->chkAutopass();
    }

    /**
     *
     */
    function validate_data() {
        if (isset($this->data)) {
            if (!eregi('^[A-Za-z0-9_]+$', $this->data['Message']['url'])) {
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
    function success() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'Your college everything.';
    }

    /**
     * Help page loader
     */
    function help() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'Help';
    }

    /**
     * Advertise page loader
     */
    function advertise() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
    }

    /**
     * Terms page loader
     */
    function terms() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'Terms and Conditions';
    }

    /**
     * About page loader
     */
    function about() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'About Us';
    }
}
?>