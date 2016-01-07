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
		<style>
			body.ll_cookie_wall {
				font-family: arial, sans-serif;
				font-size: 15px;
				color: #555;
			}
			body.ll_cookie_wall main {
				display:block;
				overflow-y: hidden;
				background: white;
				border: 1px solid #f2f2f2;
				max-width: 600px;
				position: relative;
				margin: 50px auto 0;

				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;

				-webkit-box-shadow: 0 0 27px -2px rgba(0,0,0,0.5);
				-moz-box-shadow: 0 0 27px -2px rgba(0,0,0,0.5);
				box-shadow: 0 0 27px -2px rgba(0,0,0,0.5);
			}
			body.ll_cookie_wall main section {
				padding: 20px;
			}
			body.ll_cookie_wall main section #llcw_read_more {
				display: none;
			}
			body.ll_cookie_wall main section #llcw_read_more p {
				margin-top: 0;
			}
			body.ll_cookie_wall main section #llcw_read_more p:first-child {
				display: none;
			}

			body.ll_cookie_wall main section #expand_description {
				color: #005fb3;
				text-decoration: underline;
				cursor: pointer;
			}
			body.ll_cookie_wall main section #logo {
				max-width: 300px;
				max-height: 150px;
			}
			body.ll_cookie_wall main section h1 {
				font-weight: normal;
				margin-bottom: 0;
				padding-bottom: 0;
			}
			body.ll_cookie_wall main section a {
				margin: 20px 0;
				display:block;
				width: 100%;
			}
			body.ll_cookie_wall main section .btn-accept {
				background: #7DCD3E;
				border: none;
				padding: 10px;
				color: white;
				font-size: 16px;
				cursor: pointer;
				-webkit-border-radius: 6px;
				-moz-border-radius: 6px;
				border-radius: 6px;
			}
			body.ll_cookie_wall main section .btn-accept:hover {
				background: #5bab1c;
			}


			@media screen and (max-width: 500px) {
				body.ll_cookie_wall {
					background: none;
					background-color: white;
					padding: 0;
					margin: 0;
					outline: 0;
					-webkit-border-radius: 0;
					-moz-border-radius: 0;
					border-radius: 0;
				}
				body.ll_cookie_wall main {
					width: 100%;
					height: 100%;
					margin: 0;
				}
			}

			body .background {
				<?php
					if( isset( $cookie_wall_options['image_url'] ) ) {
						echo "background: url('" . $cookie_wall_options['image_url'] . "') no-repeat top center;";
					}
				?>
				height: 100%;
				width: 100%;
				position: fixed;
				top: 0;
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
					<img id="logo" src="<?php echo esc_url( $logo ); ?>" alt="logo"/>
				<?php } ?>
				<h1><?php echo esc_html( $title ); ?></h1>
				<p><?php echo apply_filters( "the_content", $description, $readmore_text, $button_text ); ?></p>
			</section>
		</main>
		<footer>
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script> 
			<script type="text/javascript">
				/*!
				 * jQuery Cookie Plugin v1.4.1
				 * https://github.com/carhartl/jquery-cookie
				 *
				 * Copyright 2006, 2014 Klaus Hartl
				 * Released under the MIT license
				 */
				(function (factory) {
					if (typeof define === 'function' && define.amd) {
						// AMD (Register as an anonymous module)
						define(['jquery'], factory);
					} else if (typeof exports === 'object') {
						// Node/CommonJS
						module.exports = factory(require('jquery'));
					} else {
						// Browser globals
						factory(jQuery);
					}
				}(function ($) {

					var pluses = /\+/g;

					function encode(s) {
						return config.raw ? s : encodeURIComponent(s);
					}

					function decode(s) {
						return config.raw ? s : decodeURIComponent(s);
					}

					function stringifyCookieValue(value) {
						return encode(config.json ? JSON.stringify(value) : String(value));
					}

					function parseCookieValue(s) {
						if (s.indexOf('"') === 0) {
							// This is a quoted cookie as according to RFC2068, unescape...
							s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
						}

						try {
							// Replace server-side written pluses with spaces.
							// If we can't decode the cookie, ignore it, it's unusable.
							// If we can't parse the cookie, ignore it, it's unusable.
							s = decodeURIComponent(s.replace(pluses, ' '));
							return config.json ? JSON.parse(s) : s;
						} catch(e) {}
					}

					function read(s, converter) {
						var value = config.raw ? s : parseCookieValue(s);
						return $.isFunction(converter) ? converter(value) : value;
					}

					var config = $.cookie = function (key, value, options) {

						// Write

						if (arguments.length > 1 && !$.isFunction(value)) {
							options = $.extend({}, config.defaults, options);

							if (typeof options.expires === 'number') {
								var days = options.expires, t = options.expires = new Date();
								t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
							}

							return (document.cookie = [
								encode(key), '=', stringifyCookieValue(value),
								options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
								options.path    ? '; path=' + options.path : '',
								options.domain  ? '; domain=' + options.domain : '',
								options.secure  ? '; secure' : ''
							].join(''));
						}

						// Read

						var result = key ? undefined : {},
						// To prevent the for loop in the first place assign an empty array
						// in case there are no cookies at all. Also prevents odd result when
						// calling $.cookie().
							cookies = document.cookie ? document.cookie.split('; ') : [],
							i = 0,
							l = cookies.length;

						for (; i < l; i++) {
							var parts = cookies[i].split('='),
								name = decode(parts.shift()),
								cookie = parts.join('=');

							if (key === name) {
								// If second argument (value) is a function it's a converter...
								result = read(cookie, value);
								break;
							}

							// Prevent storing a cookie that we couldn't decode.
							if (!key && (cookie = read(cookie)) !== undefined) {
								result[name] = cookie;
							}
						}

						return result;
					};

					config.defaults = {};

					$.removeCookie = function (key, options) {
						// Must not alter options, thus extending a fresh object...
						$.cookie(key, '', $.extend({}, options, { expires: -1 }));
						return !$.cookie(key);
					};

				}));

			</script>
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
