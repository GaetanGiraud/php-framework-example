<?php
/**
 *
 * Utilities functions to be used indiscriminately across the framework
 *
 * @author Gaëtan Giraud
 * 
 */

/**
 * Redirect with an optional Flash message
 * 
 * @param string $path
 * @param string $message
 * @param string $severity
 */
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


/**
 * Redirect to the Application Root with an optional Flash message
 * 
 * @param string $message
 * @param string $severity
 */
function redirectToRoot($message = null, $severity = null) 
{
	// get the root path
	$rootPath = Registry::getSetting('appRoot')['path'];
	
	redirect('/' . $rootPath, $message, $severity);

}

/**
 * Normalize a path into a common format
 * to facilitate routing and comparisons
 * 
 * @param string $path
 * @return string
 */
function normalizePath($path) 
{
	return strtolower(trim(ltrim($path, '/'), '/'));
}
