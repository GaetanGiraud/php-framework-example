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

namespace Core;

/**
 * Model validation class
 * 
 * @author Gaëtan Giraud
 *
 */
abstract class Validation {
	/**
	 * Records validation rules.
	 *
	 * @var array
	 */
	protected $_rules = array();
	
	/**
	 * Records validation errors.
	 * 
	 * @var array empty by default
	 */
	protected $_validationErrors = array();
	

	/**
	 * Getter for _validationErrors
	 * 
	 * @return array:
	 */
	public function getValidationErrors() 
	{
		return $this->_validationErrors;
	}
	
	/**
	 * Validate $data input against _validationRules
	 * 
	 * @param array $data
	 * @return boolean. Detailed errors reporting located in _validationErrors
	 */
	protected function _validate($data) 
	{
		if(!empty($this->_rules)) {
				
			foreach($this->_rules as $propery => $rules) {
				
				// rules should be comma delimited
				$rules = explode(',',$rules);
				
				foreach ($rules as $rule) {
					
					$method = $this->_getRuleMethod($rule);
					
					// perform the validation
					call_user_func(array($this, $method), $propery, $data);
				}
			}
	
		}
	
		// if the validation error array is not empty, validation fails
		if (!empty($this->_validationErrors)) {
			return FALSE;
		}
	
		return TRUE;
	}
	
	/**
	 * Add validation error message
	 * 
	 * @param string $property
	 * @param string $ermsg
	 */
	protected function _addValidationError($property, $ermsg)
	{
		// instantiate the array if not set
	 	if (!isset($this->_validationErrors[$property]) ) {
	 		$this->_validationErrors[$property] = array();
	 	
	 	}
 		$this->_validationErrors[$property][] = $ermsg;
	}
	
	
	/**
	 * Give a validation rule in input
	 * Return the corresponding method if it exists.
	 * 
	 * @param string $rule
	 * @return string 
	 */
	private function _getRuleMethod($rule)
	{
		if(method_exists($this, $rule)) {
			$method = $rule;
		} else if(method_exists($this, '_' . $rule)) {
			// cater for _ access indicator
			$method = '_' . $rule ;
		} else {
			trigger_error('Trying to apply non existant
								validation rule to model ' . get_class($this), E_USER_WARNING);
		}
		
		return $method;
	}
	
	/*===================================================================================
	 * 
	 * Validation methods
	 * 
	 * Validation methods must alway accept a $proterty and the $data set 
	 * to be validated against
	 * 
	 */
	
	/**
	 * check if $property is defined inside the $data set.
	 * 
	 * @param string $property
	 * @param array $data
	 */
	private function _required($property, $data) 
	{		
		if ( !isset ($data[$property]) || empty($data[$property]) ) {
				// if the property is not set or is empty, record a validation error
			$this->_addValidationError($property, ucfirst($property) . ' is required!');
		}
	}
	
	/*
	 * 
	 * Other validation rules to be implemented
	 * 
	 */
	private function _unique($property, $data) 
	{
		//TODO Create unique validation
	}
	
	private function _confirm($property, $data) 
	{
		//TODO Create confirmation validation
	}
	
	private function _email($property, $data) 
	{
		//TODO Create email validation
	}

}