<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cookie_wall_options = get_option( 'llcw_settings' );

if( !empty( $cookie_wall_options ) && isset( $cookie_wall_options['description'] ) ) {
	$description        = $cookie_wall_options['description'];
	$title              = $cookie_wall_options['title'];
	$button_text        = $cookie_wall_options['button_text'];
	$readmore_text      = $cookie_wall_options['readmore_text'];
	$tracking_code      = $cookie_wall_options['tracking_code'];
	$logo               = $cookie_wall_options['logo'];
	$blurry_background  = $cookie_wall_options['blurry_background'];
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<?php if(!empty($title)) : ?>
		<title> <?php echo esc_html($title); ?> </title>
		<?php endif; ?>

		<style>
			/* Mobile first */
			body.ll_cookie_wall {
				font-family: Arial, Helvetica, sans-serif;
				color: #3A3A3A;
			}

			body.ll_cookie_wall main section {
				position: relative;
				overflow-y: hidden;

				margin: 0 auto;
				padding: 25px;
				background-color: #fff;
				display: block;
				width: 100%;

				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;

				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
			}
			body.ll_cookie_wall main section img#logo {
				max-width: 200px;
			}
			body.ll_cookie_wall main section h1 {
				margin-bottom: 15px;
			}

			body.ll_cookie_wall main section h2 {
				font-size: 18px;
				margin-bottom: 10px;
			}
			body.ll_cookie_wall main section h3 {
				font-size: 16px;
				margin-bottom: 5px;
			}

			body.ll_cookie_wall main section p {
				font-size: 15px;
				line-height: 24px;
				margin-top: 0;
				margin-bottom: 15px;
			}
			body.ll_cookie_wall main section p:first-child {
				margin-top: 30px;
			}
			body.ll_cookie_wall main section form {
				margin: 35px 0 20px 0;
			}
			body.ll_cookie_wall main section form input {
				-webkit-appearance: none;
				-moz-appearance: none;
				display: block;
				width: 100%;
				max-width: 250px;
				font-weight:300;
				font-size: 16px;
				color: #fff;
				background: green;
				border: none;
				padding: 16px 20px;
				cursor: pointer;
				margin: 0 auto;

				-webkit-border-radius: 3px;
				-moz-border-radius: 3px;
				border-radius: 3px;
			}
			body.ll_cookie_wall main section form input:hover {
				background-color: darkgreen;
				-webkit-transition: background-color .3s;
				-moz-transition: background-color .3s;
				-ms-transition: background-color .3s;
				-o-transition: background-color .3s;
				transition: background-color .3s;
			}

			body.ll_cookie_wall main section a#expand_description {
				color: #878787;
				text-align: center;
				text-decoration: underline;
				display: block;
				cursor: pointer;
			}
			body.ll_cookie_wall main section a#expand_description:hover {
				color: #696969;
				-webkit-transition: color .3s;
				-moz-transition: color .3s;
				-ms-transition: color .3s;
				-o-transition: color .3s;
				transition: color .3s;
			}

			body.ll_cookie_wall main section #llcw_read_more {
				display: none;
			}

			body.ll_cookie_wall .background {
			<?php
				if( isset( $cookie_wall_options['image_url'] ) ) {
					echo "background: url('" . $cookie_wall_options['image_url'] . "') no-repeat top center;";
				}
			?>
				height: 100%;
				width: 100%;
				position: fixed;
				top: 0;
			<?php if( $blurry_background == '1' ) : ?>
				-webkit-filter: blur(5px);
				-moz-filter: blur(5px);
				-o-filter: blur(5px);
				-ms-filter: blur(5px);
				filter: blur(5px);
			<?php endif; ?>
			}

			body.ll_cookie_wall .overlay {
				background-color: rgba(0,0,0,0.65);
				position: fixed;
				top: 0;
				left: 0;
				height: 100%;
				width: 100%;;
			}
			body.ll_cookie_wall footer {
				display: none;
			}

			/* Tablet */
			@media (min-width: 480px) {
				body.ll_cookie_wall main section {
					max-width: 480px;
					margin: 5% auto;
					padding: 40px;
				}
			}
			/* Desktop */
			@media (min-width: 1110px) {
				body.ll_cookie_wall main section {
					max-width: 620px;
				}
			}
		</style>
	</head>
	<body class="ll_cookie_wall">
		<section class="background"></section>
		<section class="overlay"></section>
		<main>
			<section>
				<?php if( !empty( $logo ) ) { ?>
					<img id="logo" src="<?php echo esc_url( $logo ); ?>" alt="logo"/>
				<?php } ?>
				<h1><?php echo esc_html( $title ); ?></h1>
				<?php if( empty($readmore_text)) $readmore_text = __('Read more'); ?>
				<p><?php echo apply_filters( "ll_the_content", $description, $readmore_text, $button_text ); ?></p>
			</section>
		</main>
		<footer>
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script> 
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
			<script type="text/javascript">
				function parseURLParams(url) {
					var queryStart = url.indexOf("?") + 1,
						queryEnd   = url.indexOf("#") + 1 || url.length + 1,
						query = url.slice(queryStart, queryEnd - 1),
						pairs = query.replace(/\+/g, " ").split("&"),
						parms = {}, i, n, v, nv;

					if (query === url || query === "") {
						return;
					}

					for (i = 0; i < pairs.length; i++) {
						nv = pairs[i].split("=");
						n = decodeURIComponent(nv[0]);
						v = decodeURIComponent(nv[1]);

						if (!parms.hasOwnProperty(n)) {
							parms[n] = [];
						}

						parms[n].push(nv.length === 2 ? v : null);
					}
					return parms;
				}
				$(document).ready(function() {

					var parts = location.hostname.split('.');
					var domain = parts.slice(-2).join('.');
					domain = '.'+domain;

					var getvars      = parseURLParams( window.location.href );
					if( undefined == getvars || undefined == getvars.url_redirect ) {
						var redirect_url = '/';
					} else {
						var redirect_url = getvars.url_redirect[0];
					}

					$("#expand_description").click(function(e) {
						e.preventDefault();
						$("#llcw_read_more").stop(1,1).slideToggle(250);
					});

					$("#ll_cookie_form").submit(function(e){
						e.preventDefault();

						$.cookie( 'll_cookie_wall', 'll_cookie_wall', { expires: 365, path: '/', domain: domain } );

						window.location.href = redirect_url;
					});
					$('#agree_with_cookie_terms').click(function(e) {
						e.preventDefault();
						$.cookie( 'll_cookie_wall', 'll_cookie_wall', { expires: 365, path: '/', domain: domain } );

						window.location.href = redirect_url;
					});
				});
			</script>
			<?php if( !empty( $tracking_code ) ) { ?>
				<script>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					ga('create', '<?php echo $tracking_code ?>', 'auto');
					ga('set', 'anonymizeIp', true);
					ga('send', 'pageview');

				</script>
			<?php } ?>
		</footer>
	</body>
</html>
<?php }
