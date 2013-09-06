<?php
/**
 * GG Framework
 *
 * A lightweight example PHP framework
 *
 * @version 0.1
 * @author Gaëtan Giraud
 * @licence Apache v2.0
 *
 */

use Core\Registry;

/*===================================================================================
 *
 * Check the PHP version. Use of namespacing entails PHP version > 5.3
 *
 */

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	exit('This framework makes use of Namespaces, a feature available after PHP version 5.3. 
			You are using: ' . PHP_VERSION );
}

/*===================================================================================
 * 
 * Start the session
 * 
 */ 

session_start();



/*===================================================================================
 * 
 * Set up some definitions
 * 
 */

/*
 * Set up Framework information
 * 
 */

define("VERSION", 0.1);

define("FRAMEWORK", 'GG Framework');


/*
 * The public root path, usually set to the Apache DocumentRoot
 */ 

define("APP_PATH", dirname( __FILE__) . '/');


/*
 * Base path where the application resides.
 * Usually for security purposes outside of the public folder.
 * 
 */ 

$systemPath = '../';


$basePath = realpath($systemPath) . '/';

// Is the base path correct?
if ( ! is_dir($basePath))
{
	exit("Your base folder path does not appear to be set correctly.");
}

define("BASE_PATH", $basePath);


/*
 * The fully qualified domaine of the server
 */ 

define("FQDN", 'http://'. $_SERVER['SERVER_NAME']);


/* The Environement can be set to anything, but default usage is:
	*
	*     development
	*     testing
	*     production
	*
	* NOTE: If you change these, also change the error levels && the config file
	*
*/

define('ENVIRONMENT', 'development');




/*===================================================================================
 * 
 * Set error levels
 *
 */


if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL | E_STRICT);
			break;

		case 'testing':
		case 'production':
			error_reporting(0);
			break;

		default:
			exit('ENVIRONMENT must be defined as either development/testing/production.');
	} 
} else {
		exit('ENVIRONMENT must be set up.');
}




/*===================================================================================
 *
 * Overriding the default error handling to make better use of Exceptions
 * in an object oriented framework
 *
 */

function exception_error_handler($errNo, $errStr, $errFile, $errLine ) {
	throw new Core\ErrorHandler($errStr, 0, $errNo, $errFile, $errLine);
}

set_error_handler("exception_error_handler", E_ALL);




/*===================================================================================
 * 
 * Load the utilities - Required, do not modify!
 * 
 */

$dir = BASE_PATH . 'core/utilities/';

// scan the folder and remove the .. and . entries
$files = array_diff(scandir($dir), array('..', '.'));

foreach ($files as $file) {
	require_once $dir . $file;
}




/*===================================================================================
 *
* Load the view helpers folder.
* 
* Comment out to disable view helpers.
* 
* Add custom view helpers in the helpers/ directory
*
*/

helpers(array('core', 'custom'));




/*===================================================================================
 * 
 * __autoload: Needs to be defined before any class is created.
 * 
 */

/**
 * Magic autoload function
 * used to include class files as they are needed
 * 
 * @param String the name of the class
 */

function __autoload($className)
{
	/** 
	 * Namespace need to correspond with folder names for autoload to function.
	 */
	$file = BASE_PATH . strtolower(str_replace('\\', '/', $className)) . '.php';	
	
	if (file_exists($file)){ 
		require_once $file;
	} else {
		// Throw an exception.
		 trigger_error('Class '. $className .' not found.', E_USER_ERROR);
	}
}

/*===================================================================================
 * 
 * Load config file
 * 
 */

$file = BASE_PATH . 'config.php';

if (file_exists($file)){
	require_once $file;
} else {
	trigger_error('Could not locate config file. Make sure the config file is in the BASE Directory ', E_USER_ERROR);
}


/*===================================================================================
 *
 * Refresh the FLASH
 *
 */

Core\Flash::refresh();

/*===================================================================================
 * 
 * Route the request 
 * 
 */

Registry::load('router')->route($_SERVER["REQUEST_URI"]);

