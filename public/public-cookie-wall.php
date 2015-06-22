<?php
/**
 * Created by PhpStorm.
 * User: Jos Achterberg
 * Date: 22-06-15
 * Time: 10:16
 */

class Public_Cookie_Wall {
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'check_cookie' ), 1 );
	}

	public function check_cookie() {
		if( isset( $_COOKIE['LLCW'] ) ) {
			// Nothing to do here
		} else {
			$cookie_wall_options = get_option( 'llcw_settings' );

			if( isset( $_GET['llcw_cookie_agreement'] ) && $_GET['llcw_cookie_agreement'] == "accept" ) {
				$expiration = $cookie_wall_options['expiration'];
				setcookie( "LLCW", 'll_cookie_wall', time() + $expiration, '/' );
			} else {
				include_once( plugin_dir_path( __FILE__ ) . 'template-cookie-wall.php' );
				exit;
			}
		}
	}
}
