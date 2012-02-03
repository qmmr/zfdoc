<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDefaultEmailTransport() {
        // default
        // $transportType = new Zend_Mail_Transport_Sendmail();
        $config = $this->getOption('email');
        $transportType = new Zend_Mail_Transport_Smtp($config['transportOptionsSMTP']['host'], $config['transportOptionsSMTP']);
        Zend_Mail::setDefaultTransport($transportType);
    }

    protected function _initAppAutoLoad() {
        $moduleLoad = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH
        ));
    }

    protected function _initDoctrine() {
        $this->getApplication()->getAutoloader()
            ->pushAutoloader(array('Doctrine', 'autoload'));
        spl_autoload_register(array('Doctrine', 'modelsAutoload'));

        $config = $this->getOption('doctrine');

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);

        // in order to do build-all-reload you need to do MODEL_LOADING_AGGRESSIVE
        // normally you would use MODEL_LOADING_CONSERVATIVE
        // we're getting fix from application.ini so that when we use CLI
        // we get 1 which is aggressive and 2 when we use make app
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING,
//                Doctrine::MODEL_LOADING_AGGRESSIVE
            $config['model_autoloading']
        );

        //        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        Doctrine::loadModels($config['models_path']);

        $conn = Doctrine_Manager::connection($config['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);

        return $conn;
    }

    public function _initView() {
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
