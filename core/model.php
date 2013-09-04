<?php
namespace Core;

abstract class Model extends Validation {
	
	
	//TODO Table name inside a variable
	
	/**
	 * Construct an on object and load the $data provided
	 * as public properties.
	 * 
	 * @param array $data object properties in an associative array.
	 */
	public function __construct($data = null) {
		if ($data) {
			foreach($data as $k => $value) {
				$this->{$k} = $value;
			}
		}
	}
	
	
	/**
	 * Get all the records for the calling class.
	 * 
	 * @param string $limit
	 */
	public static function get($limit = null) {
		//TODO allow for ordering
		$db = Registry::singleton()->getObject('db');
		
		// remove the namespace (Models\ length = 7)  and retrieve the table name from the class name
		$table = strtolower(substr(get_called_class(), 7));
		
		return $db->select($table, array('limit' => $limit));

	}
	
	/**
	 * Find a record in the database and create a record object
	 * 
	 * @param array $id = array('primary key' =>  'value')
	 * @return object|false return an object or false if record not found
	 */
	
	public static function find($id) {
		$db = Registry::singleton()->getObject('db');
		$class = get_called_class();
		
		// remove the namespace (Models\ length = 7)  and retrieve the table name from the class name
		$table = strtolower(substr($class, 7));
		
		// retrieve the primary key
		$primary_key = array_keys($id)[0];
		
		// retrieve the relevant data in the database
		$data = $db->select($table, array (
				'where' => array($primary_key => $id[$primary_key]),
				'limit' => 1
				));
		
		//TODO error handling
		if (!empty($data)) {
			return new $class($data[0]);
		} else {
			return FALSE;
		}
	
	}
	
	
	/**
	 * Update the record object property with $data.
	 * 
	 * Do not save into the database.
	 * @param array $data
	 */
	public function update($data) {
		foreach ($data as $key => $value) {
			// check if property exists - update the value is property is defined
			if(property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}
	
	
	/**
	 * Save a record in the database.
	 * 
	 * @return boolean Succes or failure of the operation
	 */
	public function save() {
		$db = Registry::singleton()->getObject('db');

		// remove the namespace (Models\ length = 7)  and retrieve the table name from the class name
		$table = strtolower(substr(get_class($this), 7));
		
		// get the object variables as data input for the update.
		$data = get_object_vars($this);
		
		//TODO make the primary key a variable
		if($this->_validate($data)) {
			
			if (isset($data['id']) && !empty($data['id'])) {
				// id defined and not empty => UPDATE
				return $db->update($table, array('id' => $data['id']), $data);
			} else {	
				// id undefined or empty => INSERT			
				return $db->insert($table, $data);
			}
		} else {
			return FALSE;
		}
	
	}
	
	
	/**
	 * Delete a record in the database.
	 * 
	 * @return 
	 */
	public function delete() {
		$db = Registry::singleton()->getObject('db');
		
		// remove the namespace (Models\ length = 7)  and retrieve the table name from the class name
		$table = strtolower(substr(get_class($this), 7));

		//TODO make the primary key a variable
		
		return $db->delete($table, array('id' => $this->id));

	}
	
}