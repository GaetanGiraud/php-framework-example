<?php
namespace Core;

abstract class Validation {

	/**
	 * Records validation errors.
	 * 
	 * @var array empty by default
	 */
	protected $_validationErrors = array();
	
	/**
	 * Records validation rules.
	 * 
	 * @var array
	*/
	protected $_validationRules = array();
	

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
			// if there are validation rules defined, process them
		if(!empty($this->_validationRules)) {
				
				// for each validation rule, check if the provided data meet the rule
			foreach($this->_validationRules as $propery => $rule) {
	
				$method = '_' . $rule; // one method per rule
				
				if(method_exists($this, $method)) {
					
					call_user_func(array($this, $method), $propery, $data);
						
				} else {
					// TODO add error processing if validation does not exist
					// do nothing for now
				}
					
			}
	
		}
	
		// if the validation error array is not empty, validation failed
		if (!empty($this->_validationErrors)) {
			return FALSE;
		}
	
		return TRUE;
	}
	
	
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
			$this->_validationErrors[$property] = ucfirst($property) . ' is required';
				
		}
	}
	
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