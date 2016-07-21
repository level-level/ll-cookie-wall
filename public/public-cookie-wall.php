<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Public_Cookie_Wall {
	public function __construct() {

		add_action( 'init', array( $this, 'custom_redirect' ) );
		add_action( 'parse_request', array( $this, 'custom_parse_request' ) );
		add_filter( 'll_the_content', array( $this, 'custom_fold' ), 10, 3 );

		$domain = '.'.$_SERVER['SERVER_NAME'];

		if( isset( $_POST['ll_agree_cookies'] ) ) {

			setcookie( "ll_cookie_wall", 'll_cookie_wall', strtotime( '+365 days' ), '/', $domain );

			if( isset( $_GET['url_redirect'] ) ) {
				$qs = $_GET;

				unset( $qs['url_redirect'] );
				$url = $_GET['url_redirect'];
				// If we have some other remaining query string variables then append is to the string again.
				// Because url_redirect should be the only query string we have ;)
				if( !empty($qs) ) {
					$url = $url . '&' . http_build_query($qs, '&');
				}
				header("Location: " . urldecode( $_GET['url_redirect'] ) );
				die();
			} else {
				header("Location: /");
				die();
			}
		}
	}

	public function custom_fold( $content, $readmore, $button_txt ) {
		$content = htmlspecialchars_decode($content);
		$is_readmore = strpos($content,'[read-more]');
		$exploded = explode( '[read-more]', $content );

		$button = '<form method="POST" id="ll_cookie_form">
					<input type="hidden" name="ll_agree_cookies" value="1" />
					<input class="btn-accept" id="agree_with_cookie_terms" type="submit" name="ll_agree_cookies_button" value="'.$button_txt.'" />
					</form>';

		if(!$is_readmore) {
			$content .= $button;
		}

		if( is_array( $exploded ) && isset( $exploded[1] ) && $is_readmore) {
			$content = $exploded[0];
			$content .= $button;
			$content .= '<a id="expand_description">'. $readmore .'</a>';
			$content .= '<div id="llcw_read_more">';
			$content .= $exploded[1];
			$content .= $button;
			$content .= '</div>';
		}

		return $content;
	}

	public function custom_parse_request( &$wp) {
		if( isset( $wp->request ) ) {
			if ( strpos( $wp->request, 'cookie-wall' ) !== false || strpos( $wp->request, 'cookie_wall' ) !== false ) {
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