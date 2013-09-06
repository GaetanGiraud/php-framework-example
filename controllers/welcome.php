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

// All models should reside under the Controllers namespace
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