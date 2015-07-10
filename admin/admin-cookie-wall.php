<?php

class Admin_Cookie_Wall {
	public function __construct() {
		if( isset( $_GET['page'] ) ) {
			if( $_GET['page'] == 'll-cookie-wall-settings' ) {
				if ( isset( $_POST['llcw_submit'] ) ) {
					$this->save_settings();
				}
			}
		}

		add_action( 'admin_menu', array( $this, 'register_cookie_wall_settings_submenu_page' ) );
	}

	public function register_cookie_wall_settings_submenu_page() {
		add_submenu_page( 'options-general.php', 'Level Level - Cookie Wall', 'LL Cookie Wall', 'manage_options', 'll-cookie-wall-settings', array( $this, 'll_cookie_wall_page_callback' ) );
	}

	public function ll_cookie_wall_page_callback() {
		include_once( plugin_dir_path( __FILE__ ) . 'settings-template.php' );
	}

	private function save_settings() {
		$settings = get_option( 'llcw_settings' );

		if( isset( $_POST['llcw_description'] ) ) {
			$settings['description'] = $_POST['llcw_description'];
		}
		if( isset( $_POST['image_url'] ) ) {
			$settings['image_url'] = $_POST['image_url'];
		}
		if( isset( $_POST['llcw_title'] ) ) {
			$settings['title'] = $_POST['llcw_title'];
		}
		if( isset( $_POST['llcw_btn_text'] ) ) {
			$settings['button_text'] = $_POST['llcw_btn_text'];
		}
		if( isset( $_POST['llcw_url'] ) ) {
			$settings['page_url'] = $_POST['llcw_url'];
		}
		if( isset( $_POST['llcw_tracking_code'] ) ) {
			$settings['tracking_code'] = $_POST['llcw_tracking_code'];
		}

		update_option( 'llcw_settings', $settings );

		add_action( 'admin_init', array($this, 'change_htaccess'));
	}

	private function create_htaccess(){
		$blocked_agents = [
			'Internet\ Explorer',
			'MSIE',
			'Chrome',
			'Safari',
			'Firefox',
			'Windows',
			'Opera',
			'iphone',
			'ipad',
			'andriod',
			'blackberry',
		];
		$agents = implode('|', $blocked_agents);

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
		$new_htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
		$new_htaccess .= "RewriteCond %{HTTP_USER_AGENT} {$agents} \n";
		$new_htaccess .= "RewriteRule .* /cookie-wall?url_redirect=http%1://%{HTTP_HOST}%{REQUEST_URI} [R=302,L] \n";

		$new_htaccess .= "</IfModule>\n";
		$new_htaccess .= "# END Cookie Rewrite\n\n\n";

		return $new_htaccess;
	}

	public function change_htaccess(){
		global $wp_filesystem;

		// Get filesystem creds
		$url = wp_nonce_url(admin_url('options-general.php?page=ll-cookie-wall-settings'));
		if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) 
			return; // stop processing here

		// Check filesystem creds
		if(!WP_Filesystem($creds)) 
			return false;

		// Check if .htaccess exists
		$root = get_home_path();
		$htaccess_path = $root . '.htaccess';

		if( !$wp_filesystem->exists($root . '.htaccess') )
			return;

		$orginal_htaccess = $wp_filesystem->get_contents($htaccess_path);
		
		// Remove Cookie rewrites
		$orginal_htaccess = preg_replace('/(\# BEGIN Cookie Rewrite.*\# END Cookie Rewrite)/s', '', $orginal_htaccess);
		$orginal_htaccess = trim($orginal_htaccess);


		// Add Rewrite
		$new_htaccess = $this->create_htaccess();
		$new_htaccess .= $orginal_htaccess;

		// Update Cookie rewrites
		$wp_filesystem->put_contents($htaccess_path, $new_htaccess);
	}
}