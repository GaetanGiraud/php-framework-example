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


$system_path = realpath('../') . '/';

// Is the system path correct?
if ( ! is_dir($system_path))
{
	exit("Your system folder path does not appear to be set correctly.");
}

define("BASE_PATH", $system_path);

// the fully qualified hostname of the server
define("FQDN", 'http://'. $_SERVER['SERVER_NAME']);


// We will use this to ensure scripts are not called from outside of the framework
define("GGFW", TRUE);

/**
 * Magic autoload function
 * used to include the appropriate -controller- files when they are needed
 * @param String the name of the class
 */

function __autoload($class_name)
{
	/** using namespacing require the missing class file
	 * Namespace need to correspond with folder names for the autoload to
	 * work appropriatively
	 */
	$file = BASE_PATH . strtolower(str_replace('\\', '/', $class_name)) . '.php';	
	
	if (file_exists($file)){ 
		require_once $file;
	} else {
		return false;
		//trigger_error('Could not locate class file ' . $class_name, E_USER_ERROR);
	}
}

// require our registry
require_once BASE_PATH . 'core/registry.php';

$registry = Core\Registry::singleton();

//TODO load config file into the registry


// Connect to the database

//TODO database details inside config file
$registry->getObject('db')->newConnection('localhost',  'db', 'root', 'tutsplus');

// Route the request

$registry->getObject('router')->route($_SERVER["REQUEST_URI"]);

