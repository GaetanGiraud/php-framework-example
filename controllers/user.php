<?php
namespace Controllers;

class User extends \Core\Controller {
	public function __construct() {
		parent::__construct();
		//echo '<br />you are now inside controller ' . __CLASS__ . '<br />';
	}
	
	public function index() {
		$data = array('subview' => 'test', 'helloYou' => 'HelloWorld');
		$helloYou = 'HelloWorld';
		$this->view('user/index', $data);
	}
}	