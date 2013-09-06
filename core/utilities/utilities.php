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

/*===================================================================================
 *
 * 
 * Utilities functions callable across the framework.
 *
 * 
 */

/**
 * Redirect with an optional Flash message
 * 
 * @param string $path
 * @param string $message
 * @param string $severity
 */
if (!function_exists('redirect')) {
	function redirect($path, $message = null, $severity = null)
	{
		// if flash message add it to the session Flash array
		if ($message) {
			Core\Flash::add($message, $severity);
		}
		
		// redirect to $path
		header( 'Location: ' . $path , true, 301) ;
		exit();
	}
}


/**
 * Redirect to the Application Root with an optional Flash message
 * 
 * @param string $message
 * @param string $severity
 */
if (!function_exists('redirectToRoot')) {
	function redirectToRoot($message = null, $severity = null) 
	{
		// get the root path
		$rootPath = Registry::getSetting('appRoot')['path'];
		
		redirect('/' . $rootPath, $message, $severity);
	
	}
}

/**
 * Normalize a path into a common format
 * to facilitate routing and comparisons
 * 
 * @param string $path
 * @return string
 */
if (!function_exists('normalizePath')) {
	function normalizePath($path) 
	{
		return strtolower(trim(ltrim($path, '/'), '/'));
	}
}

/**
 * 
 * Load helpers directory
 * 
 * @param array $helpers
 */
if (!function_exists('helpers')) {
	function helpers($helpers = array()) {
		
		foreach ($helpers as $helper ) {
			$loaded = false;
			
			// first check if file exists in core/helpers folder
			$fileName = BASE_PATH . 'core/helpers/'. $helper . '.php';
			
			if (file_exists($fileName)) {
				
				require_once $fileName;
				$loaded = true;
			}
			
			//  check if file exists in custom helpers folder
			$fileName = BASE_PATH . 'helpers/'. $helper . '.php';
			
			if (file_exists($fileName)) {
				if (!$loaded) {
					require_once $fileName;
				} else {
					trigger_error('Custom helper <strong>'. $helper . 
									'</strong> already defined as core helper.', E_USER_ERROR);
				}
			}
		}
	}
}