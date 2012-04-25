<?php
/**
 *
 */
class PagesController extends AppController {

    var $name = 'Pages';
    var $uses = array();
    var $components = array('RequestHandler');
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax', 'Jquery');

    /**
     * @param null $msg
     */
    function home($msg=null) {
        if ($msg) {
            $this->set('msg', $msg);
        }

        $this->layout = 'v2';
        $this->pageTitle = 'Your college everything.';
        $this->chkAutopass();
        //Recent added reviews 
       // $recentReview = $this->Review->find('all', array('conditions' => 'Review.status=1',
         //           'order' => 'Review.id DESC'));
        //$this->set('Review', $recentReview);



       // $news = $this->Article->find('all', array('conditions' => 'Article.status=1', 'order' => 'Article.modified DESC'));


        //$this->set('News', $news);
    }

    function success() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
    }

    function validate_data() {
        if (isset($this->data)) {
            if (!eregi('^[A-Za-z0-9_]+$', $this->data['Message']['url'])) {
                echo "Please enter a valid url";
            } else {
                echo "done";
            }
            die('ss');
        }
    }

    function help() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'uLink Help';
        //$data=$this->Page->find('all',array('conditions'=>array('Page.id'=>'1')));
        //$this->set('faqs',$data);
    }

    function advertise() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        //$data=$this->Page->find('all',array('conditions'=>array('Page.id'=>'2')));
        //$this->set('advertisement',$data);
    }

    function terms() {
        $this->set('currentPageHeading', '');
        $this->layout = "v2";
        $this->pageTitle = 'Terms and Conditions';
        //$data=$this->Page->find('all',array('conditions'=>array('Page.id'=>'3')));
        //$this->set('legals',$data);
    }

}

?>