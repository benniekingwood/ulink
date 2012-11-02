<?php
/*********************************************************************************
 * Copyright (C) 2012 uLink, Inc. All Rights Reserved.
 *
 * Created On: 10/20/12
 * Description:  This class will hold the snapshot information
 *  Model attributes: _id, userId, schoolId, category, caption, comments, created, imageURL
 ********************************************************************************/
class Snapshot extends AppModel {
	var $name = 'Snapshot';
	var $uses = array('Snapshot', 'SnapshotCategory', 'SnapshotComment', 'User');
	var $primaryKey = '_id';
	var $useDbConfig = 'mongo';

	/**
	 * This function is called before cake validates the
	 * model object.  This will sanitize the snap caption.
	 */
	public function beforeValidate() {
		App::uses('Sanitize', 'Utility');
		//Santize text from snap caption
		$this->data['Snapshot']['caption'] = Sanitize::html(Sanitize::stripAll($this->data['Snapshot']['caption']),array('remove' => true));
		return true;
	}

	/**
	 * After a snapshot(s) is retreived, we need to load
	 * all associated data with the snaps
	 */
        public function afterFind($snaps) {
		Controller::loadModel('User');
		Controller::loadModel('SnapshotComment');
		// load the user and comments for each snap
                foreach($snaps as &$snap) {
			$user = $this->User->findById($snap["Snapshot"]["userId"]);
                        $snap["Snapshot"]["user"] = $user;
                        $comments = $this->SnapshotComment->getSnapshotCommentBySnapId($snap["Snapshot"]["_id"]);
                        $snap["Snapshot"]["comments"] = $comments;
                }
                return $snaps;
        }

	/**
	 * Helper method to return the snapshot by the id
	 * @param id
	 * @return Snapshot
	 */
	public function findById($id) {
		return $this->find('first', array('conditions' => array('_id' => $id)));
	}


	/**
	 * Helper method to return the snaps by the school id
	 * @param schoolId
	 * @return list of snapshots
	 */
	public function getSnapsBySchoolId($schoolId) {
		return $this->find('all', array('conditions' => array('schoolId' => $schoolId)));
	}

	/**
	 * Helper method to return the snaps by the school id and category.
	 * A limit will also be applied.  Will default to 50.
	 * @param schoolId
	 * @param category
	 * @return list of snapshots
	 */
	public function getSnapsBySchoolIdAndCategory($schoolId, $category, $limit=50) {
		return $this->find('all', array('limit' => $limit, 'conditions' => array('schoolId' => $schoolId, 'category' => $category)));
	}

	/**
	 * Helper function that will return four random snaps for a school.
	 * These snapshots will be shown on the splash page.
	 * @param schoolId
	 * @return array
	 */
	public function getSplashSnapsBySchoolId($schoolId) {
		$retVal = array();
		// grab the snap categories
		Controller::loadModel('SnapshotCategory');
		$snapCategories = $this->SnapshotCategory->getAll();
		shuffle($snapCategories);
		for($x=0;$x<count($snapCategories);$x++) {
			// grab a random image from the category and put into return array
			$snap = $this->getSnapsBySchoolIdAndCategory($schoolId, $snapCategories[$x]['SnapshotCategory']['_id'], 1);
			if($snap != null) {
				array_push($retVal, $snap);
			}

			if($x==3) {
				break;
			}
		}
		return $retVal;
	}

	/**
	 * Helper function that will fully delete teh Snapshot, and it's associated
	 * data members.
	 * @param $id
	 * @return void
	 */
	public function deleteSnapshot($id) {
		Controller::loadModel('SnapshotComment');
		// first delete all Snapshot comments that have this snap id
		$this->SnapshotComment->deleteAll(array('snapId' => $id));
		// finally delete this Snapshot
		return $this->delete($id);
	}
}
?>