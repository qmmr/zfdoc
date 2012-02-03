<?php
error_reporting(E_ALL);

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/..'));
define('APPLICATION_ENV', 'doctrineCLI');

//Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->getBootstrap()->bootstrap("doctrine");

$cli = new Doctrine_Cli($application->getOption('doctrine'));
$cli->run($_SERVER['argv']);
