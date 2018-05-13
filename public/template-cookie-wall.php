<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cookie_wall_options = get_option( 'llcw_settings' );

if( !empty( $cookie_wall_options ) && isset( $cookie_wall_options['description'] ) ) {
	$description        = $cookie_wall_options['description'];
	$title              = $cookie_wall_options['title'];
	$button_text        = $cookie_wall_options['button_text'];
	$readmore_text      = ( empty( $cookie_wall_options['readmore_text'] ) ) ? __('Read more') : $cookie_wall_options['readmore_text'];
	$tracking_code      = $cookie_wall_options['tracking_code'];
	$logo_url           = $cookie_wall_options['logo'];
	$blurry_background  = $cookie_wall_options['blurry_background'];
	$background_image_url = $cookie_wall_options['image_url'];
	$custom_css 				= $cookie_wall_options['custom_css'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<?php if( !empty( $title ) ) { ?>
		<title><?php echo esc_html( $title ); ?></title>
		<?php } ?>

		<?php do_action('llcw_head'); ?>

		<style>
			body.ll_cookie_wall .background {

				<?php
				if( !empty( $background_image_url ) ) { ?>
					background: url('<?php echo esc_url( $background_image_url ) ; ?>') no-repeat top center;
				<?php
				} //end if

				if( intval( $blurry_background ) ) { ?>
					-webkit-filter: blur(5px);
					-moz-filter: blur(5px);
					-o-filter: blur(5px);
					-ms-filter: blur(5px);
					filter: blur(5px);
				<?php } //end if ?>
			}

			<?php
			if( !empty( $custom_css ) ) {
				echo $custom_css;
			}
			?>
		</style>

	</head>
	<body class="ll_cookie_wall">
		<section class="background"></section>
		<section class="overlay"></section>
		<main>
			<section>
				<?php if( !empty( $logo_url ) ) { ?>
					<img id="logo" src="<?php echo esc_url( $logo_url ); ?>" alt="logo"/>
				<?php } ?>
				<h1><?php echo esc_html( $title ); ?></h1>
				<p><?php echo apply_filters( "ll_the_content", $description, $readmore_text, $button_text ); ?></p>
			</section>
		</main>
		<footer>
			<?php do_action('llcw_footer') ; ?>
			<?php if( !empty( $tracking_code ) ) { ?>
				<script>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					ga('create', '<?php echo esc_js( $tracking_code ) ?>', 'auto');
					ga('set', 'anonymizeIp', true);
					ga('set', 'displayFeaturesTask', null);
					ga('send', 'pageview');

				</script>
			<?php } ?>
		</footer>
	</body>
</html>
<?php }
