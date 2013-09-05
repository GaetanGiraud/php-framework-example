<?php
	
function flash()
{
	return Core\Flash::retrieve();
}


/**
 * Create anchor links with fully qualified urls
 * 
 * @param string $url
 * @param string $value
 * @param string $title
 * @return string
 */
function link_to($url, $value, $title = null) 
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
function validationErrors( Core\Model $object) 
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

/**
 * Text input helper
 * 
 * @param string $name
 * @param array $options
 * @return string
 */
function input($name, $options = array()) 
{
	$html = '<input type="text" id="'. $name . '" name="'. $name . '"';
	// process the options
	$html .= processOptions($options);
	$html .= '>';
	return $html;
}

/**
 * Textarea helper
 * 
 * @param string $name
 * @param string $value
 * @param array $options
 * @return string
 */
function textarea($name, $value = null, $options = array())
{
	$html = '<textarea id="'. $name. '" name="'. $name . '"';
	$html .= processOptions($options);	
	$html .= '>';
	! $value || $html .= $value;
	$html .=  '</textarea>';
	return $html;
}

/**
 * Submit button helper
 * 
 * @param string $value
 * @param array $options
 * @return string
 */
function submit($value, $options = array()) 
{
	$html = '<input type="submit"';
	$html .= processOptions($options);
	$html .= ' value="'. $value . '">';
	return $html;
}

/**
 * Return url from uri
 * 
 * @param string $url
 * @return string
 */
function base_url($uri) 
{
	return FQDN . '/' . $uri;
}


/**
 * Process html tag options 
 * 
 */
function processOptions($options) 
{
	$html = '';
	foreach($options as $key => $value ) {
	
		$html .= ' '. $key . '="'. $value . '"';
	}
	
	return $html;
}