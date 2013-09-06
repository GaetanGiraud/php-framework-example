<?php
/**
 * GG Framework
 *
 * A lightweight example PHP framework
 *
 * @version 	0.1
 * @author 		Gaëtan Giraud
 * @copyright 	2013.
 * @license		Apache v2.0
 *
 */

/*===================================================================================*/

namespace Core;

/**
 * The registry class
 * implements the Registry and Singleton design patterns
 * 
 * @author Gaëtan Giraud
 * 
 */
class Registry {
	
	/**
	 * Our array of objects
	 * 
	 * @var array
	 * @access private
	 */
	private $_objects = array();
	
	/**
	 * Record of loaded object
	 * 
	 * @var array
	 * @access private
	 */
	private $_isLoaded = array();
	
	/**
	 * Our array of settings
	 * 
	 * @var array
	 * @access private
	 */
	private $_settings = array();
	
	/**
	 * The instance of the registry
	 * 
	 * @var Registry
	 * @access private
	 * @static
	 * 
	 */
	private static $_instance;
	
	/**
	 * Private constructor to prevent it being created directly 
     * @access private
	 */
	private function __construct()
	{
	}
	
	/**
	 * singleton method used to access the object
	 * 
	 * @access public
	 * @return Registry
	 * @static
	 *
	 */
	private static function singleton() 
	{
		if (! isset ( self::$_instance )) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * prevent cloning of the object: issues an E_USER_ERROR if this is attempted 
	 */
	public function __clone()
	{
		trigger_error('Cloning the registry is not permitted', E_USER_ERROR);
	}
	
	
	/**
	 * Retrieve from the Registry. 
	 * Instantiate it if not already loaded.
	 * 
	 * @param string $class - Only Core classes can be loaded into the register
	 * @param string $params - optional parameters
	 * @return object
	 * 
	 */
	public static function load($class) 
	{	
		// get the registry singleton.
		$registry = Registry::singleton();
		
		if (!in_array($class, $registry->_isLoaded)) {
			
			// only Core class should be loaded in the Registry
			$className = '\Core\\' . $class; 
			
			try {
				if (class_exists($className, TRUE)) {
					$registry->_objects[ $class ] = new $className();
					$registry->_isLoaded[] = $class;
					
					return $registry->_objects[ $class ];
				}
			} catch (\Exception $e) {
				trigger_error('Error loading a class in the registry: 
						trying to load a non existent class or non Core class ' . $className , E_USER_ERROR);
			}
		} else {
			return $registry->_objects[ $class ];
		}
	}

	
	/**
	 * Stores the configuration settings in the registry 
	 * 
	 * @param String $data
	 * @param String $key the key for the array 
	 * 
	 */
	public static function storeSettings($settings)
	{
		$registry = Registry::singleton();
		
		foreach ($settings as $key => $value) {
			$registry->_settings [ $key ] = $value;
		}
	}
	
	/**
	 * Gets a setting from the registry
	 * 
	 * @param String $key
	 *        	the key in the array
	 * @return string Stored setting or void
	 */
	public static function getSetting($key) 
	{
		// get the registry singleton.
		$registry = Registry::singleton();
		
		if (isset ( $registry->_settings [$key] )) {
			return $registry->_settings [$key];
		}
	}
}