<?php

class Public_Cookie_Wall {
	public function __construct() {
		add_action( 'init', array( $this, 'custom_redirect' ) );
		add_action( 'parse_request', array( $this, 'custom_parse_request' ) );

		if( isset( $_POST['ll_agree_cookies'] ) ) {
			setcookie( "LLCW", 'll_cookie_wall', strtotime( '+365 days' ), '/' );
			if( isset( $_GET['url_redirect'] ) ) {
				header("Location: " . $_GET['url_redirect']);
				die();
			} else {
				header("Location: /");
				die();
			}
		}
	}

	public function custom_parse_request( &$wp) {
		if( isset( $wp->query_vars['name'] ) ) {
			if ( $wp->query_vars['name'] == 'cookie-wall' ) {
				include plugin_dir_path( __FILE__ ) . 'template-cookie-wall.php';
				exit();
			}
		}
		return;
	}

	public function custom_redirect() {
		add_rewrite_rule( 'cookie-wall', plugin_dir_path( __FILE__ ) . 'template-cookie-wall.php', 'top' );
	}
}