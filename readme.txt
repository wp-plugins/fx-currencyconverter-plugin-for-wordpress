=== FX-CurrencyConverter Plugin for Wordpress ===
Contributors: websmokers
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5675100
Tags: Currency, converter, plugin, foreign, exchange, rates
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: trunk

Simple lightweight currency converter plugin for Wordpress.

== Description ==

Simple lightweight currency converter plugin for Wordpress that allows your visitors to search foreign exchange rates between almost any world currencies and displays live interbank rates via a popup. Simple shortcode allows the converter to be added to posts and pages, and a sidebar widget is included. For more advanced users the converter can be styled using the plugins own css in the settings menu.

Generate an income stream - <a href="http://fx-foreignexchange.com/become_an_affiliate.php">become an affiliate</a> and earn money from your visitors currency calculations.

= Usage =

Put following shortcode in your post or page. This shortcode has no attribute.
<pre>[zdgcc]</pre>

Add "FX-CurrencyConverter" Widget to your sidebar from widget panel.

= Widget CSS =
Widget CSS is in 2 parts. One for sidebar widget and one for pages/post.

Post/Page Widget CSS:

    * zdgccwrapper: <div> class. This is the main wrapper of widget, which is around the whole widget
    * zdgccwrapper h3: Widget Header is placed in a <h3> tag.
    * zdgccbox: <div> class to hold form fields below widget header
    * amountlabel: <div> class for “Amount” text
    * amountinput: <input> class for amount textfield
    * getrate: <div> class. “Get Rate” button <nput> is inside this <div>

Sidebar Widget CSS:

    * zdgbox: <div> class. The form is inside this <div>
    * amountlabel: <div> class for “Amount” text
    * amountinput: <input> class for amount textfield
    * getrate: <div> class. “Get Rate” button <nput> is inside this <div>


== Installation ==

1. Upload the full directory into your 'wp-content/plugins' directory
2. Activate the plugin at the plugin administration page
3. Use [zdgcc] shortcode in your post or page.
4. Add 'FX-CurrencyConverter' widget to your sidebar.

== Frequently Asked Questions ==

= Minimum PHP Version =

PHP 5.1.x

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg

== Support ==

Email at support@proloy.me