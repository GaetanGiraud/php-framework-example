<?php
namespace Core;

class Router {
	
	/**
	 * Controller name
	 * 
	 * @var string
	 */
	private $_controller;
	
	/**
	 * Action name - Default to index
	 *
	 * @var string
	 */
	private $_action = 'index';
	
	/**
	 * Record ID
	 *
	 * @var string
	 */
	private $_recordId;
	
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
			// $route[0] empty indicates the document root - load from Registry
			
			$root = Registry::getSetting('root');
			$this->_controller = $root['controller'];
			$this->_action = $root['action'];
			
		} else {
			$this->_controller = $route[0];
			
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
	 * @return Controller object
	 */
	private function _loadcontroller() {
		$class  = 'Controllers\\' . $this->_controller;
		
		try {
			if (class_exists($class, TRUE)) {
				// if the controller has been defined, instantiate controller
				return new $class(); 
			} 
		} catch (\Exception $e) {
			
			// catch the exception sent by __autoload. Do nothing with it.
		}
		
		// Ensure that no infinite loop occurs by throwing an error 
		
		$rootPath = normalizePath(Registry::getSetting('appRoot')['path']);
		$uri = normalizePath($_SERVER["REQUEST_URI"]);
		
		if ( $uri != $rootPath) {
			redirect('/' . $rootPath, 'The page you are requesting does not exitst', 'error');
		} else {
			trigger_error('Root controller is not defined.', E_USER_ERROR);
		}
		
	}
	
}
