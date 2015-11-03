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
1. Upload 'll-cookie-wall' to the '/wp-content/plugins/' directory
2. Activate the plugin through the \'Plugins\' menu in WordPress
3. On the options page you can configure your Cookie Wall.

**Note:** refresh your permalinks by navigating to Setting > Permalinks (the plugin creates a new page)

= .htaccess snippet =
# BEGIN Cookie Rewrite
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTP_HOST} example.com [NC]
RewriteCond %{REQUEST_URI} ^/$
RewriteCond %{HTTP_COOKIE} !^.*ll_cookie_wall.*
RewriteCond %{HTTP_USER_AGENT} Internet\ Explorer|MSIE|Chrome|Safari|Firefox|Windows|Opera|iphone|ipad|android|blackberry
RewriteRule .* /cookie-wall?url_redirect=http%1://%{HTTP_HOST}%{REQUEST_URI} [R=302,L]

RewriteCond %{REQUEST_URI} !^/cookie-wall.*
RewriteCond %{HTTP_COOKIE} !^.*ll_cookie_wall.*
RewriteCond %{REQUEST_URI} !index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{HTTP_USER_AGENT} Internet\ Explorer|MSIE|Chrome|Safari|Firefox|Windows|Opera|iphone|ipad|android|blackberry
RewriteRule .* /cookie-wall?url_redirect=http%1://%{HTTP_HOST}%{REQUEST_URI} [R=302,L]
</IfModule>
# END Cookie Rewrite

= nginx-config =


== Frequently Asked Questions ==
Have a question? Make a thread in the support forum and we will get back to you.

== Changelog ==

= 0.1 =
* Initial release.
