<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        if ($this->getRequest()->isPost()) {
            $adapter = new ZD_Auth_Adapter($this->_getParam('username'), $this->_getParam('password')
            );
            $result = Zend_Auth::getInstance()->authenticate($adapter);

            if (Zend_Auth::getInstance()->hasIdentity()) {
                $this->_forward('authorized');
            } else {
                $this->view->message = implode(' ', $result->getMessages());
            }
            //            var_dump($this->getRequest()->getParams());
        }

        $this->view->langs = $langs = Model_Language::findAll();

        //        foreach ($langs as $lang) {
        //            echo $lang->name . '<br>';
        //            foreach ($lang->Users as $u) {
        //                echo $u->username . '<br>';
        //            }
        //        }
    }

    public function sendmailAction() {
        $msg = "Hello from default mail!";
        $mail = new Zend_Mail();
        $mail->addTo('jaka.wredna@gmail.com', 'Marcin Kumorek')
            ->setFrom('jaka.wredna@gmail.com', 'Marcin Kumorek')
            ->setSubject('Hi there!')
            ->setBodyText($msg)
            ->send();
    }

    public function editAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/');
        }

        if ($this->getRequest()->isPost()) {
            $user = Zend_Auth::getInstance()->getIdentity();
            $user->email = $this->_getParam('email');
            $user->save();
        }
    }

    public function authorizedAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/');
        }
        var_dump($this->getRequest()->getParams());
        var_dump(Zend_Auth::getInstance()->getIdentity()->toArray());
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

}

