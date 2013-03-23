<?php
/*********************************************************************************
 * Copyright (C) 2013 Runtriz. All Rights Reserved.
 *
 * Created On: 3/21/13
 * Description: This controller will handle functions for the Flag model
 ********************************************************************************/
class FlagsController extends AppController {
    var $name = 'Flags';
    var $uses = array('Flag');
    var $helpers = array('Html', 'Form', 'Js');
    public $components = array('Email', 'Session', 'RequestHandler', 'Security', 'Cookie','Auth');

    /**
     * Function that is called before every action
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('insert_flag');
        $this->Security->csrfCheck = false;
        $this->Security->validatePost = false;
    } // beforeFilter


    /******************************************************/
    /*          FLAG API FUNCTIONS                    */
    /******************************************************/

    /**
     * POST API Function to save flags to the db
     * @throws Exception
     */
    public function insert_flag() {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $mobileAuth = isset($this->data['mobile_auth']);

        /*
         * WEB - grab the logged in user off the session
         * MOBILE - check auth token
         */
        $activeUser = null;
        if($mobileAuth != null) {
            $activeUser = array();
            $activeUser['id'] = $this->data['reporter_user_id'];
        } else {
            $activeUser = $this->Auth->User();
        }

        if(!empty($this->data)) {
            $flag = $this->data;
            $flag['Flag']['created'] = date("Y-m-d H:i:s");
            $flag['Flag']['reporter_user_id'] =  $activeUser['id'];

            $this->data = $flag;
            try {
                if($this->Flag->save($this->data)) {
                    $flag['response'] = "true";
                    echo json_encode($flag);
                    exit;
                } else {
                    $flag['response'] = "false";
                    echo json_encode($flag);
                    exit;
                }
            } catch (Exception $e) {
                $this->log("{FlagController#insert_flag} - An exception was thrown:" . $e->getMessage());
                $flag['response'] = "false";
                echo json_encode($flag);
                exit;
            }
        } else {
            $this->log('{FlagController#insert_flag} - Empty data object.');
            $flag['response'] = "false";
            echo json_encode($flag);
            exit;
        }
    } // insert_flag
}