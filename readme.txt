=== Cookie Wall for WordPress ===
Contributors: level-level
Tags: cookie, cookies, cookie wall, wall, law, eu cookie, europe, european, privacy
Requires at least: 3.3.0
Tested up to: 4.3.1
Stable tag: 4.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Cookie Wall for WordPress is a plugin to comply with the EU law. Instead of offering a way to continue browsing without cookies, which possibly means loss of income for publishers, this cookie wall only accepts a confirmation.

== Description ==
The Cookie Wall for WordPress is a plugin to comply with the EU law. Instead of offering a way to continue browsing without cookies, which possibly means loss of income for publishers, this cookie wall only accepts a confirmation.

= Social sharing =
The Cookie Wall for WordPress is bot friendly. The cookie notice is only shown to humans, crawlers, social media and other bots are allowed.

= Google analytics =
Traffic accepts cookies through the Cookie Wall for WordPress is measured properly in Google Analytics so the original referrer is preserved.

= European Law =
The Cookie Wall for WordPress complies with the European Commission’s guidelines on privacy and data protection.

= 100% block =
No cookies are served before passing the Cookie Wall - guaranteed!

= Custom cookie notice =
By European law, you must inform your visitors about all the cookies that may be placed through your website.

= Customize =
The look and feel of the Cookie Wall can be fully adjusted to the look and feel of your website.

== Installation ==
1. Upload `ll-cookie-wall` to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the *Plugins* menu in WordPress
3. On the options page you can configure your Cookie Wall. *Settings > Cookie wall for WP*
4. Add the Apache / Nginx config rules to you site's server config.
5. Refresh your permalinks by navigating to *Settings > Permalinks* (the plugin creates a new page)

== Screenshots ==
1. Plugin overview

== Frequently Asked Questions ==
! *Remember that this isn't your basic install and run plugin.*

Have a question? Make a thread in the support forum and we will get back to you.

**The page '/cookie-wall' returns a 404?**
You didn't refresh your permalinks.

**The page '/cookie_wall' fails in Nginx?**
Because it should be '/cookie-wall' since v0.3.0

**I'm getting an Javascript error '$ is not defined'**
When using Nginx you need to have

'if ($request_uri ~ ^/wp-content ) {
     set $ll_cookie_exist '0';
}'

**My server config returns an error**  
Note when pasting the config rules via your editor, it doesn\'t add weird line-breaks.


== Changelog ==

= 0.3.1 =
* Check if rewrite config files exists
* Move writing of config files outside the save setting so the config files get save properly

= 0.3.0 =
Don't use this version. It doens't write the config files correct

* Correctly redirects url with multiple query args '?foo=bar&you&me'
* Loading all JS and CSS from the server instead of CDN
* Fixed that both server configs use '/cookie-wall'. You may need to update your server config.
* Use correct text-domain

= 0.0.1 =
* Initial release.