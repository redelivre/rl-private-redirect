<?php 

class RLPrivateRedirect {
	private static $instance = null;
	
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
}

RLPrivateRedirect::get_instance();