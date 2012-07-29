<?php
class Event extends AppModel {
        var $name = 'Event';
        var $uses = array('Event');

        var $primaryKey = '_id';
        var $useDbConfig = 'mongo';
		
		//Relationships dont seem to work accross different datasource types... will be ugly until
		//everything is moved over to mongoDB
		//var $belongsTo = array('School' => array('className' => 'School', 'foreignKey' => 'collegeID'));
		
		
		public function beforeValidate()
		{
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
                } else if ($this->data['Event']['image']['name'] == '') {
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

			foreach($events as &$event)
			{
				$school = $this->School->findById($event["Event"]["collegeID"]);
				$event["Event"]["collegeName"] = $school["School"]["name"];
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