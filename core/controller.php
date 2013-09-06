<?php

namespace Core;

/**
 * Defines common behaviours of all controllers
 * 
 * @author GM Giraud
 * @abstract
 *
 */
abstract class Controller {
	
	/**
	 * Action to be performed - default to index
	 * 
	 * @var string
	 * @access protected
	 */
	protected $_action = 'index';
	
	/**
	 * Potential route defined record
	 * 
	 * @var string || int
	 * @access protected
	 * 
	 */
	protected $_recordId = null;
	
	/**
	 * Flag indicating if the layout has been loaded
	 *
	 * @var bool
	 * @access private
	 *
	 */
	private $_layoutLoaded = false;
	
	
	
	
	
	/**
	 * On instantiation call the route defined action
	 * 
	 */
	public function __construct() 
	{
		$this->_callAction();
	}
	
	/**
	 * Load the layout view from the controllers
	 * 
	 * @param string $view name of the view to be loaded
	 * @param array $data array of data to be used inside the view
	 * @access protected
	 * 
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
				// just load the requested view
			$filename = BASE_PATH . 'views/' . $view . '.php';
		}
		
		if (file_exists($filename)) {
			extract($data); // make the data available as variables
			
			include $filename;
		} else {
			exit('Can not find layout file');
		}
	
	}
	
	/**
	 * Perform the action 
	 * 
	 *  @access private
	 *  
	 */
	private function _callAction() 
	{
		$route = Registry::load('router')->getRoute();
		$action =  $route['action'];
			
		if(method_exists($this, $action)) {
			
			// if recordID if provided, save it for further use inside the controller
			! $route['recordId'] || $this->_recordId = $route['recordId'];
			
			// call the action
			call_user_func(array($this, $action));
			
		} else {
			redirectToRoot();
		}
	}
}