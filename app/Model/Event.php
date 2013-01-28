<?php
class Event extends AppModel {
        var $name = 'Event';
        var $uses = array('Event');
	var $primaryKey = '_id';
	/*
	 * NOTE: 1-27-13, we were using mongo, but for now we are going with mysql.
	 * Once we go back to mongo we can make the model, and view changes again.
	 *
	 *	// var $useDbConfig = 'mongo';
	 */

	 public function beforeSave($options = array()) {
		unset($this->data['Event']['user']);
		unset($this->data['Event']['modified']);
		return true;
	}

	public function beforeValidate($options=NULL) {
		App::uses('Sanitize', 'Utility');
		/* Set default values */
		if(!isset($this->data['Event']['active']) || strlen($this->data['Event']['active']) <= 0)
		{
			$this->data['Event']['active'] = 0;
		}
		if(!isset($this->data['Event']['featured']) || strlen($this->data['Event']['featured']) <= 0)
		{
			$this->data['Event']['featured'] = 0;
		}

		//Santize text from event title and event info
		$this->data['Event']['eventTitle'] = Sanitize::html(Sanitize::stripAll($this->data['Event']['eventTitle']),array('remove' => true));
		$this->data['Event']['eventInfo'] = Sanitize::html(Sanitize::stripAll($this->data['Event']['eventInfo']),array('remove' => true));

		return true;
	}


	public function afterFind($events, $primary = FALSE) {
		$School  = ClassRegistry::init('School');
		$User  = ClassRegistry::init('User');
		foreach($events as &$event) {
			/*if(isset($event['Event'][$event['Event']['imageURL'] === '') {
				unset($event['Event']['imageURL']);
			}*/
			$school = $School->findById($event["Event"]["collegeID"]);
			$event["Event"]["collegeName"] = $school["School"]["name"];
			// decode all html special chars
			$event['Event']['eventTitle'] = htmlspecialchars_decode($event['Event']['eventTitle'], ENT_QUOTES);
			$event['Event']['eventInfo'] = htmlspecialchars_decode($event['Event']['eventInfo'], ENT_QUOTES);

			$user = $User->findById($event["Event"]["userID"]);
			unset($user['User']['password']);
			unset($user['School']);
			$event["Event"]["userName"] = $user["User"]["username"];
			$event["Event"]["user"] = $user;
		}
		return $events;
	}


	public function getActive() {
		$events = $this->find('all', array('conditions' => array('active' => '1')));
		return $events;
	}

	public function getNotActive() {
		$events = $this->find('all', array('conditions' => array('active' => '0')));
		return $events;
	}

	public function getAll() {
		$events = $this->find('all');
		return $events;
	}


}
?>