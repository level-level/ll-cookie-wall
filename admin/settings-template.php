<?php

$plugin_text_domain     = 'll_cookie_wall';

$plugin_admin_path      = plugin_dir_path( __FILE__ );
$nginx_config_path      = $plugin_admin_path . 'config_files/nginx.conf';

$cookie_wall_options    = get_option( 'llcw_settings' );

$htaccess_content       = '';
$nginx_content          = '';
$description            = '';
$expiration             = '';
$title                  = '';
$button_text            = '';
$page_url               = '';
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
if( isset( $cookie_wall_options['page_url'] ) ) {
	$page_url = $cookie_wall_options['page_url'];
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
	<h2>Level Level - Cookie Wall</h2>
	<?php
		if( $server_software == 'apache' ) {
			if( !empty( $htaccess_content ) ) {
				?><h4><?php echo __( 'You are using an Apache server', $plugin_text_domain ) ?></h4>
				<p class="explanation"><?php echo __( "We couldn't update your .htaccess file, but the code is necessary for this plugin to work properly.
					Please add the following snippet to your .htaccess file manually:", $plugin_text_domain ) ?></p>
				<textarea cols="130" rows="18" ><?php echo $htaccess_content; ?></textarea><?php
			}
		} else if( $server_software == 'nginx' ) {
			if( !empty( $nginx_content ) ) {
				?><h4><?php echo __( 'You are using an Nginx server', $plugin_text_domain ) ?></h4>
				<p class="explanation"><?php echo __( "The following code is necessary for this plugin to work properly.
					Please add the following snippet to your Nginx config manually:", $plugin_text_domain ) ?></p>
				<textarea cols="130" rows="5" ><?php echo $nginx_content; ?></textarea><?php
			}
		} else {
			if( !empty( $htaccess_content ) || !empty( $nginx_content ) ) {
				?><h4><?php echo __( "We couldn't recognize the type of server you are using.", $plugin_text_domain ) ?></h4>
				<p class="explanation"><?php echo __( "Please add one of the following snippets to your .htaccess (if you're using Apache)", $plugin_text_domain ) ?></p>
				<textarea cols="130" rows="18"><?php echo $htaccess_content; ?></textarea>
				<p class="explanation"><?php echo __( "Or nginx-config (if you're using Nginx)", $plugin_text_domain ) ?></p>
				<textarea cols="130" rows="5"><?php echo $nginx_content; ?></textarea><?php
			}
		}
	?>
	<form method="post">
		<input type="hidden" name="page" value="ll-cookie-wall-settings" />
		<p>
			<label for="logo"><?php echo __( "Logo - optional", $plugin_text_domain ) ?></label><br>
			<p class="explanation" ><?php echo __( "If provided, this image will appear above the title.", $plugin_text_domain ) ?></p>
			<input type="text" name="logo" value="<?php echo $logo; ?>" id="logo" class="regular-text">
			<input type="button" name="upload-btn" id="upload-btn2" class="button-secondary" value="Upload Image">
		</p>
		<p>
			<label for="title"><?php echo __( "Title", $plugin_text_domain ) ?></label><br>
			<input id="title" type="text" name="llcw_title" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label><?php echo __( "Cookies description", $plugin_text_domain ) ?></label><br>
			<p class="explanation" ><?php echo __( "By European law, you must inform your visitors about all the cookies you have implemented in your website.", $plugin_text_domain ) ?></p>
			<p class="explanation" ><?php echo __( "Extra info can be inserted below a [read-more] tag in the content.", $plugin_text_domain ) ?></p>
			<?php wp_editor( $description, 'llcw_description', $tiny_mce_settings ); ?>
		</p>
		<p>
			<label for="button_text"><?php echo __( "Agree button text", $plugin_text_domain ) ?></label><br>
			<input id="button_text" type="text" name="llcw_btn_text" value="<?php echo $button_text; ?>" />
		</p>
<!--		<p>-->
<!--			<label for="page_url">--><?php //echo __( "More info page URL - optional", $plugin_text_domain ) ?><!--</label><br>-->
<!--			<p class="explanation" >--><?php //echo __( "Add a URI like 'cookie-info', or a full URL like 'https://yourwebsite.com/cookie-info.", $plugin_text_domain ) ?><!--</p>-->
<!--			<p class="explanation" >--><?php //echo __( "Leave empty if you don't want it to appear on your cookie wall.", $plugin_text_domain ) ?><!--</p>-->
<!--			<input id="page_url" type="text" name="llcw_url" value="--><?php //echo $page_url; ?><!--" />-->
<!--		</p>-->
		<p>
			<label for="analytics"><?php echo __( "Google Analytics tracking code - optional", $plugin_text_domain ) ?></label><br>
			<p class="explanation" ><?php echo __( "This will include the Google Analytics tracking code to your cookie-wall (this is allowed if anonimised, which this plugin will do automatically as well).", $plugin_text_domain ) ?></p>
			<input id="analytics" type="text" placeholder="**-**********" name="llcw_tracking_code" value="<?php echo $tracking_code; ?>" />
		</p>
		<p>
			<label for="image_url"><?php echo __( "Background image", $plugin_text_domain ) ?></label><br>
			<p class="explanation" ><?php echo __( "Add a background image for your Cookie Wall page, this plugin will make the image blurry. ", $plugin_text_domain ) ?></p>
			<p class="explanation" ><?php echo __( "For a better looking page, just capture a screenshot of your homepage with a resolution of about 1000px X 1200px.", $plugin_text_domain ) ?></p>
			<input type="text" name="image_url" value="<?php echo $image_url; ?>" id="image_url" class="regular-text">
			<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
		</p>
		<p>
			<label for="blurry"><?php echo __( "Make background image blurry", $plugin_text_domain ) ?></label><br>
			<p class="explanation" ><?php echo __( "Enable if you want a blurry background (only on newer browsers with CSS3)", $plugin_text_domain ) ?></p>
			<input id="blurry" type="checkbox" <?php if( $blurry_background == '1' ) { echo "checked"; } ?> name="llcw_blurry_background" value="1" />
		</p>
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
		<p>
			<input class="button button-primary" type="submit" name="llcw_submit" value="Save" />
		</p>
	</form>
</div>
