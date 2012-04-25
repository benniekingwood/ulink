<?php

class SuggestionsController extends AppController {

    var $name = 'Suggestions';
    var $uses = array('Suggestion', 'User', 'Country', 'State', 'City', 'School', 'Review', 'Domain');
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax', 'Jquery');
    var $components = array('Email', 'Auth', 'Session', 'RequestHandler');
    var $paginate_limit = '5';
    var $paginate_limit_front = '20';
    var $paginate_limit_front_compact = '10';
    var $paginate_limit_admin = '5';
    var $paginate = "";

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    function admin_school_suggestion() {
        $this->layout = "admin_dashboard";
    }

    // to delete a sugesstion

    function admin_suggestion_delete($id=null) {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;
        // check id is valid
        if ($id != null && is_numeric($id)) {
            // get the Item
            $data_del = $this->Suggestion->read(null, $id);

            // check Item is valid
            if (!empty($data_del)) {
                // try deleting the item
                if ($this->Suggestion->delete($id)) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        } else {
            echo "false";
        }
    }

//ef
    // listing o fsuggested schools
    function admin_suggestion_index() {
        $this->layout = "admin_dashboard";

        $this->paginate = array(
            'limit' => $this->paginate_limit_front
        );

        if (isset($this->data['Suggestion']['searchText'])) {
            $this->Session->write('advancedSuggestionSearch', $this->data['Suggestion']['searchText']);
            $searchText = $this->data['Suggestion']['searchText'];
        } elseif ($this->Session->check('advancedSuggestionSearch')) {

            if (isset($this->params['named']['page'])) {
                $searchText = $this->data['AdvancedSearch'] = $this->Session->read('advancedSuggestionSearch');
            } else {
                $this->Session->delete('advancedSuggestionSearch');
                $searchText = $this->data['Suggestion']['searchText'];
            }
        } else {

            $searchText = $this->data['Suggestion']['searchText'];
        }

        if (empty($this->data)) {
            $suggestion_listing = $this->paginate('Suggestion');
        } else {
            $suggestion_listing = $this->paginate = array('conditions' => array('or' => array(
                        'Suggestion.name LIKE' => '%' . $searchText . '%'
                    )
                ),
                'fields' => array('Suggestion.id', 'Suggestion.name'),
                'limit' => $this->paginate_limit_front
            );

            $suggestion_listing = $this->paginate('Suggestion');
        }

        $page_no_arr = explode(":", $_REQUEST['url']);
        if (isset($page_no_arr[1]))
            $this->set("page_no", $page_no_arr[1]);

        $this->set('Suggestion', $suggestion_listing);
        $this->set("paginate_limit", $this->paginate_limit_front);
    }

}

?>