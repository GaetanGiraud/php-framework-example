<?php
namespace Core;
/**
 * Database management and access class
 * This is a very basic level of abstraction
 */

class Database {
	
	/**
	 * Record the connection
	 */
	private $_connection;
	/**
	 * Queries which have been executed and then "saved for later"
	 */
	// private $_queryCache = array();
	
	/**
	 * Store the query to be built
	 * 
	 * @var String PDO Prepared statement string
	 */
	private $_query;
	
	/**
	 * Record the statement data for use in the prepared statement
	 * 
	 * @var Associative Array
	 */
	private $_stmtData = array ();
	
	/**
	 * The PDO statement to be executed
	 * 
	 * @var PDOStatement
	 */
	private $_stmt;
	
	/**
	 * Data which has been prepared and then "saved for later"
	 */
	private $_dataCache = array ();
	
	/**
	 * Record of the last query
	 */
	private $_last;
	
	public function __construct() {
	}
	
	/**
	 * All purpose query functionality. To be used when no other option is available
	 * @param String $query the sql query to be performed
	 * @return array of data fetched from database
	 */
	public function query($query)
	{
		$this->_query = filter_var($query, FILTER_SANITIZE_STRING);
		
		$this->_prepareQuery();
		
		$this->_executeQuery();
		
		$results = $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	
	/**
	 * Select in a table with options
	 * 
	 * @param String $table
	 *        	to query
	 * @param Array $params
	 *        	-
	 *        	Format: array(
	 *        	'fields' => array(
	 *        		'field1, 
	 *        		'field2'
	 *        	),
	 *        	'where' => array(
	 *        		'field1' => 'value1',
	 *        		'field2' => 'value2'
	 *        	),
	 *        	'order' => array(
	 *       	 	'fields' => array('field1', 'field2'),
	 *     		   	'order' => 'ASC' // optional
	 *        	),
	 *        	'limit' => 1
	 *        	)
	 */
	public function select($table, $params = NULL) {
		// If no parameters provided select everything from the table
		if (gettype ( $params ) !== 'array') {
			
			$this->_query = "SELECT * FROM $table";
		} else {
			
			// add fields clause
			if (! isset ( $params ['fields'] )) {
				
				$this->_query = "SELECT * FROM $table ";
			} else {
				$this->_query = "SELECT " . implode ( ',', $params ['fields'] ) . " FROM $table ";
			}
			
			// process parameters - order of processing need to follow 
			// the order of the clauses in a SQL query
			$this->_processParams ( $params, 'where' );
			$this->_processParams ( $params, 'order' );
			$this->_processParams ( $params, 'limit' );
		}
		
		$this->_prepareQuery ();
		
		$this->_executeQuery ();
		
		$results = $this->_stmt->fetchAll ( \PDO::FETCH_ASSOC );
		
		return $results;
	}
	
	
	/**
	 * Insert in a table a new record
	 * 
	 * @param String $table
	 *        	to query
	 * @param Array $insertData
	 *        	-
	 *        	Format: array(
	 *        	'field1' => 'value1',
	 *        	'field2' => 'value2'
	 *        	)
	 *        
	 * @return TRUE || PDO Error information
	 */
	public function insert($table, $insertData) 
	{	
		// Sanitize the data
		$insertData = $this->_sanitizeData($table, $insertData);
		
		// store the data in the stmtData variable for further use
		$this->_stmtData = $insertData;
		
		// initiate the query to be an INSERT
		$this->_query = "INSERT INTO $table ";
		
		{// prepare the VALUES part of the query
			
			$keys = array_keys ( $insertData );
			
			// add the field titles from the data array keys
			$this->_query .= ' (' . implode ( ',', $keys ) . ') ';
			
			// construct the named paramters:
			$named_parameters = array_map ( function ($key) {
				return ':' . $key;
			}, $keys );
			
			// Add the the named parameters to the query
			$this->_query .= ' VALUES (' . implode ( ',', $named_parameters ) . ') ';
		}
	
		$this->_prepareQuery();
		
		$result = $this->_executeQuery();
		if ($result !== TRUE) {
			return $result;
		} else {
			return $this->_connection->lastInsertId();
		}
		return ;
	}
	
	
	/**
	 * Update a record in a table
	 *
	 * @param String $table to query
	 * @param Array $recordId - Format array('primary key' => 'value')
	 * @param Array $updateData
	 *        	-
	 *        	Format: array(
	 *        	'field1' => 'value1',
	 *        	'field2' => 'value2'
	 *        	)
	 * @return TRUE || PDO Error information
	 */
	public function update($table, $recordId, $updateData) 
	{	
		// sanitize the data
		$updateData = $this->_sanitizeData($table, $updateData, $recordId);
		
		// initiate the query to be an UPDATE
		$this->_query = "UPDATE $table ";
		
		{ // create the SET part of the query
			$keys = array_keys ( $updateData );
			
			$update_parameters = array_map(function($key){
				return $key . '=:' . $key;
			}, $keys );
			
			$this->_query .= ' SET ' . implode(',', $update_parameters ) . ' ';
		}
		
		{ // create where clause
			$primaryKey = array_keys($recordId)[0]; // recover the primary key
			
			$this->_where ( array (
					$primaryKey => (int) $recordId[$primaryKey]
			) );
		}
		
		//TODO Better management of data in update statement
		// merge the updateData with the stmtData
		$this->_stmtData =  array_merge($updateData, $this->_stmtData);

		$this->_prepareQuery ();
		
		return $this->_executeQuery ();
	}
	
	
	/**
	 * Delete a record in a table
	 *
	 * @param String $table to query
	 * @param Array $recordId - Format array('primary key' => 'value')
	 * @return TRUE || PDO Error information
	 */
	public function delete($table, $recordId) 
	{
		$this->_query = "DELETE FROM $table ";
		
		{ 		// create where clause with $recordId
			$primaryKey = array_keys($recordId)[0]; // recover the primary key
				
			$this->_where ( array (
					$primaryKey => (int) $recordId[$primaryKey]
			) );
		}
		
		$this->_prepareQuery ();
	
		return $this->_executeQuery ();
	}
	
	/**
	 * Create a new database connection using PDO
	 *
	 * @param string $host
	 * @param string $dbname
	 * @param string $username
	 * @param string $passwd
	 * @param string $options
	 */
	private function _newConnection($host, $dbname, $username, $passwd, $options = NULL) {
		//TODO get db info from configuration
		// setting default options if not provided
		$options || $options = array (
		\PDO::MYSQL_ATTR_FOUND_ROWS => TRUE
		);
	
		try {
			// connect to the database
			$this->_connection = new \PDO ( 'mysql:host=' . $host . ';dbname=' . $dbname, $username, $passwd, $options );
				
			// set the error codes
			$this->_connection->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			trigger_error ( 'Error connecting to host: ' . $e->getMessage (), E_USER_ERROR );
		}
	}
	
	/**
	 * Connect to the database.
	 * Prepare the query and perform some error management.
	 * 
	 * @return void
	 */
	private function _prepareQuery() 
	{
			// Establish connection to the database if not already connected
		if (! $this->_connection || empty($this->_connection)) {
			
			  // retrieve the database configuration from the registry
			$config = Registry::getSetting('dbConfig');
			
			$this->_newConnection(
					$config['host'], 
					$config['database'], 
					$config['user'], 
					$config['password']);
		}
		
		if (! $stmt = $this->_connection->prepare ( $this->_query )) {
			trigger_error ( 'Problem preparing query', E_USER_ERROR );
		}
		$this->_stmt = $stmt;
	}
	
	
	/**
	 * Executes query and return sucess/failure of execution
	 * 
	 * @return boolean PDOStatement::errorInfo
	 */
	private function _executeQuery() 
	{
		$this->_stmt->execute ( $this->_stmtData );
		
		if ($this->_stmt->rowCount () > 0) {
			return true;
		} else {
			return $this->_stmt->errorInfo();
		}
	}
	
	
	/**
	 * Process common query parameters and call relevant subfunction
	 * 
	 * @param array $params
	 *        	see select, insert, update, delete functions for format definition
	 * @return void
	 */
	private function _processParams($params, $clause) 
	{
		$method = '_' . strtolower($clause);
		
		! isset ( $params[$clause] ) || ! $params [$clause]  || call_user_func(array($this, $method), $params [$clause] );
		
/* 		// if provided an order clause cal _order private function
		! isset ( $params ['order'] ) || ! $params ['order'] || $this->_order ( $params ['order'] );
		
		// if provided a limit clause call _limit private function
		! isset ( $params ['limit'] ) || ! $params ['limit'] || $this->_limit ( $params ['limit'] ); */
	}
	
	
	/**
	 * Prepare WHERE clause - only handling AND data for now - and adds it to the query
	 * 
	 * @param Array $whereData:
	 *        	conditions to be aggregated with the AND operator.
	 *        	Format:	array(
	 *        	'field1' => 'value1',
	 *        	'field2' => 'value2'
	 *        	)
	 * @return void
	 */
	private function _where($whereData) 
	{
		// record the where data inside the object statement data for further use.
		$this->_stmtData = $whereData;
		
		// Fetch the field names
		$fields = array_keys ( $whereData );
		
		// initiating the where clause
		$where_clause = ' WHERE ';
		
		// setting up a counter
		$count = 1;
		
		foreach ( $fields as $field ) {
			$where_clause .= $field . "=:" . $field;
			
			// For all iterations besides the last one add an AND operator
			if ($count < count ( $fields )) {
				$count ++;
				$where_clause .= ' AND ';
			}
		}
		
		$this->_query .= $where_clause;
	}
	
	
	/**
	 * Create a sql Order clause and adds it to the query
	 * 
	 * @param array $orderData.
	 *        	Format: array(
	 *        	'fields' => array('field1', 'field2'),
	 *        	'order' => 'ASC'
	 *        	)
	 * @return void
	 */
	private function _order($orderData) 
	{
		// if no order is supplied, default to DESC
		isset ( $orderData ['order'] ) || $orderData ['order'] = 'DESC';
		
		$this->_query .= " ORDER BY " . implode ( ',', $orderData ['fields'] ) . ' ' . $orderData ['order'];
	}
	
	
	/**
	 * Create a sql limit clause and adds it to the query
	 * 
	 * @param int $numRows        	
	 * @return void
	 */
	private function _limit($numRows) 
	{
		$this->_query .= " LIMIT " . ( int ) $numRows;
	}
	
	
	/**
	 * List fields from a table
	 * 
	 * @param string $table
	 * @return boolean
	 */
	private function _list_fields($table = '')
	{
		// Is there a cached result?
		if (isset($this->data_cache['field_names'][$table]))
		{
			return $this->data_cache['field_names'][$table];
		}
	
		if ($table == '')
		{
			return FALSE;
		}
		
		// only valid for MySQL
		$sql = 'SHOW COLUMNS FROM ' . $table ;
					
		$results = $this->query($sql);
		
		$retval = array();
		

		
		foreach ($results as $row)
		{
			if (isset($row['Field']))
			{
				$retval[] = $row['Field'];
			} else if (isset($row['FIELD'])) {
				$retval[] = $row['FIELD'];
			} else {
				$retval[] = current($row);
			}
		}

		$this->data_cache['field_names'][$table] = $retval;
		return $this->data_cache['field_names'][$table]; 
	}
	
	/**
	 * Keep only $data element matching fields in the $table
	 * Optional: strip the id if provided
	 * 
	 * @param string $table
	 * @param array $data
	 * @param string $id
	 * @return array:
	 */
	
	private function _sanitizeData($table, $data, $id = null) {		
		// remove the id from the data
		! $id || $data =  array_diff_key($data, $id);

		// keep only the fields that actuallty exist in the database
		return array_intersect_key($data, array_flip($this->_list_fields($table)));
	}
	
	
	
	/**
	 * Reset the connection
	 */
	public function __destruct() {
		$this->_connection = null;
	}
}