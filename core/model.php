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
 * Defines common behaviours for all models
 * 
 * All Models should inherit from Core\Model
 * 
 * Implements the Factory design pattern
 * 
 * @author Gaëtan Giraud
 * @abstract
 *
 */
abstract class Model extends Validation {
	
	/**
	 * The model primary key - set by default to id.
	 * Overwrite in implementing class for custom primary key
	 * 
	 * @var string
	 */
	protected $_primaryKey = 'id';
	
	
	/**
	 * The model corresponding table name - set by default to the implementing class name.
	 * Overwrite in implementing class for custom table name
	 *
	 * @var string
	 */
	protected $_table;
	
	
	/**
	 * Construct an on object and load the $data provided
	 * as public properties.
	 * 
	 * @param array $data optional properties
	 */
	public function __construct($data = null) 
	{
		if (!$data) {
			$db = Registry::load('database');
			$fields = $db->getFields($this->_getTableName());
			$data = array();
			
			foreach ($fields as $field) {
				$data[$field] = '';
			}
		}
		foreach ($data as $key => $value) {
			$this->{$key} = $value;
		}
		
	}
	
	
	/**
	 * Get all the records for the calling class.
	 * 
	 * @param string $limit
	 * @return array of objects
	 */
	public static function get($order = null, $limit = null) 
	{
		$db = Registry::load('database');
		$class = get_called_class();
		
		// create empty object to recover the table name
		$object = new $class();
		$table = $object->_getTableName();
		unset($object); // we dont need this object anymore
		
		// fetch data in the database
		$results = $db->select($table, array('order' => $order, 'limit' => $limit));
		
		// convert the data into record objects
		$objects = array();
		
		foreach($results as $result) {
			// create a new object and store it in the objects array
			$objects[] = new $class($result);
		}
		
		return $objects;
	}
	
	
	/**
	 * Find a record in the database and create a record object
	 * 
	 * @param array $id = array('primary key' =>  'value')
	 * @return object|false return an object or false if record not found
	 * 
	 */
	public static function find($id) 
	{
		$db = Registry::load('database');
		$class = get_called_class();
		
		// create an empty object
		$object = new $class();
		
 		// retrieve the relevant data in the database
		$data = $db->select($object->_getTableName(), array (
				'where' => array($object->_primaryKey => $id),
				'limit' => 1
				));
		
		if ($data && !empty($data)) {
			$object->set($data[0]);
			
			return $object;
		} else {
			return FALSE;
		}
	
	}
	
	
	/**
	 * Set the record object properties with $data.
	 * 
	 * Do not save into the database.
	 * 
	 * @param array $data
	 * @param boolean $force force creation of properties if not already defined
	 */
	public function set($data) 
	{
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
		$db = Registry::load('database');

		$table = $this->_getTableName();
		$pkey = $this->_primaryKey;
		
		// get the object variables as data input for the update.
		$data = get_object_vars($this);
		
		// validate the data
		if($this->_validate($data)) {
			
			if (isset($data[$pkey]) && !empty($data[$pkey])) {
				
				// primary key defined and not empty => UPDATE
				return $db->update($table, array($pkey => $data[$pkey]), $data);
				
			} else {	
				
				// primary key undefined or empty => INSERT			
				return $db->insert($table, $data);
				
			}
		} else {
			return FALSE;
		}
	
	}
	
	
	/**
	 * Delete a record in the database.
	 * 
	 * @return bool success / failure of the operation
	 */
	public function delete() 
	{
		$db = Registry::load('database');

		$table = $this->_getTableName();
		
		$pkey = $this->_primaryKey;
		
		return $db->delete($table, array($pkey => $this->{$pkey}));

	}
	
	/**
	 * Return the table if defined.
	 * Otherwise assumes the table name to be the name of the calling class
	 * 
	 * @return string
	 * @access private
	 */
	private function _getTableName()
	{
		if(isset($this->_table) && !empty($this->_table)) {
			return $this->_table;
		} else {
			// assume that the table has the same name as the class
			$this->_table = strtolower(substr(get_class($this), 7));
			
			return $this->_table;
		}
	}
	
}