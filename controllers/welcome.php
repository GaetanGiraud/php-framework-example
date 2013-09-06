<?php
namespace Controllers;

/**
 * This is the default controller for the Document root
 * Edit the config file to use another controller.
 * 
 * @author Gaëtan Giraud
 *
 */
class Welcome extends \Core\Controller {
	
	public function index() {
		$this->view('index');
	}
}