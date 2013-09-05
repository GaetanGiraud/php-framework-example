<?php

namespace Core;

if ( ! defined( 'GGFW' ) )
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit();
}
/**
 * Defines common features for all controllers
 * @author GM Giraud
 *
 */
abstract class Controller {
	// default action is index
	protected $_action = 'index';
	protected $_recordId = null;
	protected $_model;
	private $_isRoot = false;
	private $_layoutLoaded = false;
	
	/**
	 * Controller identifies and call the requested action
	 * from the route stored inside the router
	 * @param array $route route as parsed by the router
	 */
	public function __construct() 
	{
		// recover the route from the router in the registry
		$route = Registry::load('router')->getRoute();
		
		// if $route is empty, do nothing, use the defaults
		if (!empty($route[0])) { 

			if (isset($route[1])) {
				
				// check if second parameter has been defined as a method
				if (method_exists($this, $route[1])) {
					
					// if TRUE, record it as an action
					$this->_action = $route[1];
				} else {
					// otherwise it is considered to be a record id
					$this->_recordId = $route[1];
					
					// if a third parameter is provided then it is an action
					if (isset($route[2])) {
						$this->_action = $route[2];
					} else {
						// if no action is specified, it defaulted to show
						$this->_action = 'show';
					}
					
				}
				
			}
						
		} else {
			$this->_isRoot = TRUE;
		} 
		
		// call the action - index is called is no action was provided
		$this->_callAction();
	}
	
	/**
	 * Load the layout view from the controllers
	 * 
	 * @param string $view name of the view to be loaded
	 * @param array $data array of data to be used inside the view
	 */
	
	protected function view($view, $data = array())
	{
		// check if the layout has been rendered
		if (! $this->_layoutLoaded) {
			// if not, render the layout and pass the requested 
			// view inside the $data['view'] variable
			
			$filename = BASE_PATH . 'views/_layout.php';
			$data['view'] = $view;
			$this->_layoutLoaded = true;
			
		} else {
			$filename = BASE_PATH . 'views/' . $view . '.php';
		}
		
		if (file_exists($filename)) {
			extract($data); // make the data available as variables
			$h = Registry::load('helpers');  // load view helpers
			
			include $filename;
		} else {
			exit('Can not find layout file');
		}
	
	}
	
	/**
	 * Perform the action 
	 * 
	 */
	private function _callAction() 
	{
		if(method_exists($this, $this->_action)) {
			call_user_func(array($this, $this->_action));
		} else {
			// prevent infinite looping, throw an error if $this referes to the root controller
			if (!$this->_isRoot) {
				
				// redirect to root when action is not found
				header( 'Location: /' , true, 301) ;
				exit();
			} else {
	
			 trigger_error('Infinite loop on the root page prevented. Please define an index action for the root.', E_USER_ERROR);
			}
			
		}
	}
}