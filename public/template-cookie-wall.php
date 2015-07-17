<?php

$cookie_wall_options = get_option( 'llcw_settings' );

if( !empty( $cookie_wall_options ) && isset( $cookie_wall_options['description'] ) ) {
	$description        = $cookie_wall_options['description'];
	$title              = $cookie_wall_options['title'];
	$button_text        = $cookie_wall_options['button_text'];
	$page_url           = $cookie_wall_options['page_url'];
	$tracking_code      = $cookie_wall_options['tracking_code'];
	$logo               = $cookie_wall_options['logo'];
	$blurry_background  = $cookie_wall_options['blurry_background'];
	?>

	<head>
		<link href="<?php echo plugin_dir_url( __FILE__ ); ?>assets/style.css" rel="stylesheet" type="text/css" />
		<style>
			body .background {
				<?php
					if( isset( $cookie_wall_options['image_url'] ) ) {
						echo "background: url('" . $cookie_wall_options['image_url'] . "') no-repeat top center;";
					}
				?>
				height: 100%;
				width: 100%;
				position: fixed;
				top: 0px;
				<?php
					if( $blurry_background == '1' ) { ?>
						-webkit-filter: blur(5px);
						-moz-filter: blur(5px);
						-o-filter: blur(5px);
						-ms-filter: blur(5px);
						filter: blur(5px); <?php
					}
				?>
			}
		</style>
	</head>
	<body class="ll_cookie_wall">
		<section class="background"></section>
		<main>
			<section>
				<?php if( !empty( $logo ) ) { ?>
					<img id="logo" src="<?php echo $logo; ?>" alt="logo"/>
				<?php } ?>
				<h1><?php echo apply_filters( 'the_title', $title ); ?></h1>
				<p><?php echo apply_filters( "the_content", $description ); ?></p>
				<?php if( !empty( $page_url ) ) { ?>
					<a href="<?php echo $page_url; ?>">Lees meer</a>
				<?php } ?>
				<form method="POST" id="ll_cookie_form">
					<input class="btn-accept" id="agree_with_cookie_terms" type="submit" name="ll_agree_cookies" value="<?php echo $button_text; ?>" />
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
					var getvars      = parseURLParams( window.location.href );
					if( undefined == getvars || undefined == getvars.url_redirect ) {
						var redirect_url = '/';
					} else {
						var redirect_url = getvars.url_redirect[0];
					}

					$("#expand_description").click(function(e) {
						e.preventDefault();
						$("#llcw_read_more").stop(1,1).slideToggle(250);
					})

					$("#ll_cookie_form").submit(function(e){
						e.preventDefault();
						$.cookie( 'LLCW', 'll_cookie_wall', { expires: 365, path: '/' } );
						window.location.href = redirect_url;
					});
					$('#agree_with_cookie_terms').click(function(e) {
						e.preventDefault();
						$.cookie( 'LLCW', 'll_cookie_wall', { expires: 365, path: '/' } );
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
<?php }
