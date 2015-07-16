<?php

class Public_Cookie_Wall {
	public function __construct() {
		add_action( 'init', array( $this, 'custom_redirect' ) );
		add_action( 'parse_request', array( $this, 'custom_parse_request' ) );
		add_filter( 'the_content', array( $this, 'custom_fold' ) );

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

	public function custom_fold( $content ) {
		$exploded = explode( '[read-more]', $content );

		if( is_array( $exploded ) && isset( $exploded[1] ) ) {
			$content = $exploded[0];
			$content .= '<a id="expand_description">Lees verder</a>';
			$content .= '<div id="llcw_read_more">';
			$content .= $exploded[1];
			$content .= '</div>';
		}

		return $content;
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