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
		if( isset( $_POST['llcw_expiration'] ) ) {
			$settings['expiration'] = $_POST['llcw_expiration'];
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
		update_option( 'llcw_settings', $settings );
	}
}

