<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $this->view->langs = $langs = Language::findAll();

//        foreach ($langs as $lang) {
//            echo $lang->name . '<br>';
//            foreach ($lang->Users as $u) {
//                echo $u->username . '<br>';
//            }
//        }
    }


}

