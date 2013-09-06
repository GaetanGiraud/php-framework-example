<?php
namespace Core;

/**
 * Custom error handler class.
 * For making php error children of Exception class
 * 
 * @author Gaëtan Giraud
 *
 */
class ErrorHandler extends \Exception {
	/**
	 * Protect the severity of the error
	 * 
	 * @var string
	 */
	protected $severity;
	
	/**
	 * Construct an ErrorHanlder object
	 * 
	 * @param string $message
	 * @param string $code
	 * @param string $severity
	 * @param string $filename
	 * @param string $lineno
	 */
	public function __construct($message, $code, $severity, $filename, $lineno) 
	{
		$this->message = $message;
		$this->code = $code;
		$this->severity = $severity;
		$this->file = $filename;
		$this->line = $lineno;
	}
	
	/**
	 * Getter for the error severity
	 * @return string
	 */
	public function getSeverity() 
	{
		return $this->severity;
	}
}