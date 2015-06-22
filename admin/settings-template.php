<?php
/**
 * Created by PhpStorm.
 * User: Jos Achterberg
 * Date: 22-06-15
 * Time: 10:16
 */

$cookie_wall_options    = get_option( 'llcw_settings' );
$description            = '';
$expiration             = '';
$title                  = '';
$button_text            = '';
$page_url               = '';

if( isset( $cookie_wall_options['description'] ) ) {
	$description = $cookie_wall_options['description'];
}
if( isset( $cookie_wall_options['expiration'] ) ) {
	$expiration = $cookie_wall_options['expiration'];
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


?>

<div class="wrap"><div id="icon-tools" class="icon32"></div>
	<h2>Level Level - Cookie Wall</h2>
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
			<label>Cookie expiration</label><br>
			<input type="text" name="llcw_expiration" value="<?php echo $expiration; ?>" />
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
			<input type="submit" name="llcw_submit" value="Opslaan" />
		</p>
	</form>
</div>
