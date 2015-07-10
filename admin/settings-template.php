<?php

$cookie_wall_options    = get_option( 'llcw_settings' );
$description            = '';
$expiration             = '';
$title                  = '';
$button_text            = '';
$page_url               = '';
$image_url              = '';
$tracking_code          = '';

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
if( isset( $cookie_wall_options['tracking_code'] ) ) {
	$tracking_code = $cookie_wall_options['tracking_code'];
}

wp_enqueue_script('jquery');
wp_enqueue_media();

?>

<div class="wrap"><div id="icon-tools" class="icon32"></div>
	<h2>Level Level - Cookie Wall</h2>
	<p>This cookie wall plugin requires some additional server configuration. It works with both Nginx and Apache.</p>
	<form method="post">
		<input type="hidden" name="page" value="ll-cookie-wall-settings" />
		<p>
			<label>Title</label><br>
			<input type="text" name="llcw_title" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label>Cookies description</label><br>
			<textarea cols="120" rows="20" name="llcw_description"><?php echo $description; ?></textarea>
		</p>
		<p>
			<label>Agree button text</label><br>
			<input type="text" name="llcw_btn_text" value="<?php echo $button_text; ?>" />
		</p>
		<p>
			<label>More info page URL</label><br>
			<input type="text" name="llcw_url" value="<?php echo $page_url; ?>" />
		</p>
		<p>
			<label>Google Analytics - Tracking code</label><br>
			<input type="text" name="llcw_tracking_code" value="<?php echo $tracking_code; ?>" />
		</p>
		<div>
			<p>
				<label for="image_url">Background image</label><br>
				<input type="text" name="image_url" value="<?php echo $image_url; ?>" id="image_url" class="regular-text">
				<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
			</p>
		</div>
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
		</script>
		<p>
			<input type="submit" name="llcw_submit" value="Save" />
		</p>
	</form>
</div>
