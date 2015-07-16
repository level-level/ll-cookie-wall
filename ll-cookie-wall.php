<?php
/*
    Plugin Name: Level Level Cookie Wall
    Plugin URI: http://level-level.com
    Description: Blocks site until cookies are accepted - by EU cookie law 2015
    Version: 1.0
    Author: Level Level
    Author URI: http://level-level.com
    Text Domain: ll-cookie-wall
 */

class LL_Cookie_Wall {
	public function __construct() {
		load_plugin_textdomain( 'll_cookie_wall', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		if( is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			include_once( plugin_dir_path( __FILE__ ) . 'admin/admin-cookie-wall.php' );
			new Admin_Cookie_Wall();
		} else {
			include_once( plugin_dir_path( __FILE__ ) . 'public/public-cookie-wall.php' );
			new Public_Cookie_Wall();
		}
	}
}

new LL_Cookie_Wall();