<?php
/*
    Plugin Name: Cookie Wall for WordPress
    Plugin URI: http://cookiewallforwp.com
    Description: The Cookie Wall for WordPress is a plugin to comply with the EU law. Instead of offering a way to continue browsing without cookies, which possibly means loss of income for publishers, this cookie wall only accepts a confirmation.
    Version: 0.3.5
    Author: Level Level
    Author URI: http://level-level.com
    Text Domain: ll-cookie-wall
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LL_Cookie_Wall {
	public function __construct() {
		include_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
		load_plugin_textdomain( 'll-cookie-wall', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		add_action('init', array($this, 'plugin_init'));
		register_deactivation_hook( __FILE__, array( 'LL_Cookie_Wall', 'plugin_deactivation' ) );
	}

	public function plugin_init() {
		if( is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			include_once( plugin_dir_path( __FILE__ ) . 'admin/admin-cookie-wall.php' );
			new Admin_Cookie_Wall();
		} else {
			include_once( plugin_dir_path( __FILE__ ) . 'public/public-cookie-wall.php' );
			new Public_Cookie_Wall();
		}
	}

	/**
	 * On deactivation remove Apache rewrite rules
	 */
	public static function plugin_deactivation(){

		if ( ! isset( $_SERVER["SERVER_SOFTWARE"] ) && empty( $_SERVER["SERVER_SOFTWARE"] ) ) {
			return;
		}

		$server = strtolower( $_SERVER["SERVER_SOFTWARE"] );
		if ( strpos( $server, 'apache' ) !== false ) {
			self::plugin_deactivation_apache();
		}
	}
	/**
	 * Remove rewrite rules from .htaccess file
	 */
	public static function plugin_deactivation_apache(){
		$file = ABSPATH . '.htaccess';
		$current = file_get_contents($file);

		// Delete Plugin Cookie Rewrites
		$orginal_htaccess = preg_replace('/(\# BEGIN Cookie Rewrite.*\# END Cookie Rewrite)/s', '', $current);

		file_put_contents($file, $orginal_htaccess);
	}


}

new LL_Cookie_Wall();
