<?php
defined('APPLICATION_PATH')
	or define('APPLICATION_PATH', dirname(__FILE__));
	
if(file_exists(dirname(__FILE__).'/environment.php'))
	require_once(dirname(__FILE__).'/environment.php');

set_include_path(APPLICATION_PATH . '/../library' . PATH_SEPARATOR .  get_include_path());
set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_PATH . '/models/');

date_default_timezone_set('Europe/Stockholm');

require_once('Zend/Loader/Autoloader.php');
$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);

// Set exception handler
set_error_handler("exceptionsErrorHandler");

function exceptionsErrorHandler($severity, $message, $filename, $lineno)
{
	if(error_reporting() == 0)
	{
		return;
	}
	if(error_reporting() & $severity)
	{
		throw new ErrorException($message, 0, $severity, $filename, $lineno);
	}
}

function handleException(Exception $e)
{
	$exceptionHandler = new Exception_Handler();
	$exceptionHandler->handleException($e);
}
set_exception_handler("handleException");

$config = Handler::getConfig();

if(!isset($config->report->emails))
	die('No report emails have been set!');

$emails = explode(",", $config->report->emails);

$jobHandler = new Job_Handler();

foreach($emails as $email)
{
	$jobHandler->addReportEmail($email);
}