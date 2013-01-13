<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 10/20/12
 * Description:  This class will hold the snapshot comment
 *  Model attributes: _id, userId, comment, created
 ********************************************************************************/
class SnapshotComment extends AppModel {
    var $name = 'SnapshotComment';
    var $uses = array('SnapshotComment');
    var $primaryKey = '_id';
    var $useDbConfig = 'mongo';

    /**
     * This function is called before cake validates the
     * model object.  This will sanitize the snap comment.
     */
    public function beforeValidate() {
            App::uses('Sanitize', 'Utility');
            //Santize text from snap caption
            $this->data['SnapshotComment']['comment'] = Sanitize::html(Sanitize::stripAll($this->data['SnapshotComment']['comment']),array('remove' => true));
            return true;
    }


    /**
     * After a snapshot comment is retreived, we need to load
     * all associated data with the snaps
     */
    public function afterFind($snapComments) {
            Controller::loadModel('User');
            // load the user and comments for each snap
            foreach($snapComments as &$snapComment) {
                    $user = $this->User->findById($snapComment["SnapshotComment"]["userId"]);
                    if(isset($user['User']['password'])) {
                        unset($user['User']['password']);
                    }
                    if(isset($user['School'])) {
                        unset($user['School']);
                    }
                    $snapComment["SnapshotComment"]["user_image_url"] = $user['User']['image_url'];
                    $snapComment["SnapshotComment"]["user_username"] = $user['User']['username'];
                    $snapComment["SnapshotComment"]["user_bio"] = $user['User']['bio'];
                    $snapComment["SnapshotComment"]["user_year"] = $user['User']['year'];
                    $snapComment["SnapshotComment"]["user_firstname"] = $user['User']['firstname'];
                    $snapComment["SnapshotComment"]["user_lastname"] = $user['User']['lastname'];
                    $snapComment["SnapshotComment"]["user_school_status"] = $user['User']['school_status'];
                    $snapComment['SnapshotComment']['created_short'] = date('M j, Y', strtotime($snapComment['SnapshotComment']['created']));
                    // decode all html special chars
		    $snapComment['SnapshotComment']['comment'] = htmlspecialchars_decode($snapComment['SnapshotComment']['comment'], ENT_QUOTES);
            }
            return $snapComments;
    }

    /**
    * This function will return the SnapshotComment based on the snap Id
    * @param null $snapId
    * @return array|null
    */
   public function getSnapshotCommentBySnapId($snapId = null) {
       $retVal = null;
       try {
           $retVal = $this->find('all', array('conditions' => array('snapId' => $snapId)));
       } catch (Exception $e) {
           $this->log('{SnapshotComment#getSnapshotCommentBySnapId} - An exception was thrown: ' . $e->getMessage());
       }
       return $retVal;
   }
}
?>