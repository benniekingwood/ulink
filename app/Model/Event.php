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
 
		 
}
?>