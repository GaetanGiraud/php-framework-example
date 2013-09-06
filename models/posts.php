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

// All models should reside under the Models namespace
namespace Models;

/**
 * Skeleton Model class supporting the Posts CRUD application skeleton
 * 
 * @author gaetan
 *
 */
class Posts extends \Core\Model {
	/*
	 * Uncomment for custom primary key - default to id
	 */
	
	// protected $_primaryKey = 'myPrimaryKey';
	
	/*
	 * Uncomment for custom tabke name - default to class name
	 */
	
	// protected $_table = 'myTable';

	
	/**
	 * Validation rules
	 *
	 * Rules are defined in a comma separated per field
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