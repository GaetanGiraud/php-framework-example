<?php
/**
 * 
 * An example of a custom helper
 * 
 * Tip: Avoid conflicts, check if function exists before declaring it.
 * 
 */

/*===================================================================================*/

/**
 * Example of a custom view helper
 * Return the framework version
 * 
 */
if (! function_exists('frameworkVersion')) {
	
	function frameworkVersion() {
		return VERSION;
	}
}