<?php
namespace Controllers;

class Welcome extends \Core\Controller {
	
	public function __construct() {
		parent::__construct();
		//echo 'you are now inside controller ' . __CLASS__ . '<br />';
	}
	
	public function index() {
		echo 'Infinite loop prevented ! <br />';
	}
}