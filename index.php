<?php
/**
 * GG Framework
 * Framework loader - acts as a single point of access to the Framework 
 * 
 * @version 0.1 
 * @author Gaëtan Giraud
 * 
 */

// first and foremost, start our sessions
session_start();

// Set up some definitions
// The applications root path, so we can easily get this path from files located in other folders
define("APP_PATH", dirname( __FILE__) . '/');

// We will use this to ensure scripts are not called from outside of the framework
define("GGFW", TRUE);

/**
 * Magic autoload function
 * used to include the appropriate -controller- files when they are needed
 * @param String the name of the class
 */

function __autoload($class_name)
{
	// using namespacing require the missing class file
	// Namespace need to correspon with folder names for the autoload to
	// work appropriatively
	/* echo $class_name;
	echo APP_PATH; */
	$file = APP_PATH . strtolower(str_replace('\\', '/', $class_name)) . '.php';	
	
	if (file_exists($file)){ 
		require_once $file;
	} else {
		trigger_error('Could not locate class file ' . $class_name, E_USER_ERROR);
	}
}

// require our registry
require_once 'core/registry.php';
//use Core\Registry;
$registry = Core\Registry::singleton();


//include 'dbexamples.php';

// Route the request

$registry->getObject('router')->_route($_SERVER["REQUEST_URI"]);

