<?php
/**
 * Created by PhpStorm.
 * User: Jos Achterberg
 * Date: 19-06-15
 * Time: 14:05
 */

$cookie_wall_options = get_option( 'llcw_settings' );

if( !empty( $cookie_wall_options ) && isset( $cookie_wall_options['description'] ) ) {
	$description    = $cookie_wall_options['description'];
	$title          = $cookie_wall_options['title'];
	$button_text    = $cookie_wall_options['button_text'];?>

	<head>
		<link href="<?php echo plugin_dir_url( __FILE__ ); ?>assets/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="ll_cookie_wall">
		<main>
			<section>
				<h1><?php echo apply_filters( 'the_title', $title ); ?></h1>
				<p><?php echo apply_filters( "the_content", $description ); ?></p>
				<form>
					<input type="hidden" name="llcw_cookie_agreement" value="accept" />
					<input type="submit" value="<?php echo $button_text; ?>" />
				</form>
			</section>
		</main>
	</body>
<?php }
