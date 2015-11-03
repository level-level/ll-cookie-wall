<?php

/*
 * Todo:
 * X Afvangen apache of nginx
 * - Nginx code schrijven
 * X Meer uitleg
 * X Wysiwyg
 * X Read-more shortcode > uitschuiven met jQuery
 * X Feedback voor background img (formaat etc.)
 * X Logo (optioneel)
 * X Multilangual
 * X Blurry background
 *
 */

$plugin_text_domain     = 'll_cookie_wall';

$plugin_admin_path      = plugin_dir_path( __FILE__ );
$nginx_config_path      = $plugin_admin_path . 'config_files/nginx.conf';

$cookie_wall_options    = get_option( 'llcw_settings' );

$htaccess_content       = '';
$nginx_content          = '';
$description            = '';
$expiration             = '';
$title                  = 'Cookie Wall';
$button_text            = 'I agree';
$readmore_text          = 'Read more';
$image_url              = '';
$logo                   = '';
$tracking_code          = '';
$server_software        = '';
$blurry_background      = '';

if( isset( $_SERVER["SERVER_SOFTWARE"] ) && !empty( $_SERVER["SERVER_SOFTWARE"] ) ) {
	if ( strpos( $_SERVER["SERVER_SOFTWARE"],'nginx' ) !== false ) {
		$server_software = 'nginx';
	} else if ( strpos( $_SERVER["SERVER_SOFTWARE"],'apache' ) !== false ) {
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
if( isset( $cookie_wall_options['blurry_background'] ) ) {
	$blurry_background = $cookie_wall_options['blurry_background'];
}

wp_enqueue_script('jquery');
wp_enqueue_media();

$tiny_mce_settings = array(
	'quicktags' => array('buttons' => 'em,strong,link',),
	'text_area_name'=>'extra_content',//name you want for the textarea
	'quicktags' => true,
	'tinymce' => true
);
?>

<div class="wrap">
	<h2>Cookie Wall for WordPress</h2>

		<?php
		$server_software = '';
		if( !empty( $htaccess_content ) && !empty( $nginx_content ) ) { ?>
			<div class="updated" id="llcw_server_settings_popup"><?php
				if( $server_software == 'apache' ) {
					if( !empty( $htaccess_content ) ) {
						?><h4><?php echo esc_html__( 'You are using an Apache server', $plugin_text_domain ) ?></h4>
						<span class="description"><?php echo esc_html__( "We couldn't update your .htaccess file, but the code is necessary for this plugin to work properly.
					Please add the following snippet to your .htaccess file manually:", $plugin_text_domain ) ?></span>
						<br>
						<textarea cols="130" rows="18" ><?php echo $htaccess_content; ?></textarea><?php
					}
				} else if( $server_software == 'nginx' ) {
					if( !empty( $nginx_content ) ) {
						?><h4><?php echo esc_html__( 'You are using an Nginx server', $plugin_text_domain ) ?></h4>
						<span class="description"><?php echo esc_html__( "The following code is necessary for this plugin to work properly.
					Please add the following snippet to your Nginx config manually:", $plugin_text_domain ) ?></span>
						<br>
						<textarea cols="130" rows="5" ><?php echo $nginx_content; ?></textarea><?php
					}
				} else {
					if ( ! empty( $htaccess_content ) || ! empty( $nginx_content ) ) {
						?>
						<h4><?php echo esc_html__( "We couldn't recognize the type of server you are using.", $plugin_text_domain ) ?></h4>
						<span class="description"><?php echo esc_html__( "Please add one of the following snippets to your .htaccess (if you're using Apache)", $plugin_text_domain ) ?></span>
						<br>
						<textarea cols="130" rows="18"><?php echo $htaccess_content; ?></textarea>
						<br>
						<span class="description"><?php echo esc_html__( "Or nginx-config (if you're using Nginx)", $plugin_text_domain ) ?></span>
						<br>
						<textarea cols="130" rows="5"><?php echo $nginx_content; ?></textarea><?php
					}
				}?>
			</div><?php
		}
	?>
	<form method="post">
		<input type="hidden" name="page" value="ll-cookie-wall-settings" />
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="logo"><?php echo esc_html__( "Logo - optional", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input type="text" name="logo" value="<?php echo esc_attr($logo); ?>" id="logo" class="regular-text">
						<input type="button" name="upload-btn" id="upload-btn2" class="button-secondary" value="<?php esc_attr_e('Upload Image'); ?>">
						<br>
						<span class="description" ><?php echo esc_html__( "If provided, this image will appear above the title.", $plugin_text_domain ) ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="title"><?php echo esc_html__( "Title", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input class="regular-text" id="title" type="text" name="llcw_title" value="<?php echo esc_attr($title); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php echo esc_html__( "Cookies description", $plugin_text_domain ) ?></label>
					</th>
					<td>

						<?php wp_editor( $description, 'llcw_description', $tiny_mce_settings ); ?>
						<br>
						<span class="description" ><?php echo esc_html__( "By European law, you must inform your visitors about all the cookies you have implemented in your website.", $plugin_text_domain ) ?></span>
						<span class="description" ><?php echo esc_html__( "Extra info can be inserted below a [read-more] tag in the content.", $plugin_text_domain ) ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="button_text"><?php echo esc_html__( "Agree button text", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input class="regular-text" id="button_text" type="text" name="llcw_btn_text" value="<?php echo esc_attr($button_text); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="readmore_text"><?php echo esc_html__( "Read more text", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input class="regular-text" id="readmore_text" type="text" name="llcw_readmore_text" value="<?php echo esc_attr($readmore_text); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="analytics"><?php echo esc_html__( "Google Analytics tracking code - optional", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input class="regular-text" id="analytics" type="text" placeholder="**-**********" name="llcw_tracking_code" value="<?php echo esc_attr($tracking_code); ?>" />
						<br>
						<span class="description" ><?php echo esc_html__( "This will include the Google Analytics tracking code to your cookie-wall (this is allowed if anonimised, which this plugin will do automatically as well).", $plugin_text_domain ) ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="image_url"><?php echo esc_html__( "Background image", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input type="text" name="image_url" value="<?php echo esc_attr($image_url); ?>" id="image_url" class="regular-text">
						<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="<?php esc_attr_e('Upload Image'); ?>">
						<br>
						<span class="description" ><?php echo esc_html__( "Add a background image for your Cookie Wall page, this plugin will make the image blurry. ", $plugin_text_domain ) ?></span>
						<span class="description" ><?php echo esc_html__( "For a better looking page, just capture a screenshot of your homepage with a resolution of about 1000px X 1200px.", $plugin_text_domain ) ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="blurry"><?php echo esc_html__( "Make background image blurry", $plugin_text_domain ) ?></label>
					</th>
					<td>
						<input id="blurry" type="checkbox" <?php if( $blurry_background == '1' ) { echo "checked"; } ?> name="llcw_blurry_background" value="1" />
						<span class="description" ><?php echo esc_html__( "Enable if you want a blurry background (only on newer browsers with CSS3)", $plugin_text_domain ) ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input class="button button-primary" type="submit" name="llcw_submit" value="<?php esc_attr_e('Save'); ?>" />
					</th>
				</tr>
			</tbody>
		</table>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#upload-btn').click(function(e) {
					e.preventDefault();
					var image = wp.media({
						title: 'Upload Image',
						multiple: false
					}).open()
						.on('select', function(e){
							var uploaded_image = image.state().get('selection').first();
							console.log(uploaded_image);
							var image_url = uploaded_image.toJSON().url;
							$('#image_url').val(image_url);
						});
				});
			});

			jQuery(document).ready(function($){
				$('#upload-btn2').click(function(e) {
					e.preventDefault();
					var image = wp.media({
						title: 'Upload Image',
						multiple: false
					}).open()
						.on('select', function(e){
							var uploaded_image = image.state().get('selection').first();
							console.log(uploaded_image);
							var image_url = uploaded_image.toJSON().url;
							$('#logo').val(image_url);
						});
				});
			});
		</script>
	</form>
</div>
