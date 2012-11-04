<?php
class Event extends AppModel {
        var $name = 'Event';
        var $uses = array('Event');

        var $primaryKey = '_id';
        var $useDbConfig = 'mongo';

		//Relationships dont seem to work accross different datasource types... will be ugly until
		//everything is moved over to mongoDB
		//var $belongsTo = array('School' => array('className' => 'School', 'foreignKey' => 'collegeID'));
		/*var $validate = array(

		      'eventTitle' => array(

			'eventTitleRule-1' => array(

			  'rule' => 'notEmpty', 'message' => 'Please enter your event title.'),

			'eventTitleRule-2' => array(

			  'rule' => array('maxLength', 50), 'message' => 'Your event title should not be longer than 50 characters')

		      ),

		      'eventInfo' => array(

			'eventInfoRule-1' => array(

			  'rule' => 'notEmpty', 'message' => 'Please enter some information about your event.'),

			'eventInfoRule-2' => array(

			  'rule' => array('maxLength', 750), 'message' => 'Event information should not be longer than 750 characters')

		      ),

		      'eventDate' => array(

			'eventDateRule-1' => array(

			  'rule' => 'notEmpty', 'message' => 'Please enter the date of your event.'),

			'eventDateRule-2' => array(

			  'rule' => array('date', 'mdy'), 'message' => 'Event date should be in the MM-DD-YYYY format')
		      )
		 ); */

		public function beforeValidate()
		{
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
            /* Image upload handling */
            // make sure the image is not of type mongoBinData
            if(isset($this->data['Event']['image']) && !($this->data['Event']['image'] instanceof MongoBinData))  {

                if(isset($this->data['Event']['image']['tmp_name']) && strlen($this->data['Event']['image']['tmp_name']) > 0)
                {
                    $fh = fopen($this->data['Event']['image']['tmp_name'], 'r');
                    //Check that the file was opened and is not greater than 1MB
                    if($fh && filesize($this->data['Event']['image']['tmp_name']) <= 1048576)
                    {
                        $content = fread($fh, filesize($this->data['Event']['image']['tmp_name']));
                        fclose($fh);
                        $this->data['Event']['imageType'] = $this->data['Event']['image']['type'];
                        $this->data['Event']['image'] = new MongoBinData($content);
                    }
                    else
                    {
                        return false;
                    }
                } else if ($this->data['Event']['image'] != null &&$this->data['Event']['image']['name'] == '') {
                    unset($this->data['Event']['image']);
                    unset($this->data['Event']['imageType']);
                    unset($this->data['Event']['file']);
                }
               /* else   do not reset, just leave the image
                {
                    $this->data['Event']['imageType'] = "";
                    $this->data['Event']['image'] = "";
                }  */
            }

	    //Santize text from event title and event info
		$this->data['Event']['eventTitle'] = Sanitize::html(Sanitize::stripAll($this->data['Event']['eventTitle']),array('remove' => true));
		$this->data['Event']['eventInfo'] = Sanitize::html(Sanitize::stripAll($this->data['Event']['eventInfo']),array('remove' => true));

			return true;
		}

		/*
		public function beforeSave($options = NULL)
		{

		}
		*/

		public function afterFind($events)
		{
			Controller::loadModel('School');
			Controller::loadModel('User');
			foreach($events as &$event)
			{
				$school = $this->School->findById($event["Event"]["collegeID"]);
				$event["Event"]["collegeName"] = $school["School"]["name"];
				// decode all html special chars
				$event['Event']['eventTitle'] = htmlspecialchars_decode($event['Event']['eventTitle'], ENT_QUOTES);
				$event['Event']['eventInfo'] = htmlspecialchars_decode($event['Event']['eventInfo'], ENT_QUOTES);
			}

			foreach($events as &$event)
			{
				$user = $this->User->findById($event["Event"]["userID"]);
				$event["Event"]["userName"] = $user["User"]["username"];
			}

			return $events;
		}


		public function getActive()
		{
			$events = $this->find('all', array('conditions' => array('active' => '1')));
			return $events;
		}

		public function getNotActive()
		{
			$events = $this->find('all', array('conditions' => array('active' => '0')));
			return $events;
		}

		public function getAll()
		{
			$events = $this->find('all');
			return $events;
		}


}
?>