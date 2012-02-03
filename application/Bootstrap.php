<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload()
    {
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        //        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
        //            'basePath' => APPLICATION_PATH,
        //            'namespace' => 'Application_',
        //            'resourceTypes' => array(
        //                'model' => array(
        //                    'path' => 'models/',
        //                    'namespace' => 'Model_'
        //                ),
        //                'model' => array(
        //                    'path' => 'models/Base/',
        //                    'namespace' => 'Model_Base_'
        //                )
        //            ),
        //        ));
        //        $autoLoader->pushAutoloader($resourceLoader);
        return $autoLoader;
    }

//    protected function _initAppAutoload() {
//        $autoloader = new Zend_Application_Module_Autoloader(array(
//                    'namespace' => 'zfdoc',
//                    'basePath' => dirname(__FILE__),
//                ));
//        return $autoloader;
//    }

    protected function _initDoctrine()
    {
        $this->getApplication()->getAutoloader()
            ->pushAutoloader(array('Doctrine', 'autoload'));
        spl_autoload_register(array('Doctrine', 'modelsAutoload'));
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        $doctrine = $this->getOption('doctrine');

        // loads all models under path from application.ini
        Doctrine::loadModels($doctrine['models_path']);

        $conn = Doctrine_Manager::connection($doctrine['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        return $conn;
    }

    public function _initView()
    {
        $view = new Zwig_View(
            array(
                'encoding' => 'UTF-8',
                'helperPath' => array(),
            )
        );

        $loader = new Twig_Loader_Filesystem(array());
        $zwig = new Zwig_Environment($view, $loader, array(
//            'cache' => APPLICATION_PATH . '/cache/twig/',
//            'auto_reload' => true,
        ));

        $view->setEngine($zwig);
        $view->doctype(Zend_View_Helper_Doctype::HTML5);

        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view, array(
            'viewSuffix' => 'twig',
        ));
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        return $view;
    }

}
