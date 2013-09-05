<?php
/**
 * GG Framework
 * 
 * @name config file
 * @author Gaëtan Giraud
 *
 */

/*===================================================================================
 * 
 * Config array to gather all config items
 *  
 */

$config = array();




/*===================================================================================
 * 
 * Environment specific DB Config
 * 
 */


switch (ENVIRONMENT) {
	case 'development':
		$config['dbConfig'] = array(
				'host' => 'localhost',
				'database' => 'db',
				'user' => 'root',
				'password' => 'tutsplus');
		break;
	case 'testing':
		$config['dbConfig'] = array(
				'host' => '',
				'database' => '',
				'user' => '',
				'password' => '');
		break;
	case 'production':
		$config['dbConfig'] = array(
				'host' => '',
				'database' => '',
				'user' => '',
				'password' => '');
		break;
	default:
		exit('The application environment is not set correctly.');
		;
}

/*===================================================================================
 * 
 * Document Root Controller and Action default
 *
 */

$config ['root'] = array (
		'controller' => 'welcome',
		'action' => 'index' 
);


/*===================================================================================
 * 
 * Application root path - by default set to document root
 * 
 */
				
$config ['appRoot'] = array (
		'path' => '/' 
);




/*===================================================================================
 * Store the config items inside the registry
 *
 */

Core\Registry::storeSettings($config);


