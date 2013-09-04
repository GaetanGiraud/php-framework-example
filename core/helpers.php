<?php
namespace Core;

class Helpers {
	
	public function __construct() {
		
	}
	
	
	/**
	 * Create anchor links with fully qualified urls
	 * 
	 * @param string $url
	 * @param string $value
	 * @param string $title
	 * @return string
	 */
	public function link($url, $value, $title = null) 
	{
		$html = '<a href="' . FQDN .  $url . '"';
		!$title || $html .= ' title="' . $title . '" ';
		$html .= '>' . $value . '</a>';
		
		return $html;
	}
	
	/**
	 * Extract and format validation errors
	 * 
	 * @param Core\Model $object
	 * @return string
	 */
	public function validationErrors( Model $object) 
	{
		$html = '';
		if ($object->getValidationErrors() !== array() ) {
			$html .= '<ul>';
			foreach ($object->getValidationErrors() as $field => $error) {
				$html .= '<li>'. $error . '</li>';
			}
			$html .= '</ul>';
		} 
		
		return $html;
	}
	
	public function input($name, $options = array()) 
	{
		$html = '<input type="text" id="'. $name . '" name="'. $name . '"';
		// process the options
		$html .= $this->_processOptions($options);
		$html .= '>';
		return $html;
	}

	public function textarea($name, $value = null, $options = array())
	{
		$html = '<textarea id="'. $name. '" name="'. $name . '"';
		$html .= $this->_processOptions($options);	
		$html .= '>';
		! $value || $html .= $value;
		$html .=  '</textarea>';
		return $html;
	}
	
	public function submit($value, $options = array()) 
	{
		$html = '<input type="submit"';
		$html .= $this->_processOptions($options);
		$html .= ' value="'. $value . '">';
		return $html;
	}

	public function base_url($url) 
	{
		return FQDN . '/' . $url;
	}
	
	private function _processOptions($options) 
	{
		$html = '';
		foreach($options as $key => $value ) {
		
			$html .= ' '. $key . '="'. $value . '"';
		}
		
		return $html;
	}
}