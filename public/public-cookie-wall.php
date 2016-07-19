<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Public_Cookie_Wall {
	public function __construct() {

		add_action( 'init', array( $this, 'custom_redirect' ) );
		add_action( 'parse_request', array( $this, 'custom_parse_request' ) );
		add_filter( 'll_the_content', array( $this, 'custom_fold' ), 10, 3 );
		add_filter( 'wp_safe_redirect_fallback', array( $this, 'safe_redirect_fallback') );

		add_action( 'llcw_head', array( $this, 'enqueue_styles' ) );
		add_action( 'llcw_footer', array( $this, 'enqueue_scripts' ) );

		$domain = '.'.$_SERVER['SERVER_NAME'];
		$ll_agree_cookies = ( isset( $_POST['ll_agree_cookies'] ) ) ? $_POST['ll_agree_cookies'] : false;

		if( intval( $ll_agree_cookies ) ) {

			setcookie( "ll_cookie_wall", 'll_cookie_wall', strtotime( '+365 days' ), '/', $domain );

			if( isset( $_GET['url_redirect'] ) ) {
				wp_safe_redirect( esc_url( $_GET['url_redirect'] ) );
				die();
			} else {
				wp_safe_redirect( $this->safe_redirect_fallback() );
				die();
			}
		}
	}

	public function custom_fold( $content, $readmore, $button_txt ) {
		$content 	 = htmlspecialchars_decode($content);
		$is_readmore = strpos($content,'[read-more]');
		$exploded 	 = explode( '[read-more]', $content );

		// We need to esc user content per variable in this function because we can't do it in the template
		$button = '<form method="POST" id="ll_cookie_form">
					<input type="hidden" value="1" name="ll_agree_cookies">
					<input class="btn-accept" id="agree_with_cookie_terms" type="submit" name="ll_agree_cookies_button" value="' . esc_attr( $button_txt ) . '" />
				   </form>';

		if( ! $is_readmore ) {
			$content .= $button;
		}

		if( is_array( $exploded ) && isset( $exploded[1] ) && $is_readmore) {
			$content =  wp_kses_post( $exploded[0] );
			$content .= $button;
			$content .= '<a id="expand_description">'. esc_html( $readmore ) .'</a>';
			$content .= '<div id="llcw_read_more">';
			$content .= wp_kses_post( $exploded[1] );
			$content .= $button;
			$content .= '</div>';
		}

		return $content;
	}

	/**
	 * Check if we are on the custom rewrite rule and load the Cookie Wall template
	 */
	public function custom_parse_request( &$wp) {
		if( isset( $wp->request ) ) {
			if ( strpos( $wp->request, 'cookie-wall' ) !== false || strpos( $wp->request, 'cookie_wall' ) !== false ) {
				include plugin_dir_path( __FILE__ ) . 'template-cookie-wall.php';
				exit();
			}
		}
		return;
	}

	/**
	 * Add our custom cookie-wall rewrite rule
	 */
	public function custom_redirect() {
		add_rewrite_rule( 'cookie-wall', plugin_dir_path( __FILE__ ) . 'template-cookie-wall.php', 'top' );
	}

	/**
	 * Returns the redirect fallback url
	 * Example: Redirects to home when redirect is not safe instead to wp-admin
	 */
	public function safe_redirect_fallback(){
		return get_home_url();
	}

	/**
	 * Kinds of proper way to enqueue scripts and styles
	 */
	function enqueue_styles() {
		if( apply_filters( 'llcw_enqueue_styles', true ) ) { ?>
		<link href="<?php echo apply_filters('llcw_stylesheet_url', plugin_dir_url( __DIR__ ) . 'assets/css/style.css' ); ?>" media="all" rel="stylesheet" />
	<?php
		} //end if
	}

	function enqueue_scripts() {
		if( apply_filters( 'llcw_enqueue_scripts', true ) ) { ?>
			<script type='text/javascript' src="<?php echo apply_filters('llcw_scripts_url', plugin_dir_url(__DIR__) . 'assets/js/scripts.js'); ?>"></script>
		<?php
		} //end if
	}

}