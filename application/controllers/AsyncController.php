<?php

class AsyncController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function getitemsAction() {

        $message = 'default';

        if ($this->getRequest()->isPost()) {
            $message = '<p>' . $this->getRequest()->getParam('msg') . '</p>';
        }

        echo Zend_Json_Encoder::encode($message);
    }

}

