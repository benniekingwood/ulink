<?php

class ArticlesController extends AppController {

    var $name = 'Articles';
    var $uses = array('Article');
    var $helpers = array('Html', 'Form', 'Js',  'Session');
    var $components = array('Email', 'RequestHandler', 'Auth', 'Session');
    var $paginate_limit_front = '10';

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    // static pages functions start here

    function index($id=null) {   // To show the news detail
        $this->pageTitle = 'News';
        $newsDetails = $this->Article->find('first', array('conditions' => array('Article.id' => $id)));

        $this->set('newsDetails', $newsDetails);
    }

//ef 
    // function to show the about us article page

    function about_us() {

        $content = $this->Article->find('first', array('conditions' => 'Article.id=1 and status=1'
                        )
        );
        if (!empty($content)) {
            $this->set('Content', $content);
        } else {
            $this->set('under_construction', 1);
        }
    }

#####################administrator function

    function admin_article_index() {
        $this->layout = "admin_dashboard";

        // set/get search to session

        $this->paginate = array(
            'limit' => $this->paginate_limit_front
        );

        if (isset($this->request->data['Article']['searchText'])) {
            $this->Session->write('advancedArticleSearch', $this->request->data['Article']['searchText']);
            $searchText = $this->request->data['Article']['searchText'];
        } elseif ($this->Session->check('advancedArticleSearch')) {

            if (isset($this->request->params['named']['page'])) {
                $searchText = $this->request->data['AdvancedSearch'] = $this->Session->read('advancedArticleSearch');
            } else {
                $this->Session->delete('advancedArticleSearch');
                $searchText = $this->request->data['Article']['searchText'];
            }
        } else {

            $searchText = $this->request->data['Article']['searchText'];
        }

        if (empty($this->request->data)) {
            $article_listing = $this->paginate('Article');
        } else {
            $article_listing = $this->paginate = array('conditions' => array('or' => array(
                        'Article.title LIKE' => '%' . $searchText . '%'
                    )
                ),
                'fields' => array('Article.id', 'Article.title', 'Article.status'),
                'limit' => $this->paginate_limit_front
            );

            $article_listing = $this->paginate('Article');
        }

        $page_no_arr = explode(":", $_REQUEST['url']);
        if (isset($page_no_arr[1]))
            $this->set("page_no", $page_no_arr[1]);

        $this->set('Article', $article_listing);
        $this->set("paginate_limit", $this->paginate_limit_front);
    }

    function admin_article_add() {
        $this->layout = "admin_dashboard";
        if (!empty($this->request->data)) {

            $this->Article->create();

            if (!!$this->Article->save($this->request->data)) {
                $this->Session->setFlash('New Article is added');
                $this->redirect(array('action' => 'article_index'));
            } else {
                $this->Session->setFlash('There was an error Adding article. Please, try again.');
                $this->request->data = null;
            }
        }
    }

// eof

    function admin_article_edit($id = null) {
        $this->layout = "admin_dashboard";
        //$user = $this->Article->read('',$id);	
        if (empty($this->request->data)) {
            $this->request->data = $this->Article->read('', $id);
        } else {
            /* $fileOK = $this->uploadFiles('img/files/articles', $this->request->data['Article']['file']);  
              if(array_key_exists('urls', $fileOK)) {
              // save the url in the form data
              $this->request->data['Article']['image_url'] = $fileOK['urls'][0];
              } */
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash('The Article has been updated.');
                $this->redirect(array('action' => 'article_index'));
            }
        }
    }

//ef

    function admin_article_delete($id=null) {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;
        // check id is valid
        if ($id != null && is_numeric($id)) {
            // get the Item
            $data_del = $this->Article->read(null, $id);

            // check Item is valid
            if (!empty($data_del)) {
                // try deleting the item
                if ($this->Article->delete($id)) {
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

    function admin_article_changeStatus($id=null) {

        Configure::write('debug', 0);
        $this->layout = null;
        $this->autoRender = false;

        $user = $this->Article->find('all', array('conditions' => 'Article.id=' . $id,
                    'fields' => array('Article.id', 'Article.status')
                        )
        );

        if ($user[0]['Article']['status']) {
            $newStatus = "0";
        } else {
            $newStatus = "1";
        }

        $data = array(
            'Article' => array(
                'id' => $id,
                'status' => $newStatus
            )
        );


        if ($this->Article->save($data)) {
            echo $newStatus;
        } else {
            echo "2";  // for unsucess
        }
    }

//ef
}

// end oc class
?>