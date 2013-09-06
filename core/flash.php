<?php
namespace Core;

/**
 * Class handling the Flash
 * 
 * Cannot be instantiated.
 * 
 * @static
 * @author Gaëtan Giraud
 *
 */
abstract class Flash {
	
	/**
	 * Save a message in the flash
	 * 
	 * @param string $message
	 * @param string $severity
	 */
	public static function add($message, $severity = null) 
	{	
		// save the flash message into the session
		$_SESSION['FLASH'] = array(
					'msg'=> $message,
					'severity' => $severity
					);
	}
	
	/**
	 * Retrieve the flash message if available
	 * 
	 * @return array || bool
	 */
	public static function retrieve() 
	{
		// check if a flash message has been defined
		if (isset($_SESSION['FLASH']) && !empty($_SESSION['FLASH'])){
		 		// set the retrieved flag to true
				$_SESSION['FLASH']['retrieved'] = true;
		
				return $_SESSION['FLASH'];
			}
			
			// no flash message to be retrieved
			return false;
	}
	
	/**
	 * Refresh the flash
	 */
	public static function refresh() 
	{	
		if ( isset($_SESSION['FLASH']['retrieved'] )){
			// if the flash retrieved flag has been set, reset the flash
			unset($_SESSION['FLASH']);
		}
	}
}