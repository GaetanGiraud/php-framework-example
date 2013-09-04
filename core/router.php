<?php
namespace Core;

class Router {
	
	/**
	 * Controller name
	 * 
	 * @var string
	 */
	private $_controller = 'Welcome';
	
	
	/**
	 * Route
	 * 
	 * @var array
	 */
	private $_route;
	
	public function __construct() {
		
	}
	
	/**
	 * Extrapolate route base on uri. 
	 * Call controller instantiation method
	 * 
	 * @param string $uri
	 */
	public function route($uri) {
		
		$uri = rtrim(ltrim($uri, '/'), '/');
		$this->_route = explode('/', $uri );
		
		// if no controller leave the controller to the default
		! $this->_route[0] || $this->_controller = $this->_route[0];
		
		$this->_loadcontroller();

	}
	
	/**
	 * Getter for _route property
	 */
	public function getRoute() {
		return $this->_route;
	}
	
	/**
	 * Check if controller exists && instantiate it
	 * @return Controller object
	 */
	private function _loadcontroller() {
		$class  = 'Controllers\\' . $this->_controller;
		
		if (class_exists($class, TRUE)) {
			// if the controller has been defined, instantiante controller
			return new $class($this->_route); 
		} else {
			//TODO root location defined inside config file
			header( 'Location: /' , true, 301) ;
			exit();
		}
	}
	
}
