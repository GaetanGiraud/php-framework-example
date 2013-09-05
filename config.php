<?php
use Core\Registry;

/**
 * Config array to gather all config items
 *  
 */

$config = array();
/**
 * 
 * DB Config
 * 
 */

$config['dbConfig'] = array(
		'host' => 'localhost',
		'database' => 'db',
		'user' => 'root',
		'password' => 'tutsplus');





/**
 * Root controller
 * 
 */
				
$config['root'] = 'welcome';

/**
 * Sore the config items inside the registry
 *
 */

Registry::storeSettings($config);


