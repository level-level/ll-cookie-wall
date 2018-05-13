<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin_Cookie_Wall {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_cookie_wall_settings_submenu_page' ) );
		if( ! $this->check_permissions() ) {
			return;
		}

		// Validate and add notices... need to use Settings API from start because if no error we need to save it
		add_action( 'admin_notices', array( $this, 'validate_settings') );
		add_action( 'admin_init', array($this, 'write_rewrite_rules'));

	}

	public function register_cookie_wall_settings_submenu_page() {
		add_submenu_page( 'options-general.php', 'Cookie Wall for WordPress', 'Cookie Wall for WP', 'manage_options', 'll-cookie-wall-settings', array( $this, 'll_cookie_wall_page_callback' ) );
	}

	public function ll_cookie_wall_page_callback() {
		include_once( plugin_dir_path( __FILE__ ) . 'settings-template.php' );
	}

	/**
	 * Check permission when the form has been submit
	 */
	private function check_permissions(){
		if( ! isset( $_GET['page'] ) || 'll-cookie-wall-settings' !== $_GET['page'] ) {
			return false;
		}

		// If form is submitted check nonce and save if it passes
		if ( isset( $_POST['llcw_submit'] ) ) {
			check_admin_referer( 'llcw_save_settings' ); // if false it just return false
			return true;
		}
	}

	/**
	 * Save settings to the options table
	 */
	private function save_settings() {
		$settings = get_option( 'llcw_settings' );

		if( isset( $_POST['llcw_description'] ) ) {
			$settings['description'] =  sanitize_text_field( $_POST['llcw_description'] );
		}
		if( isset( $_POST['image_url'] ) ) {
			$settings['image_url'] = sanitize_text_field( $_POST['image_url'] );
		}
		if( isset( $_POST['logo'] ) ) {
			$settings['logo'] = sanitize_text_field( $_POST['logo'] );
		}
		if( isset( $_POST['llcw_title'] ) ) {
			$settings['title'] = sanitize_text_field( $_POST['llcw_title'] );
		}
		if( isset( $_POST['llcw_btn_text'] ) ) {
			$settings['button_text'] = sanitize_text_field( $_POST['llcw_btn_text'] );
		}
		if( isset( $_POST['llcw_readmore_text'] ) ) {
			$settings['readmore_text'] = sanitize_text_field( $_POST['llcw_readmore_text'] );
		}
		if( isset( $_POST['llcw_tracking_code'] ) ) {
			$settings['tracking_code'] = sanitize_text_field( $_POST['llcw_tracking_code'] );
		}
		if( isset( $_POST['llcw_custom_css'] ) ) {
			$settings['custom_css'] = sanitize_text_field( $_POST['llcw_custom_css'] );
		}
		if( isset( $_POST['llcw_blurry_background'] ) ) {
			$settings['blurry_background'] = '1';
		} else {
			$settings['blurry_background'] = '0';
		}

		return update_option( 'llcw_settings', $settings );
	}

	/**
	 * Validate the settings
	 */
	public function validate_settings(){
		$errors = array();

		// Logo url
		if( isset( $_POST['logo'] ) ) {
			if( ! ( $error = $this->validate_url( $_POST['logo'] ) ) ){
				$this->add_error( __( 'The logo url you entered did not appear to be a valid URL. Please enter a valid URL.', 'll-cookie-wall' ), 'logo' );
				$errors['logo'] = $error;
			}
		}

		// WYSIWYG description
		if( isset( $_POST['llcw_description'] ) ) {
			if( empty( $_POST['llcw_description'] ) ){
				$this->add_error( __( 'The Cookies description may not be empty. Please enter description.', 'll-cookie-wall' ), 'llcw_description' );
			}
		}

		// Image url
		if( isset( $_POST['image_url'] ) && ! empty( $_POST['image_url'] ) ) {
			if( ! ( $error = $this->validate_url( $_POST['image_url'] ) ) ){
				$this->add_error( __( 'The image url you entered did not appear to be a valid URL. Please enter a valid URL.', 'll-cookie-wall' ), 'image_url' );
				$errors['image_url'] = $error;
			}
		}

		// The button text
		if( isset( $_POST['llcw_btn_text'] ) ) {
			if( empty( $_POST['llcw_btn_text'] ) ){
				$this->add_error( __( 'The Agree button text may not be empty. Please enter a text.', 'll-cookie-wall' ), 'llcw_btn_text' );
			}
		}

		// if no errors save, sad to so other changes be reset also, but that's the price of not using the Settings API

		if( empty( $errors ) ){
			$this->save_settings();
		}

		return $errors;

	}

	/**
	 * Validate an url
	 */
	private function validate_url( $value ){
		if ( preg_match( '#http(s?)://(.+)#i', $value ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Wrapper to add settings errors
	 */
	private function add_error( $error, $key ){
		if ( ! empty( $error ) ) {
			add_settings_error( "ll-cookie-wall", $key , $error, 'error' );
		}
	}

	/**
	 * From here on off it's all about create rewrite rules
	 */

	private function create_htaccess(){

		$plugin_admin_path  = plugin_dir_path( __FILE__ );
		$config_path      	= $plugin_admin_path . 'config_files/.htaccess';

		if( !is_dir( $plugin_admin_path . '/config_files' ) ) {
			mkdir( $plugin_admin_path . '/config_files' );
		}

		$agents = implode('|', $this->get_blocked_agents() );

		$new_htaccess = "# BEGIN Cookie Rewrite\n";
		$new_htaccess .= "<IfModule mod_rewrite.c>\n";

		$new_htaccess .= "RewriteEngine On\n";

		// Homepage
		$host = $_SERVER['HTTP_HOST'];

		$new_htaccess .= "RewriteCond %{HTTP_HOST} {$host} [NC]\n";
		$new_htaccess .= "RewriteCond %{REQUEST_URI} ^/$\n";
		$new_htaccess .= "RewriteCond %{HTTP_COOKIE} !^.*ll_cookie_wall.*\n";
		$new_htaccess .= "RewriteCond %{HTTP_USER_AGENT} {$agents} \n";
		$new_htaccess .= "RewriteRule .* /cookie-wall?url_redirect=http%1://%{HTTP_HOST}%{REQUEST_URI} [R=302,L]\n\n";


		// All other pages
		$new_htaccess .= "RewriteCond %{REQUEST_URI} !^/cookie-wall.*\n";
		$new_htaccess .= "RewriteCond %{HTTP_COOKIE} !^.*ll_cookie_wall.*\n";
		$new_htaccess .= "RewriteCond %{REQUEST_URI} !index.php\n";
		$new_htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
		// $new_htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n"; //not working with WordPress in subdirectories
		$new_htaccess .= "RewriteCond %{HTTP_USER_AGENT} {$agents} \n";
		$new_htaccess .= "RewriteRule .* /cookie-wall?url_redirect=http%1://%{HTTP_HOST}%{REQUEST_URI} [R=302,L] \n";

		$new_htaccess .= "</IfModule>\n";
		$new_htaccess .= "# END Cookie Rewrite\n\n\n";

		file_put_contents( $config_path, $new_htaccess );

		return $new_htaccess;
	}

	public function write_rewrite_rules(){
		global $wp_filesystem;

		// Add Rewrite
		$new_htaccess   = $this->create_htaccess();
		$new_nginx      = $this->create_nginx_rules();

		// Get filesystem creds

		$url = wp_nonce_url(admin_url('options-general.php?page=ll-cookie-wall-settings'));

		if ( false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
			$_POST['htaccess_content'] = $new_htaccess;
			$_POST['nginx_content']    = $new_nginx;
			return; // stop processing here
		}

		// Check filesystem creds
		if(!WP_Filesystem($creds)) {
			$_POST['htaccess_content'] = $new_htaccess;
			$_POST['nginx_content']    = $new_nginx;
			return false;
		}

		// Check if .htaccess exists
		$root = get_home_path();
		$htaccess_path = $root . '.htaccess';

		if( !$wp_filesystem->exists($root . '.htaccess') ) {
			$_POST['htaccess_content'] = $new_htaccess;
			$_POST['nginx_content']    = $new_nginx;
			return;
		}

		$orginal_htaccess = $wp_filesystem->get_contents($htaccess_path);

		// Remove Cookie rewrites
		$orginal_htaccess = preg_replace('/(\# BEGIN Cookie Rewrite.*\# END Cookie Rewrite)/s', '', $orginal_htaccess);
		$orginal_htaccess = trim($orginal_htaccess);

		$new_htaccess .= $orginal_htaccess;

		// Update Cookie rewrites
		$wp_filesystem->put_contents($htaccess_path, $new_htaccess);
	}

	private function create_nginx_rules() {
		$plugin_admin_path	= plugin_dir_path( __FILE__ );
		$config_path      	= $plugin_admin_path . 'config_files/nginx.conf';

		if( !is_dir( $plugin_admin_path . '/config_files' ) ) {
			mkdir( $plugin_admin_path . '/config_files' );
		}

		$agents = implode('|', $this->get_blocked_agents() );

		$content = '
set $ll_cookie_exist \'0\';
if ( $http_user_agent ~* \'(' . $agents . ')\' ) { 
	set $ll_cookie_exist \'1\';
}
if ( $http_cookie ~ "ll_cookie_wall=ll_cookie_wall" ) { 
	set $ll_cookie_exist \'0\'; 
}
if ($request_uri ~ ^/cookie-wall\?url_redirect ) {
	set $ll_cookie_exist \'0\';
}
if ($request_uri ~ ^/wp-content ) {
    set $ll_cookie_exist \'0\';
}
if ($request_uri ~ ^/wp-includes) {
    set $ll_cookie_exist \'0\';
}
if ( $ll_cookie_exist = \'1\' ) { 
	return 302 $scheme://$host/cookie-wall?url_redirect=$scheme://$host$request_uri; 
}';

		file_put_contents( $config_path, $content );

		return $content;
	}

	private function get_blocked_agents(){
		$blocked_agents = array (
			'Internet\ Explorer',
			'MSIE',
			'Chrome',
			'Safari',
			'Firefox',
			'Windows',
			'Opera',
			'iphone',
			'ipad',
			'android',
			'blackberry'
		);

		return apply_filters( 'llcw_blocked_agents', $blocked_agents );
	}
}
