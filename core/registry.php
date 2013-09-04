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
	private static $objects = array();
	
	/**
	 * Our array of settings
	 * @access private
	 */
	private static $settings = array();
	
	/**
	 * The framework humane readable name
	 * @access private
	 */
	private static $frameworkName = 'GG Framework v01';
	
	/**
	 * The instance of the registry
	 * @access private
	 */
	private static $instance;
	
	/**
	 * Private constructor to prevent it being created directly 
     * @access private
	 */
	private function __construct()
	{
		$this->storeObject('Core\Database', 'db' );
		$this->storeObject('Core\Router', 'router' );
		$this->storeObject('Core\Helpers', 'helpers' );
	}
	
	/**
	 * singleton method used to access the object
	 * 
	 * @access public
	 * @return
	 *
	 */
	public static function singleton() 
	{
		if (! isset ( self::$instance )) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * prevent cloning of the object: issues an E_USER_ERROR if this is attempted 
	 */
	public function __clone()
	{
		trigger_error('Cloning the registry is not permitted', E_USER_ERROR);
	}
	
	/**
	 * Stores an object in the registry 
	 * @param String $object the name of the object
	 * @param String $key the key for the array 
	 * @return void
	 */
	public function storeObject($object, $key)
	{	 
		self::$objects[ $key ] = new $object( self::$instance );
	}
	
	/**
	 * Gets an object from the registry 
	 * @param String $key the array key 
	 * @return object:
	 */
	public function getObject($key)
	{
		//TODO create a simpler load mechanism to perform both actions
		
		if (is_object ( self::$objects [$key] )) {
			return self::$objects[$key];
		}
	}
	
	/**
	 * Stores settings in the registry 
	 * @param String $data
	 * @param String $key the key for the array 
	 * @return void
	 */
	public function storeSetting($data, $key)
	{
		//TODO load config file inside settings
		self::$settings [ $key ] = $data;
	}
	
	/**
	 * Gets a setting from the registry
	 * 
	 * @param String $key
	 *        	the key in the array
	 * @return Stored setting or void
	 */
	public function getSetting($key) 
	{
		if (isset ( self::$settings [$key] )) {
			return self::$settings [$key];
		}
	}
	
	/**
	 * Gets the frameworks name
	 * @return string
	 */
	public function getFrameworkName()
	{
		return self::$frameworkName;
	}
}