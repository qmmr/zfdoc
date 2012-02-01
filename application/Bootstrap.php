<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAppAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => 'zfdoc',
                    'basePath' => dirname(__FILE__),
                ));
        return $autoloader;
    }

    protected function _initDoctrine() {
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
        $conn = Doctrine_Manager::connection($doctrine['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        return $conn;
    }

}

