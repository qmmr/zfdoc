<?php

error_reporting(E_ALL | E_STRICT);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Ini.php';
//require_once 'ControllerTestCase.php';

$application = new Zend_Application(APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini');
$application->getBootstrap()->bootstrap("doctrine");
$cli = new Doctrine_Cli($application->getOption('doctrine'));

@$cli->run(array("doctrine", "drop-db", "force"));
@$cli->run(array("doctrine", "generate-models-yaml", "force"));
@$cli->run(array("doctrine", "create-db", "force"));
@$cli->run(array("doctrine", "create-tables", "force"));
//$cli->run(array("doctrine", "load-data", "force"));
