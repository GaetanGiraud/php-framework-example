<?php

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
	
	$rootPath = Registry::getSetting('appRoot')['path'];
	
	redirect('/' . $rootPath, $message, $severity);

}

/**
 * normalize path
 * 
 * @param string $path
 * @return string
 */
function normalizePath($path) {
	return strtolower(trim(ltrim($path, '/'), '/'));
}
