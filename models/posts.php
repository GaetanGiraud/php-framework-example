<?php

namespace Models;

class Posts extends \Core\Model {
	/*
	 * Uncomment for custom primary key
	*/
	
	// protected $_primaryKey = 'myPrimaryKey';
	
	/*
	 * Uncomment for custom table name
	*/
	
	// protected $_table = 'myTable';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $_rules = array (
			'title' => 'required'
	);

}