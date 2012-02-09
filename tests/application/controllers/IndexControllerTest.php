<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        //        $params = array('action' => 'index', 'controller' => 'Index', 'module' => 'default');
        //        $urlParams = $this->urlizeOptions($params);
        //        $url = $this->url($urlParams);

        $this->dispatch('/');

        //        echo $this->getResponse()->getBody();

        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        //        $this->assertQueryContentContains("div#welcome h3", "This is your project's main page");
    }

    public function testCanGetPostIndex()
    {
        $this->getRequest()
            ->setMethod('post')
            ->setParams(
                array(
                    'username' => 'jd',
                    'password' => 'jd'
                )
            );
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        $this->assertXpathContentContains('id(username)','jd');
    }

    public function testRegisterAction()
    {

        $this->dispatch('/index/register');
        $this->assertController('index');
        $this->assertAction('register');
        $this->assertResponseCode(200);
        //        $params = array('action' => 'register', 'controller' => 'Index', 'module' => 'default');
        //        $urlParams = $this->urlizeOptions($params);
        //        $url = $this->url($urlParams);
        //        $this->dispatch($url);
        //
        //        // assertions
        //        $this->assertModule($urlParams['module']);
        //        $this->assertController($urlParams['controller']);
        //        $this->assertAction($urlParams['action']);
        //        $this->assertQueryContentContains(
        //            'div#view-content p',
        //            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
        //            );
    }


}





