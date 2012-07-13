<?php

class EventsController extends AppController {
        
        var $name = 'Events';
		var $components = array('Auth', 'Session','RequestHandler');
		var $helpers = array('Html', 'Form', 'Js','Time');
		

		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow();
			$this->Security->enabled = false;
			$this->Security->validatePost = false;
			
		}
		
		function beforeRender()
		{
			if(isset($this->params['url']['ajax']) && $this->params['url']['ajax'] == 1)
			{
				$this->layout = 'ajax';
			}
			else
			{
				$this->layout = 'v2';
			}
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
			["featured"] Wether or not event is featured
			
			["collegeName"] not part of DB model, added in Event's afterFind callback to associate collegeID with the school model stored in MySQL
		*/
		
        public function index() {
				
				
				$events = array();
				$events = $this->Event->getAll();
					
                $this->set('events', $events );
							
				//$this->Event->create();
				//$data = array("Event" => array('userID' => '10', 'collegeID' => '12', 'eventInfo' => 'This is from Cake'));
				//$this->Event->save($data);
        }
		
		public function getEventById($eventID = NULL)
		{
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$event = $this->Event->read(null, $eventID);
			
			$this->set('event', $event);
			
		}
		
		public function getEventByCollegeId($collegeID = NULL)
		{
			if($collegeID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$events = $this->Event->find('all', array('conditions' => array('collegeID' => $collegeID)));
			
			$this->set('events', $events);
			
			$this->render('/events/index');
			
		}
		
		public function getFeaturedEventsByCollegeId($collegeID = NULL)
		{
			if($collegeID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$events = $this->Event->find('all', array('conditions' => array('collegeID' => $collegeID, 'featured' => 1, 'active' => 1)));
			
			$this->set('events', $events);
			
			$this->render('/events/index');
			
		}
		
		public function getAllFeaturedEvents()
		{
			
			
			$events = $this->Event->find('all', array('conditions' => array('featured' => 1, 'active' => 1)));
			
			$this->set('events', $events);
			
			//die($this->layout);
			
			$this->render('/events/index');
			
		}
		
		public function getEventImage($eventID = NULL)
		{
			Configure::write('debug', 0);
			
			$event = $this->Event->read(null, $eventID);
			
			//If event does not have an image set, return a place holder image
			if(count($event['Event']['image']->bin) <= 0 || !isset($event['Event']['image']->bin))
			{				
				$fh = fopen(APP . 'webroot/img/placeholder.jpg', 'r');
				$content = fread($fh, filesize(APP . 'webroot/img/placeholder.jpg'));
				fclose($fh);
				$event['Event']['image']->bin = $content;
			}
			
			$this->set('imageData', $event['Event']['image']->bin);
			$this->set('imageType', $event['Event']['imageType']);
			
						
			$this->render('getEventImage', 'eventimage');
		}

		
		public function delete($eventID = NULL)
		{
			
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
			
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$event = $this->Event->read(null, $eventID);
			
			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));			
			$this->set('schools',$schools);
			$this->set('event',$event);
			
			if(empty($this->data))
			{
				$this->data = $event;
			}
			else
			{
				
				if($this->Event->save($this->data))
				{
					$this->Session->setFlash("Event updated.");
					$this->redirect('/events');
				}
				else
				{
					$this->Session->setFlash("Error updating event.");
					$this->redirect('/events/edit/' . $this->data['Event']['_id']);
				}
			}
		}
		
		public function add() {
			
			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));			
			$this->set('schools',$schools);
			
						
			//$eventData["Event"]["image"] = "Hello";
			//$this->set('test', $eventData);
						
			
			if(!empty($this->data))
			{
								
				if($this->Event->save($this->data))
				{
					$this->Session->setFlash("Event added.");
					$this->redirect('/events');
				}
			}
			
		}
		
		public function toggleActive($eventID = NULL)
		{
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$event = $this->Event->read(null, $eventID);
			
			if($event['Event']['active'] == 0)
			{
				$event['Event']['active'] = 1;
			}
			else
			{
				$event['Event']['active'] = 0;
			}
			
			if($this->Event->save($event))
			{
				$this->Session->setFlash("Event updated.");
				$this->redirect('/events');
			}
		}
		
		public function toggleFeatured($eventID = NULL)
		{
			if($eventID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}
			
			$event = $this->Event->read(null, $eventID);
			
			if($event['Event']['featured'] == 0)
			{
				$event['Event']['featured'] = 1;
			}
			else
			{
				$event['Event']['featured'] = 0;
			}
			
			if($this->Event->save($event))
			{
				$this->Session->setFlash("Event updated.");
				$this->redirect('/events');
			}
		}

}


?>