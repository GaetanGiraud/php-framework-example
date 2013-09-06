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

/*===================================================================================
 * 
 * Core View helpers.
 * 
 * To be called exclusively inside a view.
 * 
 */

/**
 * Retrieve the content of the Flash
 * 
 * @return Core\Flash
 */

if (!function_exists('flash')) {
	function flash()
	{
		return Core\Flash::retrieve();
	}
}


/**
 * Create anchor with fully qualified urls
 * 
 * @param string $url
 * @param string $value
 * @param string $title
 * @return string
 */
if (!function_exists('link_to')) {
	function link_to($url, $value, $title = null) 
	{
		$html = '<a href="' . FQDN .  $url . '"';
		!$title || $html .= ' title="' . $title . '" ';
		$html .= '>' . $value . '</a>';
		
		return $html;
	}
}

/**
 * Extract and format validation errors
 * 
 * @param Core\Model $object
 * @return string
 */
if (!function_exists('validationErrors')) {
	function validationErrors( Core\Model $object) 
	{
		$html = '';
		if ($object->getValidationErrors() !== array() ) {
			
			foreach ($object->getValidationErrors() as $field => $errors) {
				$html .= '<h3>'. ucfirst($field) . '</h3>';
				$html .= '<ul>';
				foreach ($errors as $error) {
					$html .= '<li>'. $error . '</li>';
				}
				$html .= '</ul>';
			}
			
		} 
		
		return $html;
	}
}

/**
 * Text input helper
 * 
 * @param string $name
 * @param array $options
 * @return string
 */
if (!function_exists('input')) {
	function input($name, $options = array()) 
	{
		$html = '<input type="text" id="'. $name . '" name="'. $name . '"';
		// process the options
		$html .= processOptions($options);
		$html .= '>';
		return $html;
	}
}

/**
 * Textarea helper
 * 
 * @param string $name
 * @param string $value
 * @param array $options
 * @return string
 */
if (!function_exists('textarea')) {
	function textarea($name, $value = null, $options = array())
	{
		$html = '<textarea id="'. $name. '" name="'. $name . '"';
		$html .= processOptions($options);	
		$html .= '>';
		! $value || $html .= $value;
		$html .=  '</textarea>';
		return $html;
	}
}

/**
 * Submit button helper
 * 
 * @param string $value
 * @param array $options
 * @return string
 */
if (!function_exists('submit')) {
	function submit($value, $options = array()) 
	{
		$html = '<input type="submit"';
		$html .= processOptions($options);
		$html .= ' value="'. $value . '">';
		return $html;
	}
}

/**
 * Return url from uri
 * 
 * @param string $url
 * @return string
 */
if (!function_exists('base_url')) {
	function base_url($uri) 
	{
		return FQDN . '/' . $uri;
	}
}

/**
 * Process html tag options 
 * 
 * @param array $options
 * @return string
 */
if (!function_exists('processOptions')) {
	function processOptions($options) 
	{
		$html = '';
		foreach($options as $key => $value ) {
		
			$html .= ' '. $key . '="'. $value . '"';
		}
		
		return $html;
	}
}