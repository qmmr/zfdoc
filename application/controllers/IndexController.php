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

    public function mailAction() {
        // default
//        $transportType = new Zend_Mail_Transport_Sendmail();
        
        $smtpOptions = array(
            'auth'      => 'login',
            'username'  => 'bez.niczego@gmail.com',
            'password'  => 'password',
            'ssl'       => 'ssl',
            'port'      => 465
        );
        $transportType = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpOptions);
        
        Zend_Mail::setDefaultTransport($transportType);
        
        $mail = new Zend_Mail();

        $email = "bez.niczego@gmail.com";
        $name = "Marcin Kumorek";
        $msg = "Hello from default mail!";

        $mail->addTo($email, $name)
                ->setFrom($email, $name)
                ->setSubject('Hi there!')
                ->setBodyText($msg)
                ->send($transportType);
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

