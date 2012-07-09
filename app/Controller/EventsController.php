<?php

class EventsController extends AppController {
        
        var $name = 'Events';
		var $components = array('RequestHandler');
		var $helpers = array('Html', 'Form', 'Js','Time');
		

		function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow();
		}
		
		/*
		Event structure:
		["Event"]
			["_id"] MongoDB's automatically generated ObjectID
			["userID"] Primary key of user that created the event
			["collegeID"] Primary key of school the event is fore
			["eventDate"]
			["eventAdded"]
				Both eventDate and eventAdded are stored in the format: year-month-day hour(24):minute:second GMT offset, from PHP's function date('Y-m-d H:i:s O')
				i.e. "2012-06-10 13:53:44 -0400"
			["eventTitle"] Short description of event
			["eventInfo"] Detailed description of event
			["active"] Wether or not event is active
			
			["collegeName"] not part of DB model, added in Event's afterFind callback to associate collegeID with the school model stored in MySQL
		*/
		
        public function index() {
				$this->layout = 'v2';
				$this->pageTitle = 'Your college everything.';
				$this->chkAutopass();
				//echo "<pre>";
				//var_dump($this->params);
				//echo "</pre>";
				
				$events = array();
				$events = $this->Event->getAll();
					
                $this->set('events', $events );
							
				//$this->Event->create();
				//$data = array("Event" => array('userID' => '10', 'collegeID' => '12', 'eventInfo' => 'This is from Cake'));
				//$this->Event->save($data);
        }
		
		public function delete($eventID = NULL)
		{
			$this->layout = 'v2';
			$this->pageTitle = 'Your college everything.';
			$this->chkAutopass();
			
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			if($this->Event->delete($eventID))
			{
				$this->Session->setFlash("Event Deleted.");
				$this->redirect('/events');
			}
			
		}
		
		
		public function edit($eventID = NULL) {
			
			$this->layout = 'v2';
			$this->pageTitle = 'Your college everything.';
			$this->chkAutopass();
			
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$event = $this->Event->read(null, $eventID);
			
			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));			
			$this->set('schools',$schools);
			
			if(empty($this->data))
			{
				$this->data = $event;
			}
			else
			{
				echo "<pre>"; var_dump($this->data); echo "</pre>";
				if($this->Event->save($this->data))
				{
					$this->Session->setFlash("Event updated.");
					$this->redirect('/events');
				}
			}
		}
		
		public function add() {
			
			$this->layout = 'v2';
			$this->pageTitle = 'Your college everything.';
			$this->chkAutopass();
			
			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));			
			$this->set('schools',$schools);
						
			
			if(!empty($this->data))
			{
				
				if($this->Event->save($this->data))
				{
					$this->Session->setFlash("Event added.");
					$this->redirect('/events');
				}
			}
			
		}

}


?>