<?php

namespace Models;

class Posts extends \Core\Model {
	/*
	 * Uncomment for custom primary key
	*/
	
	// protected $_primaryKey = 'myPrimaryKey';
	
	/*
	 * Uncomment for custom primary key
	*/
	
	// protected $_table = 'myTable';

	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $_rules = array (
			'title' => 'required,notNull',
			'body' => 'required'
	);
		
	/*
	 * Create custom validation rules
	 * by creating a method of the same name
	 * as the validation rule
	 */
	
 	public function _notNull($property, $data) {
 		
		// define the test to be performed
		if ( $data[$property] === 'NULL' ) {
			// and log a validation error if failed
			$this->_addValidationError($property, ucfirst($property) . ' should be not Null');
		}
	} 

}