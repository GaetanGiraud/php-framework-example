<?php
namespace Core;

class Router {
	
	private $_controller = 'Welcome';
	private $_route;
	
	public function __construct() {
		
	}
	
	public function _route($uri) {
		
		$uri = rtrim(ltrim($uri, '/'), '/');
		$this->_route = explode('/', $uri );
		
		// if no controller leave the controller to the default
		! $this->_route[0] || $this->_controller = $this->_route[0];
		
		$controller = $this->_loadcontroller();

	}
	
	public function getRoute() {
		return $this->_route;
	}
	
	private function _loadcontroller() {
		$object  = 'Controllers\\' . $this->_controller;
		
		return new $object($this->_route); // instantiante controller
	}
	
}
