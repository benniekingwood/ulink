<?php
class Event extends AppModel {
        var $name = 'Event';
        var $primaryKey = '_id';
        var $useDbConfig = 'mongo';
		
		//Relationships dont seem to work accross different datasource types... will be ugly until
		//everything is moved over to mongoDB
		//var $belongsTo = array('School' => array('className' => 'School', 'foreignKey' => 'collegeID'));
		
				
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