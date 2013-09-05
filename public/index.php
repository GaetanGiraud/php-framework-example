<?php
use Core\Registry;
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

/**
 * Set up some definitions
 */


// The public root path, where files accessible from the outside are located

define("APP_PATH", dirname( __FILE__) . '/');



// Base path where the application resides.
// Usually for security purposes outside of the public folder

$base_path = realpath('../') . '/';

// Is the base path correct?
if ( ! is_dir($base_path))
{
	exit("Your base folder path does not appear to be set correctly.");
}

define("BASE_PATH", $base_path);

// the fully qualified domaine of the server
define("FQDN", 'http://'. $_SERVER['SERVER_NAME']);

// We will use this to ensure scripts are not called from outside of the framework
define("GGFW", TRUE);


/**
 * Set error levels
 *
 */


/**
 * Magic autoload function
 * used to include class files as they are needed
 * 
 * @param String the name of the class
 */

function __autoload($class_name)
{
	/** 
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

/**
 * Load config file
 * 
 * 
 */

$file = BASE_PATH . 'config.php';

if (file_exists($file)){
	require_once $file;
} else {
	trigger_error('Could not locate config file. Make sure the config file is in the BASE Directory ', E_USER_ERROR);
}

//print_r( Registry::getSetting('dbConfig') );

// require our registry
// require_once BASE_PATH . 'core/registry.php';

// $registry = Core\Registry::singleton();

//TODO load config file into the registry


// Connect to the database

//exit();
// Route the request

Registry::load('router')->route($_SERVER["REQUEST_URI"]);

