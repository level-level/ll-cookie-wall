<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$plugin_admin_path      = plugin_dir_path( __FILE__ );
$nginx_config_path      = $plugin_admin_path . 'config_files/nginx.conf';
$apache_config_path     = $plugin_admin_path . 'config_files/.htaccess';

$cookie_wall_options    = get_option( 'llcw_settings' );

$htaccess_content       = '';
$nginx_content          = '';
$description            = '';
$expiration             = '';
$title                  = __('Cookie Wall', 'll-cookie-wall');
$button_text            = __('I agree', 'll-cookie-wall');
$readmore_text          = __('Read more', 'll-cookie-wall');
$image_url              = '';
$logo                   = '';
$tracking_code          = '';
$custom_css         		= '';
$server_software        = '';
$blurry_background      = '';

$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';


if( isset( $_SERVER["SERVER_SOFTWARE"] ) && !empty( $_SERVER["SERVER_SOFTWARE"] ) ) {
	$server =  strtolower($_SERVER["SERVER_SOFTWARE"]);

	if ( strpos( $server ,'nginx' ) !== false ) {
		$server_software = 'nginx';
	} else if ( strpos( $server, 'apache' ) !== false ) {
		$server_software = 'apache';
	}
}
if( isset( $_POST['htaccess_content'] ) ) {
	$htaccess_content = $_POST['htaccess_content'];
}
if( isset( $_POST['nginx_content'] ) ) {
	$nginx_content = $_POST['nginx_content'];
}
if( isset( $cookie_wall_options['description'] ) ) {
	$description = $cookie_wall_options['description'];
}
if( isset( $cookie_wall_options['title'] ) ) {
	$title = $cookie_wall_options['title'];
}
if( isset( $cookie_wall_options['button_text'] ) ) {
	$button_text = $cookie_wall_options['button_text'];
}
if( isset( $cookie_wall_options['readmore_text'] ) ) {
	$readmore_text = $cookie_wall_options['readmore_text'];
}
if( isset( $cookie_wall_options['image_url'] ) ) {
	$image_url = $cookie_wall_options['image_url'];
}
if( isset( $cookie_wall_options['logo'] ) ) {
	$logo = $cookie_wall_options['logo'];
}
if( isset( $cookie_wall_options['tracking_code'] ) ) {
	$tracking_code = $cookie_wall_options['tracking_code'];
}
if( isset( $cookie_wall_options['custom_css'] ) ) {
	$custom_css = $cookie_wall_options['custom_css'];
}
if( isset( $cookie_wall_options['blurry_background'] ) ) {
	$blurry_background = $cookie_wall_options['blurry_background'];
}

wp_enqueue_script('jquery');

$description_editor_settings = array(
	'text_area_name'=>'description',
	'quicktags' => true,
	'tinymce' => true
);

$css_editor_settings = array(
	'text_area_name'=>'custom_css',
	'quicktags' => false,
	'media_buttons' => false,
	'tinymce' => false,
	'textarea_rows' => 8,
	'wpautop' => false
);
?>

<div class="wrap">
	<h2>Cookie Wall for WordPress</h2>

	<?php $errors = get_settings_errors('ll-cookie-wall'); ?>

		<?php
		if( empty( $errors ) && !empty( $htaccess_content ) && !empty( $nginx_content ) ) { ?>
			<div id="setting-error-settings_updated" class="notice notice-info settings-error is-dismissible" id="llcw_server_settings_popup"><?php
				if( $server_software == 'apache' ) {
					if( !empty( $htaccess_content ) ) {
						?>
						<h4><?php echo esc_html__( 'You are using an Apache server', 'll-cookie-wall' ) ?></h4>
						</div><!-- closing the notice box div -->
						<p class="description"><?php echo esc_html__( "We couldn't update your .htaccess file, but the code is necessary for this plugin to work properly. Please add the following snippet to your .htaccess file manually:", 'll-cookie-wall' ) ?></p>
						<textarea cols="130" rows="16" ><?php echo $htaccess_content; ?></textarea><?php
					}
				} else if( $server_software == 'nginx' ) {
					if( !empty( $nginx_content ) ) {
						?>
						<h4><?php echo esc_html__( 'You are using a Nginx server', 'll-cookie-wall' ) ?></h4>
						<p><?php echo esc_html__( "Notice! When deactivating this plugin don't forget to remove the following Nginx rules and reload your Nginx server.
						WordPress doesn\n't have access to do this automatically.", 'll-cookie-wall' ) ?></p>
						</div><!-- closing the notice box div -->
						<p class="description"><?php echo esc_html__( "The following code is necessary for this plugin to work properly. Please add the following snippet to your Nginx config manually:", 'll-cookie-wall' ) ?></p>
						<textarea cols="130" rows="17" ><?php echo $nginx_content; ?></textarea>
						<?php
					}
				} else {
					if ( ! empty( $htaccess_content ) || ! empty( $nginx_content ) ) {
						?>
						<h4><?php echo esc_html__( "We couldn't recognize the type of server you are using.", 'll-cookie-wall' ) ?></h4>
						<p class="description"><?php echo esc_html__( "Please add one of the following snippets to your .htaccess (if you're using Apache)", 'll-cookie-wall' ) ?></p>
						<textarea cols="130" rows="16"><?php echo $htaccess_content; ?></textarea>
						<p class="description"><?php echo esc_html__( "Or nginx-config (if you're using Nginx)", 'll-cookie-wall' ) ?></p>
						</div><!-- closing the notice box div -->
						<textarea cols="130" rows="15"><?php echo $nginx_content; ?></textarea><?php
					}
				}?>
			<br>
			<br>
			<!-- </div> this div of the notice is closed early within the if statements... -->
			<?php
		}
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=ll-cookie-wall-settings&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
		<a href="?page=ll-cookie-wall-settings&tab=rewrite-rules" class="nav-tab <?php echo $active_tab == 'rewrite-rules' ? 'nav-tab-active' : ''; ?>">Rewrite rules</a>
	</h2>
	<?php
	if( 'settings' == $active_tab ) {
		include_once( plugin_dir_path( __FILE__ ) . 'settings-template-form.php' );
	}
	if( 'rewrite-rules' == $active_tab ) {
		include_once( plugin_dir_path( __FILE__ ) . 'settings-template-rewrite-rules.php' );
	}
	?>
	<?php  ?>
</div>
