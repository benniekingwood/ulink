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
	       $this->Auth->allow('events', 'insert_event', 'delete_event', 'update_event', 'add', 'delete', 'edit', 'view', 'toggleActive', 'toggleFeatured', 'insertEvent','myevents');
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
			$date = DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']);
			$event['Event']['eventDate'] = $date->format('F d, Y');
			$this->set('event', $event);

			$this->loadModel('User');

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
       public function delete($eventID = NULL) {
		$json = $this->delete_event($eventID, null, null);
		$result = json_decode($json);
		$this->Session->setFlash($result->response);
		$this->redirect('/events/myevents');
		$this->layout = 'v2_ucampus';
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
			 // format the event so it's more readable
			$date = DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate']);
			$event['Event']['eventDate'] = $date->format('m/d/Y');
			$this->loadModel('School');
			$schools = $this->School->find('list',array('fields' => array('id', 'name')));
			$this->set('schools',$schools);
			$this->set('event',$event);
	       } catch (Exception $e) {
			$this->log("{EventsController#edit} - An exception was thrown when loading the event: " . $e->getMessage());

	       }

		if(empty($this->data))
		{
			try {
				$this->data = $event;
			} catch (Exception $y) {
				$this->log("{EventsController#edit} - An exception was thrown: " . $e->getMessage());
			}
		}  else { // we are editing the event
			$json = $this->update_event($this->request->data);
			$result = json_decode($json);
			$this->Session->setFlash($result->response->html);
			$this->redirect('/events/edit/' . $this->data['Event']['_id']);
		}

	} // edit

	/**
	 * Function used for the submit event component
	 * @return string
	 */
	public function insertEvent() {
		$json = $this->insert_event($this->data);
		$results = json_decode($json);
		echo $results->result;
		exit;
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

			$this->loadModel('School');
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
		$events = $this->Event->find('all', array('fields' => array('collegeID','eventTitle', 'eventDate', '_id', 'eventInfo', 'userID', 'imageURL'),'order'=>array('Event.eventDate'=>'DESC'),'conditions' => array('userID' => $activeUser['id'])));
		$this->set('events', $events);
		}  catch (Exception $e) {
		   $this->log("{EventsController#myevents} - An exception was thrown:" . $e->getMessage());
	       }
	} // myevents

    /******************************************************/
    /*          EVENT API FUNCTIONS                       */
    /******************************************************/
	/**
	 * POST API Function that will submit a new
	 * event
	 * @param array $data
	 * @return array $retVal
	 */
	public function insert_event($data=null) {
		$this->autoRender = false;
		$this->layout = null;
		Configure:: write('debug', 0);
		$retVal = array();
		$retVal['result'] = "false";
		$retVal['response'] = '';
		$mobileAuth = isset($this->data['mobile_auth']);

		if($data != null) {
			$this->data = $data;
		}
		/*
		 * WEB - grab the logged in user off the session
		 * MOBILE - check auth token
		 */
		$activeUser = null;
		if($mobileAuth != null) {
		   $activeUser = array();
		   $activeUser['id'] = $this->data['user_id'];
		   $activeUser['school_id'] = $this->data['school_id'];
		} else {
		   $activeUser = $this->Auth->User();
		}

		if(!empty($this->data)) {
		    $event = $this->data;
		    $event['Event']['created'] = date("Y-m-d H:i:s");
		    $event['Event']['collegeID'] = $activeUser['school_id'];
		    $event['Event']['userID'] =  $activeUser['id'];
		    // format the event date
		    $event['Event']['eventDate']  = date('Y-m-d H:i:s', strtotime($this->data['Event']['eventDate'])+86340);

		    // if there is an event image, save it
		    if(isset($this->data['Event']['image'])) {
			$fileOK = $this->uploadFiles('img/files/events', $this->data['Event']['image']);
			if (array_key_exists('urls', $fileOK)) {
			    // save the url in the form data
			    $event['Event']['imageURL'] = $fileOK['urls'][0];
			} else {
			    throw new Exception('The event image did not save correctly to the server.');
			}
			unset($event['Event']['image']);
		    }
		    // remove any unnecessary fields
		    unset($event['mobile_auth']);
		    unset($event['user_id']);
		    unset($event['school_id']);
		    $this->data = $event;
		    try {
			if($this->Event->save($event)) {
			    $responseData = array();
			    $eventData = array();
			    /*
			     * TODO: grab newly created _id and set in response
			     * See if mongo returns the id after inserting a
			     * new document
			     */
			    $eventData['_id'] = "";
		            $eventData['imageURL'] = $this->data['Event']['imageURL'];
			    $responseData['eventdata'] = $eventData;
			    $retVal['response'] = $responseData;
			    $retVal['result'] = "true";
			}
		    } catch (Exception $e) {
			$this->log("{EventsController#insert_event} - An exception was thrown:" . $e->getMessage());
		    }
		} else {
		    $this->log('{EventsController#insert_event} - Empty data object.');
		}

	   return json_encode($retVal);
	} // insert_event

	/**
	 * GET API Function that will return the active events
	 * based on the passed in school id
	 *
	 * @param string $schoolId
	 * @param json $retVal
	 */
	public function events($schoolId = null, $userId = null) {
		$this->autoRender = false;
		$this->layout = null;
		Configure:: write('debug', 0);
		$retVal = array();
		$retVal['result'] = "false";
		$retVal['response'] = '';
		/*
		 * WEB - grab the logged in user off the session
		 * MOBILE - check auth token
		 */
		$activeUser = null;
		if($mobileAuth != null) {
		   $activeUser = array();
		   $activeUser['id'] = $userId;
		} else {
		   $activeUser = $this->Auth->User();
		}

		try {
			$events = $this->Event->find('all', array('fields' => array('collegeID','eventTitle','imageURL', 'eventTime', 'eventLocation', 'eventDate', '_id', 'eventInfo', 'userID', 'featured'), 'order' => array('Event.eventDate' => 'ASC'), 'conditions' => array('collegeID' => $schoolId, 'active' => 1, 'eventDate.date' => array('$gte' => date("Y-m-d h:m:s")))));
			$retVal['result'] = "true";
			$retVal['response'] = $events;
		} catch (Exception $e) {
			$this->log("{EventsController#events} - An exception was thrown: " . $e->getMessage());
		}
		return json_encode($retVal);
	} // events

    /**
     * POST API Function that will update the event
     * @return $retVal json
     */
    public function update_event($data = null) {
	$this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();
	$retVal['result'] = "false";
	$retVal['response'] = "";
	if($data != null) {
            $this->request->data = $data;
        }

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
			$retVal['response'] = $validateError;
		}  else {
		    $event = $this->data;
		    // format the event date
		    //$event['Event']['eventDate']  = DateTime::createFromFormat('m/d/Y', $this->data['Event']['eventDate']);
		    $event['Event']['eventDate'] = date('Y-m-d H:i:s', strtotime($this->data['Event']['eventDate'])+86340);
		    // deactivate the event again
		    // $event['Event']['active'] = 0;

		    // if there is a new image, delete the old one and save the new one
		    if(isset($this->data['Event']['image']['name']) && $this->data['Event']['image']['name'] != "") {
			$fileOK = $this->uploadFiles('img/files/events', $this->data['Event']['image']);

			if (array_key_exists('urls', $fileOK)) {
			    if( $event['Event']['imageURL'] != "" ||  $event['Event']['imageURL'] != null) {
				$filePath = "" . WWW_ROOT . "img/files/events/" . $event['Event']['imageURL'];
				if(file_exists($filePath)) {
					// delete the event image from the server if there was one
					unlink($filePath);
				}
				// remove the old thumb and medium images
				$thumbsURL = "" . WWW_ROOT . "img/files/events/thumbs/" . $event['Event']['imageURL'];
				if(file_exists($thumbsURL)) {
				    // delete the old image
				    unlink($thumbsURL);
				}
				 $mediumFilePath = "" . WWW_ROOT . "img/files/events/medium/" .$event['Event']['imageURL'];
				if(file_exists($mediumFilePath)) {
				    // delete the old image
				    unlink($mediumFilePath);
				}
			     }

			    // save the url in the form data
			    $event['Event']['imageURL'] = $fileOK['urls'][0];
			} else {
			    throw new Exception('The event image did not save correctly to the server.');
			}
			unset($event['Event']['image']);
		    }

		    $this->data = $event;
		    if($this->Event->save($this->data)) {
			$responseData = array();
			$eventData = array();
			$responseData['html'] = '<span class="profile-success">Your event has been updated.</span>';
			$eventData['imageURL'] = $this->data['Event']['imageURL'];
			$responseData['eventdata'] = $eventData;
			$retVal['response'] = $responseData;
			$retVal['result'] = "true";
		    } else {
			$retVal['response'] = "There was a problem updating your event, please try again later.";
		    }
		}
	} catch (Exception $e) {
		$this->log("{EventsController#update_event} - An exception was thrown when editing the event: " . $e->getMessage());
		$retVal['response'] = "There was a problem updating your event, please try again later.";
	}
	return json_encode($retVal);
    }

    /**
     * GET API function will handle the deletion of events
     * @param $id
     * @return json object
     */
    public function delete_event($id = null, $userId = null, $mobileAuth=null) {
        $this->autoRender = false;
        $this->layout = null;
        Configure:: write('debug', 0);
        $retVal = array();

        try {
            if($id == null) {
                $retVal['result'] = 'false';
                $retVal['response'] = 'No id parameter was provided for this request.';
                return json_encode($retVal);
                exit;
            }

            // grab the event from the db
            $event = $this->Event->read(null, $id);
            /*
             * WEB - grab the logged in user off the session
             * MOBILE - check auth token
             */
            $activeUser = null;
            if($mobileAuth != null) {
                $activeUser = array();
                $activeUser['id'] = $userId;
            } else {
                $activeUser = $this->Auth->User();
            }

            // validate the comment to make sure the user can delete the event
            if($event['Event']['userID'] != $activeUser['id']) {
                $retVal['result'] = "false";
                $retVal['response'] = 'That was not your event to delete.';
                return json_encode($retVal);
                exit;
            }

            if($this->Event->delete($id)) {
                $retVal['result'] = 'true';
                $retVal['response'] = 'Your event was successfully deleted.';
		if( $event['Event']['imageURL'] != "" ||  $event['Event']['imageURL'] != null) {
			$filePath = "" . WWW_ROOT . "img/files/events/" . $event['Event']['imageURL'];
			if(file_exists($filePath)) {
				// delete the event image from the server if there was one
				unlink($filePath);
			}
			// remove the old thumb and medium images
			$thumbsURL = "" . WWW_ROOT . "img/files/events/thumbs/" . $event['Event']['imageURL'];
			if(file_exists($thumbsURL)) {
			    // delete the old image
			    unlink($thumbsURL);
			}
			 $mediumFilePath = "" . WWW_ROOT . "img/files/events/medium/" .$event['Event']['imageURL'];
			if(file_exists($mediumFilePath)) {
			    // delete the old image
			    unlink($mediumFilePath);
			}
		}

                return json_encode($retVal);
            }
        } catch (Exception $e) {
                $this->log("{EventsController#delete_event} - An exception was thrown: " . $e->getMessage());
                $retVal['result'] = 'false';
                $retVal['response'] = 'There was a problem deleting the event. Please try again later, or contact help@theulink.com';
                return json_encode($retVal);
                exit;
        }
    } // delete_event
    /******************************************************/
    /*          END EVENT API FUNCTIONS                   */
    /******************************************************/
}
?>