<?php
namespace Core;
/**
 * The registry object
 * implements the Registry and Singleton design patterns
 * 
 * @version 0.1
 * @author Gaëtan Giraud
 */
class Registry {
	
	/**
	 * Our array of objects
	 * @access private
	 */
	private $_objects = array();
	
	/**
	 * Record of loaded object
	 * @access private
	 */
	private $_isLoaded = array();
	
	/**
	 * Our array of settings
	 * @access private
	 */
	private $_settings = array();
	
	/**
	 * The framework humane readable name
	 * @access private
	 */
	private static $_frameworkName = 'GG Framework v01';
	
	/**
	 * The instance of the registry
	 * @access private
	 */
	private static $_instance;
	
	/**
	 * Private constructor to prevent it being created directly 
     * @access private
	 */
	private function __construct()
	{
	//	$this->storeObject('Core\Database', 'db' );
	////	$this->storeObject('Core\Router', 'router' );
	//	$this->storeObject('Core\Helpers', 'helpers' );
	}
	
	/**
	 * singleton method used to access the object
	 * 
	 * @access public
	 * @return
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
	 * Load a class - Instantiate it if not already loaded
	 * 
	 * 
	 * @param string $class - Only Core classes can be loaded into the register
	 * @param string $params - optional parameters
	 * @return multitype:
	 */
	public static function load($class) 
	{	
		// get the registry singleton.
		$registry = Registry::singleton();
		
		
		if (!in_array($class, $registry->_isLoaded)) {
			
			$className = 'Core\\' . $class;
			
			$registry->_objects[ $class ] = new $className();
			$registry->_isLoaded[] = $class;
			
			return $registry->_objects[ $class ];
			
		} else {
			return $registry->_objects[ $class ];
		}
		
		
	}
	/**
	 * Stores an object in the registry 
	 * @param String $object the name of the object
	 * @param String $key the key for the array 
	 * @return void
	 */
	/* public function storeObject($object, $key)
	{	 
		self::$_objects[ $key ] = new $object( self::$_instance );
	} */
	
	/**
	 * Gets an object from the registry 
	 * @param String $key the array key 
	 * @return object:
	 */
/* 	public function getObject($key)
	{
		//TODO create a simpler load mechanism to perform both actions
		
		if (is_object ( self::$_objects [$key] )) {
			return self::$_objects[$key];
		}
	} */
	
	/**
	 * Stores the configuration settings in the registry 
	 * 
	 * @param String $data
	 * @param String $key the key for the array 
	 * @return void
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
	 * @return Stored setting or void
	 */
	public static function getSetting($key) 
	{
		// get the registry singleton.
		$registry = Registry::singleton();
		
		if (isset ( $registry->_settings [$key] )) {
			return $registry->_settings [$key];
		}
	}
	
	/**
	 * Gets the frameworks name
	 * @return string
	 */
	public function getFrameworkName()
	{
		return self::$_frameworkName;
	}
}