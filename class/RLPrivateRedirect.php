<?php 

class RLPrivateRedirect {
	private static $instance = null;
	
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function __construct() {
		add_action('init', array($this, 'init'));
	}
	
	public function init() {
		add_filter('groups_post_access_user_can_read_post', array($this, 'groups_post_access_user_can_read_post'), 10, 3);
	}
	
	public function groups_post_access_user_can_read_post($result, $post_id, $user_id) {
		if(!is_user_logged_in() && ! $result) {
			$group_ids   = Groups_Post_Access::get_read_group_ids( $post_id );
			if ( ! empty( $group_ids ) ) {
				self::redirect_login('groups');
			}
		}
	}
	
	protected function redirect_login($from = 'private') {
		$protocol = $_SERVER[ "HTTPS" ] == "on" ? 'https://' : 'http://';
		$location = wp_login_url( esc_url( $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) );
		wp_safe_redirect($location);
		exit;
	}
}

RLPrivateRedirect::get_instance();