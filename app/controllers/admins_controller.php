<?php

class AdminsController extends AppController {

    var $name = 'Admins';
    var $uses = array('Admin', 'User', 'Review', 'Suggestion');
    var $components = array('Cookie', 'Email');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    function admin_index() {
        $curr_date = date('Y-m-01', time());
        $total_users = $this->User->find('count');
        $total_pending_users = $this->User->find('count', array('conditions' => array('User.activation' => 1)));
        $total_active_users = $this->User->find('count', array('conditions' => array('User.activation' => 0)));
        $this->set('total_users', $total_users);
        $this->set('total_pending_users', $total_pending_users);
        $this->set('total_active_users', $total_active_users);
        $this->layout = 'admin_dashboard';
        $total_current_month_users = $this->User->find('count', array('conditions' => array('User.created >= "' . $curr_date . '"')));
        $total_current_month_pending_users = $this->User->find('count', array('conditions' => array('User.activation' => 1, 'User.created >="' . $curr_date . '"')));
        $total_current_month_active_users = $this->User->find('count', array('conditions' => array('User.activation' => 0, 'User.created >="' . $curr_date . '"')));
        $this->set('total_current_month_users', $total_current_month_users);
        $this->set('total_current_month_pending_users', $total_current_month_pending_users);
        $this->set('total_current_month_active_users', $total_current_month_active_users);
        $total_current_month_reviews = $this->Review->find('count', array('conditions' => array('Review.created >= "' . $curr_date . '"')));
        $total_current_month_video_reviews = $this->Review->find('count', array('conditions' => array('Review.type' => 'video', 'Review.created >="' . $curr_date . '"')));
        $total_current_month_text_reviews = $this->Review->find('count', array('conditions' => array('Review.type' => 'text', 'Review.created >="' . $curr_date . '"')));
        $this->set('total_current_month_reviews', $total_current_month_reviews);
        $this->set('total_current_month_video_reviews', $total_current_month_video_reviews);
        $this->set('total_current_month_text_reviews', $total_current_month_text_reviews);
        $total_current_month_suggestions = $this->Suggestion->find('count', array('conditions' => array('Suggestion.created >= "' . $curr_date . '"')));
        $this->set('total_current_month_suggestions', $total_current_month_suggestions);
    }

    function admin_login() {

        $this->layout = 'admin_dashboard';

        if ($this->Session->read('admin_id')) {
            $this->redirect(array('controller' => 'admins', 'action' => 'index', 'admin' => true));
        }
        //$this->layout = null;
        if ($this->Cookie->read('admin_id')) {
            $this->Session->write('admin_id', $this->Cookie->__values['admin_id']);
            $this->autoRender = false;
            $this->redirect('/admins/');
        }
        $msg = "";

        if ($this->data['Admin']) {



            $password = md5($this->data['Admin']['password']);
            $this->data['Admin']['password'] = mysql_real_escape_string($this->data['Admin']['password']);

            $result = $this->Admin->find('first', array('conditions' => array('Admin.username' => $this->data['Admin']['username'], 'Admin.password' => $password)));


            if ($result) {
                $this->Session->write('admin_id', $result['Admin']['id']);
                if (isset($this->data['remember_me'])) {
                    $this->createCookies($result['Admin']['id']);
                }

                $this->autoRender = false;
                $this->redirect('/admin/admins/index/');
            } else {

                $msg = "Invalid Username or Password.";
            }
        }

        $this->set("msg", $msg);
    }

    function admin_change_password() {

        $this->layout = 'admin_dashboard';

        $msg = "";

        if (isset($this->data['Admin']['email'])) {
            $this->Admin->set($this->data);
            if ($this->Admin->validates()) {

                if (!preg_match($this->emailCheckExpression, $this->data['Admin']['email'])) {

                    $msg = "Please enter valid email";
                } else if (empty($this->data['Admin']['email'])) {

                    $msg = "Please enter email";
                } else {

                    $this->Admin->save($this->data, true, array('email'));
                    $msg = "Your email has been updated";
                }
            }
            $this->data = $this->data;
        } else if (isset($this->data['Admin']['username'])) {

            $this->Admin->set($this->data);
            if ($this->Admin->validates()) {


                if (empty($this->data['Admin']['username'])) {

                    $msg = "Please enter username";
                } else {

                    $this->Admin->save($this->data, true, array('username'));
                    $msg = "Your username has been updated";
                }
            }
            $this->data = $this->data;
        } else if ($this->data['Admin']['currentpassword']) {
            $this->Admin->set($this->data);
            if ($this->Admin->validates()) {

                if (!empty($this->data['Admin']['password']) and !empty($this->data['Admin']['confirmpassword'])) {
                    $adminData = $this->Admin->find('first', array('conditions' => array('Admin.id' => $this->data['Admin']['id'])));

                    if ($adminData['Admin']['password'] == md5($this->data['Admin']['currentpassword'])) {
                        $this->data['Admin']['password'] = md5($this->data['Admin']['password']); // to save the encoded password
                        $this->Admin->save($this->data);
                        $msg = "Password has been updated.";
                    } else {
                        $msg = "Please enter correct Current Password";
                    }
                } else {
                    $msg = "Please enter Password";
                }
            }
            $result = $this->Admin->find(array("id='1'"));
            $this->data = $result;
        } else {
            $result = $this->Admin->find(array("id='1'"));
            $this->data = $result;
        }
        $this->set("msg", $msg);
    }

    function admin_forgot_password() {

        $msg = "";
        if ($this->data) {
            $new_password = rand(100000, 999999);

            $email = $this->Admin->find("id = 1 and email='" . $this->data['Admin']['email'] . "'", array("id", "email"));
            if ($email) {
                $email['Admin']['password'] = md5($new_password);
                $this->data = $email;

                $this->Admin->save($this->data, false);
                // Sending mail
                $this->Email->from = $this->email_from;
                $this->Email->to = 'Administrator <' . $email['Admin']['email'] . '>';
                $this->Email->subject = 'Administrator new password';
                if ($this->Email->send('New Password for Administrator is: ' . $new_password)) {
                    $msg = 'New password has been sent to your Email Address.<br/><br/>Thank You<br/><br/><div class="submit-button"><input type="button" onclick="javascript:window.close();" value="Close" /></div>';
                } else {
                    $msg = 'Email sending failed. Plz <a href="">try again</a>.<br/>';
                }
            } else {
                $msg = 'This email address does not exist';
            }
        }
        $this->set("msg", $msg);
    }

    function admin_logout() {
        $msg = "";
        unset($_SESSION['admin_id']);
        $this->Session->setFlash('You have been logged out successfuly');
        $this->redirect(array('controller' => 'admins', 'action' => 'login'));
    }

}

?>