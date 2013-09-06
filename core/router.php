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
 * Parse route and instantiante relevant controller
 * 
 * Implement the Front Controller design pattern
 * 
 * @author Gaëtan Giraud
 *
 */
class Router {
	
	/**
	 * Controller name
	 * 
	 * @var string
	 * @access private
	 */
	private $_controller;
	
	/**
	 * Action name - Default to index
	 *
	 * @var string
	 * @access private
	 */
	private $_action = 'index';
	
	/**
	 * Record ID
	 *
	 * @var string
	 * @access private
	 */
	private $_recordId = null;
	
	public function __construct() {
		
	}
	
	/**
	 * Extrapolate route base on uri. 
	 * Call controller instantiation method
	 * 
	 * @param string $uri
	 */
	public function route($uri) {
		
		$uri = normalizePath($uri);
		
		$route = explode('/', $uri );
		
		if (empty($route[0])) {
			// $route[0] empty indicates the document root - 
			// use root information from Registry
			
			$root = Registry::getSetting('root');
			$this->_controller = $root['controller'];
			$this->_action = $root['action'];
			
		} else {
			$this->_controller = $route[0];
			
				// check is action is defined. default to index
			if (isset($route[1])) {
				
				$class = 'Controllers\\' . $this->_controller;
				
				// check if second parameter has been defined as a method
				if (method_exists($class, $route[1])) {
						
					// if TRUE, record it as an action
					$this->_action = $route[1];
				} else {
					// otherwise it is considered to be a record id
					$this->_recordId = $route[1];
						
					// if a third parameter is provided then it is an action
					if (isset($route[2])) {
						$this->_action = $route[2];
					} else {
						// if no action is specified, it is defaulted to show
						$this->_action = 'show';
					}
						
				}
		
			}
		} 
		
		$this->_loadcontroller();

	}
	
	
	/**
	 * Getter for _route property
	 * 
	 * @return array the parsed route
	 */
	public function getRoute() {
		$route = array(
			'controller' => $this->_controller,
			'action' => $this->_action,
			'recordId' => $this->_recordId
		);
		return $route;
	}
	
	
	/**
	 * Check if controller exists && instantiate it
	 * 
	 * @return Controller object
	 */
	private function _loadcontroller() {
		$class  = 'Controllers\\' . $this->_controller;
		
		try {
			if (class_exists($class, TRUE)) {
				// if the controller has been defined, instantiate controller
				$instantiate = true; 
			} 
		} catch (\Exception $e) {
			$instantiate = false;
			// catch the exception sent by __autoload..
		}
		
		if ($instantiate) {
			return new $class();
		}
		
		/*
		 * Ensure that no infinite loop occurs by throwing an error
		 * if the controller of the application root has not been defined.
		 * 
		 */ 
		
		$rootPath = normalizePath(Registry::getSetting('appRoot')['path']);
		$uri = normalizePath($_SERVER["REQUEST_URI"]);
		
		if ( $uri != $rootPath) {
			redirect('/' . $rootPath, 'The page you are requesting does not exits!', 'danger');
		} else {
			trigger_error('Root controller is not defined.', E_USER_ERROR);
		}
		
	}
	
}
