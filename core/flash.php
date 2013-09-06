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
 * Session Flash Messages class
 * 
 * Cannot be instantiated.
 * 
 * Only one message can recorded at a time.
 * TODO Multiple flash messages
 * 
 * @static
 * @author Gaëtan Giraud
 *
 */
abstract class Flash {
	
	/**
	 * Save a message in the session flash
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
	 * Retrieve the session flash message if available
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
	 * Refresh the session flash
	 */
	public static function refresh() 
	{	
		if ( isset($_SESSION['FLASH']['retrieved'] )){
			// if the flash retrieved flag has been set, reset the flash
			unset($_SESSION['FLASH']);
		}
	}
}