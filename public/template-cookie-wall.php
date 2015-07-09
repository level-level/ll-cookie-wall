<?php

$cookie_wall_options = get_option( 'llcw_settings' );

if( !empty( $cookie_wall_options ) && isset( $cookie_wall_options['description'] ) ) {
	$description    = $cookie_wall_options['description'];
	$title          = $cookie_wall_options['title'];
	$button_text    = $cookie_wall_options['button_text'];
	$page_url       = $cookie_wall_options['page_url']; ?>

	<head>
		<link href="<?php echo plugin_dir_url( __FILE__ ); ?>assets/style.css" rel="stylesheet" type="text/css" />
		<style>
			body.ll_cookie_wall {
				<?php
					if( isset( $cookie_wall_options['image_url'] ) ) {
						echo "background: url('" . $cookie_wall_options['image_url'] . "') no-repeat top center;";
					}
				?>
			}
		</style>
	</head>
	<body class="ll_cookie_wall">
		<main>
			<section>
				<h1><?php echo apply_filters( 'the_title', $title ); ?></h1>
				<p><?php echo apply_filters( "the_content", $description ); ?></p>
				<?php if( !empty( $page_url ) ) { ?>
					<a href="<?php echo $page_url; ?>">Lees meer</a>
				<?php } ?>
				<form>
					<input class="btn-accept" id="agree_with_cookie_terms" value="<?php echo $button_text; ?>" />
				</form>
			</section>
		</main>
		<footer>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ); ?>assets/jquery.cookie.js"></script>
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
					var getvars = parseURLParams( window.location.href );

					var redirect_url = getvars.url_redirect[0];

					$('#agree_with_cookie_terms').click(function(e) {
						e.preventDefault();
						$.cookie( 'LLCW', 'll_cookie_wall', { expires: 365, path: '/' } );
						window.location.href = redirect_url;
					});
				});
			</script>
		</footer>
	</body>
<?php }
