<?php
/*********************************************************************************
* Copyright (C) 2012 uLink, Inc. All Rights Reserved.
*
* Created On: May 22, 2012
* Description: This class handles all the Event object business logic
* Event structure:
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

********************************************************************************/
class EventsController extends AppController {
	var $name = 'Events';
	var $components = array('Session','RequestHandler','Security', 'Cookie','Auth');
	var $helpers = array('Html', 'Form', 'Js','Time');

	/**
	* This method will be called before every action executes
	*/
	public function beforeFilter() {
	       parent::beforeFilter();
	       $this->Auth->allow('add', 'delete', 'edit', 'view', 'toggleActive', 'toggleFeatured', 'insertEvent','myevents');
	       $this->Security->validatePost = false;
	       $this->Security->csrfCheck = false;
	}

	/**
	* This function is called before every page view renders, but
	* call after beforeFilter()
	*/
	public function beforeRender() {
		// if the user is not logged in, make them
		if (!$this->Auth->user()) {
		       $this->redirect(array('controller' => 'users','action' => 'login'));
		}
		if(isset($this->params['url']['ajax']) && $this->params['url']['ajax'] == 1) {
		       $this->layout = 'ajax';
		}
	}

	/**
	 * This function will load the index view of the event controller.
	 * TODO: 8.4.12 - This function will eventually serve as our
	 * events search page.
	 */
	public function index() {
		/*
		 * For now, we are only allowing admin users to
		 * view this page
		 */
		$activeUser = $this->Auth->user();
		if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			$this->redirect(array('controller' => 'ucampus','action' => 'index'));
		}

		$this->layout = 'v2_ucampus';
		try {
			$events = array();
			$events = $this->Event->getAll();
			$this->set('events', $events );
			$this->set('user', $activeUser);
		} catch (Exception $e) {
			$this->log("{EventsController#index} - An exception was thrown: " . $e->getMessage());
		}
	} // index

       public function getEventById($eventID = NULL)
       {
		$this->layout = 'v2_ucampus';

		try {
		if($eventID == NULL)
		{
			$this->flash(__('Invalid Event', true), array('action'=>'index'));
		}
	       $event = $this->Event->read(null, $eventID);

	       $this->set('event', $event);
	       } catch (Exception $e) {
			$this->log("{EventsController#index} - An exception was thrown: " . $e->getMessage());
		}
       } // getEventById

	/**
	 * This will handle the view page actions
	 * @param null $eventID
	 */
	public function view($eventID = NULL)
	{
		$this->layout = 'v2_ucampus';

		try {
			if($eventID == NULL) {
			   $this->flash(__('Invalid Event', true), array('action'=>'index'));
			}

			$event = $this->Event->read(null, $eventID);

			// make sure the user is not attempting to view a event that is not from their school
			// grab the logged in user off the session
			$activeUser = $this->Auth->User();
			// validate the event to make sure the logged in user can delete the event
			if($event['Event']['collegeID'] != $activeUser['school_id']) {
			     $this->Session->setFlash("You can only view events from your school.");
			     $this->redirect('/events/myevents');
			}

			// set the page title to be the school and the event
			$this->set('title_for_layout', $event['Event']['collegeName'] . ' ' . $event['Event']['eventTitle']);

			// format the event so it's more readable
			$date = DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']['date']);
			$event['Event']['eventDate'] = $date->format('F d, Y');
			$this->set('event', $event);

			Controller::loadModel('User');

			// grab the event's user
			$user = $this->User->find('first', array('conditions' => array('User.id' => $event['Event']['userID'])));
			$this->set('eventUser', $user);
		} catch (Exception $e) {
			$this->log("{EventsController#view} - An exception was thrown: " . $e->getMessage());
		}
	} // view

	/**
	 * @param collegeID
	 */
       public function getEventByCollegeId($collegeID = NULL)
       {
		/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }
		$this->layout = 'v2_ucampus';
		try {
			if($collegeID == NULL)
			{
				$this->flash(__('Invalid Event', true), array('action'=>'index'));
			}

		       $events = $this->Event->find('all', array('conditions' => array('collegeID' => $collegeID)));

		       $this->set('events', $events);

		       $this->render('/events/index');
		} catch (Exception $e) {
			$this->log("{EventsController#getEventByCollegeId} - An exception was thrown: " . $e->getMessage());
		}
       } // getEventByCollegeId

       /**
	 * @param collegeID
	 */
       public function getFeaturedEventsByCollegeId($collegeID = NULL)
       {
		/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }
		$this->layout = 'v2_ucampus';
	     try {
		       if($collegeID == NULL)
		       {
			       $this->flash(__('Invalid Event', true), array('action'=>'index'));
		       }
		       $events = $this->Event->find('all', array('conditions' => array('collegeID' => $collegeID, 'featured' => 1, 'active' => 1)));
		       $this->set('events', $events);
		       $this->render('/events/index');
		} catch (Exception $e) {
			$this->log("{EventsController#getFeaturedEventsByCollegeId} - An exception was thrown: " . $e->getMessage());
		}
       } // getFeaturedEventsByCollegeId

       /**
        *
        */
       public function getAllFeaturedEvents()
       {
		/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }
		$this->layout = 'v2_ucampus';
		try {
		$events = $this->Event->find('all', array('conditions' => array('featured' => 1, 'active' => 1)));
	       $this->set('events', $events);
	       $this->render('/events/index');
	       } catch (Exception $e) {
			$this->log("{EventsController#getAllFeaturedEvents} - An exception was thrown: " . $e->getMessage());
		}

       } // getAllFeaturedEvents

       /**
        *
        *
        */
       public function getEventImage($eventID = NULL)
       {
	       Configure::write('debug', 0);
		try {
			$event = $this->Event->read(null, $eventID);
			//If event does not have an image set, return a place holder image
			if(count($event['Event']['image']->bin) <= 0 || !isset($event['Event']['image']->bin))
			{
				$fh = fopen(APP . 'webroot/img/defaults/default_campus_event.png', 'r');
				$content = fread($fh, filesize(APP . 'webroot/img/defaults/default_campus_event.png'));
				fclose($fh);
				$event['Event']['image']->bin = $content;
			}
			$this->set('imageData', $event['Event']['image']->bin);
			$this->set('imageType', $event['Event']['imageType']);
			$this->render('getEventImage', 'eventimage');
		}  catch (Exception $e) {
			$this->log("{EventsController#getEventImage} - An exception was thrown: " . $e->getMessage());
			// if this blows up try to use the default image one more time
			try {
				$fh = fopen(APP . 'webroot/img/defaults/default_campus_event.png', 'r');
				$content = fread($fh, filesize(APP . 'webroot/img/defaults/default_campus_event.png'));
				fclose($fh);
				$event['Event']['image']->bin = $content;
				$this->set('imageData', $event['Event']['image']->bin);
				$this->set('imageType', $event['Event']['imageType']);
				$this->render('getEventImage', 'eventimage');
			} catch (Exception $ee) {} // digest this exception
		}
       } // getEventImage


	/**
	 *  This function will handle the deletion of events
	 * @param eventID
	 */
       public function delete($eventID = NULL)
       {
		$this->layout = 'v2_ucampus';
		try {
		if($eventID == NULL)
		{
		       $this->flash(__('Invalid Event', true), array('action'=>'myevents'));
		}

		$event = $this->Event->read(null, $eventID);
		// grab the logged in user off the session
		$activeUser = $this->Auth->User();

		// validate the event to make sure the logged in user can delete the event
		if($event['Event']['userID'] != $activeUser['id']) {
		    $this->Session->setFlash("That was not your event to delete.");
		    $this->redirect('/events/myevents');
		}

		if($this->Event->delete($eventID))
		{
		       $this->Session->setFlash("Your event was deleted.");
		       $this->redirect('/events/myevents');
		}
		} catch (Exception $e) {
			$this->log("{EventsController#delete} - An exception was thrown: " . $e->getMessage());

		}
       } // delete

	/**
	 *
	 * @param eventID
	 */
       public function edit($eventID = NULL) {
	       $this->layout = "v2";
	       if($eventID == NULL)
	       {
			$this->flash(__('Invalid Event', true), array('action'=>'myevents'));
	       }

	       try {
			$event = $this->Event->read(null, $eventID);
			// grab the logged in user off the session
			$activeUser = $this->Auth->User();
			// validate the event to make sure the logged in user can edit it
			if($event['Event']['userID'] != $activeUser['id']) {
			    $this->Session->setFlash("That was not your event to edit.");
				$this->redirect('/events/myevents');
			}
			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));
			$this->set('schools',$schools);
			$this->set('event',$event);
	       } catch (Exception $x) {
			$this->log("{EventsController#edit} - An exception was thrown when loading the event: " . $e->getMessage());

	       }

		if(empty($this->data))
		{
			try {
		    // format the event so it's more readable
		    $date = DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']['date']);
		    $event['Event']['eventDate'] = $date->format('m/d/Y');
			$this->data = $event;
			} catch (Exception $y) {
				$this->log("{EventsController#edit} - An exception was thrown: " . $e->getMessage());

			}
		}  else { // we are editing the event

			try {
			// first validate the event
			$validateError = "";
			if (empty($this->request->data['Event']['eventTitle'])) {
			    $validateError .= "Please enter your event title.<br />";
			}
			if (empty($this->request->data['Event']['eventInfo'])) {
			    $validateError .="Please enter some information about your event.<br />";
			}
			if (empty($this->request->data['Event']['eventDate'])) {
			    $validateError .= "Please enter the date of your event.";
			}

			if(strlen($validateError) > 1) {
			    $this->Session->setFlash($validateError);
			}  else {
			    $event = $this->data;
			    // format the event date
			    $event['Event']['eventDate']  = DateTime::createFromFormat('m/d/Y', $this->data['Event']['eventDate']);
			    // deactivate the event again
			   // $event['Event']['active'] = 0;
			    $this->data = $event;
			    if($this->Event->save($this->data)) {
				$this->Session->setFlash('<span class="profile-success">Your event has been updated.</span>');
			    } else {
				$this->Session->setFlash("There was a problem updating your event, please try again later.");
			    }
			    $this->redirect('/events/edit/' . $this->data['Event']['_id']);
			}
			} catch (Exception $e) {
				$this->log("{EventsController#edit} - An exception was thrown when editing the event: " . $e->getMessage());
				$this->Session->setFlash("There was a problem updating your event, please try again later.");

			}
		}

	} // edit

	/**
	 * Function used for the submit event component
	 * @return string
	 */
	public function insertEvent() {
		$this->autoRender = false;
		$this->layout = null;
	   Configure:: write('debug', 0);

	   // grab the logged in user off the session
	   $activeUser = $this->Auth->User();

	   if(!empty($this->data)) {

	       $event = $this->data;
	       $event['Event']['eventAdded'] = date("F j, Y, g:i a");
	       $event['Event']['collegeID'] = $activeUser['school_id'];
	       $event['Event']['userID'] =  $activeUser['id'];
	       // format the event date
	       $event['Event']['eventDate']  = DateTime::createFromFormat('m/d/Y', $this->data['Event']['eventDate']);
	       $this->data = $event;
	       try {
		   if($this->Event->save($this->data)) {
		       echo "true";
		       exit;
		   } else {
		       echo "false";
		       exit;
		   }
	       } catch (Exception $e) {
		   $this->log("{EventsController#insertEvent} - An exception was thrown:" . $e->getMessage());
		   echo "false";
		   exit;
	       }
	   } else {
	       $this->log('{EventsController#insertEvent} - Empty data object.');
	       echo "false";
	       exit;
	   }
	} // insertEvent

	/**
	 *
	 *
	 */
       public function add() {
		$this->layout = 'v2_ucampus';

		try {
			/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }

			Controller::loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));
			$this->set('schools',$schools);
			//Get user info to add to event data
			$this->set('user', $activeUser);

			if(!empty($this->data))
			{
				$event = $this->data;
				$event['Event']['eventAdded'] = date("F j, Y, g:i a");
				$this->data = $event;

				if($this->Event->save($this->data))
				{
					$this->Session->setFlash("Event added.");
					$this->redirect('/events');
				} else {
					$this->Session->setFlash("Event did not save.");
					$this->redirect('/events');
				}
			} else {
				$this->log('{EventsController#add} - There was empty data when attempting to add an event.');
			}
		} catch (Exception $e) {
		   $this->log("{EventsController#add} - An exception was thrown:" . $e->getMessage());
	       }
       }

	/**
	 *
	 *
	 */
       public function toggleActive($eventID = NULL)
       {
		/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }
		$this->layout = 'v2_ucampus';

		if($eventID == NULL)
	       {
		       $this->flash(__('Invalid Event', true), array('action'=>'index'));
	       }
		try {
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

	       } catch (Exception $e) {
		   $this->log("{EventsController#toggleActive} - An exception was thrown:" . $e->getMessage());
	       }
       } // toggleActive

       /**
        *
        *
        */
       public function toggleFeatured($eventID = NULL)
       {
				/*
			* For now, we are only allowing admin users to
			* view this page
			*/
		       $activeUser = $this->Auth->user();
		       if(!isset($activeUser['is_admin']) || $activeUser['is_admin'] == '0' || $activeUser['is_admin'] == null) {
			       $this->redirect(array('controller' => 'ucampus','action' => 'index'));
		       }
		$this->layout = 'v2_ucampus';


		if($eventID == NULL)
	       {
		       $this->flash(__('Invalid Event', true), array('action'=>'index'));
	       }
		try {
	       $event = $this->Event->read(null, $eventID);

	       if($event['Event']['featured'] ==0)
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
	     }  catch (Exception $e) {
		   $this->log("{EventsController#toggleFeatured} - An exception was thrown:" . $e->getMessage());
	       }
       } // toggleFeatured

	/**
	 * This function will load the logged in
	 * user's events
	 */
	public function myevents() {
		$this->set('title_for_layout', 'My Events');
		$this->layout = 'v2';
		try {
		// grab the logged in user off the session
		$activeUser = $this->Auth->User();
		$events = $this->Event->find('all', array('fields' => array('collegeID','eventTitle', 'eventDate', '_id', 'eventInfo', 'userID'),'order'=>array('Event.eventDate'=>'DESC'),'conditions' => array('userID' => $activeUser['id'])));
		$this->set('events', $events);
		}  catch (Exception $e) {
		   $this->log("{EventsController#myevents} - An exception was thrown:" . $e->getMessage());
	       }
	} // myevents
}
?>