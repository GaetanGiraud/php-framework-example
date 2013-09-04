<?php
namespace Core;

class Common {
	
	
	public function redirect($uri) {
		if ($uri != '/') {
			// redirect to root when action is not found
			header( 'Location: /' , true, 301) ;
			exit();
		} else {
			trigger_error('Infinite loop on the root page prevented. Please define an index action for the root.', E_USER_ERROR);
		}
	}
	
}