<?php
namespace Models;

class Posts extends \Core\Model {
	
	/**
	 * Validation rules
	 * 
	 * @var array
	 */
	public $_validationRules = array('title' => 'required');
	
}