=== FX-CurrencyConverter Plugin for Wordpress ===
Contributors: websmokers
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5675100
Tags: Currency, converter, plugin, foreign, exchange, rates
Requires at least: 2.5
Tested up to: 2.8
Stable tag: trunk

Simple lightweight currency converter plugin for Wordpress.

== Description ==

Simple lightweight currency converter plugin for Wordpress that allows your visitors to search foreign exchange rates between almost any world currencies and displays live interbank rates via a popup. Simple shortcode allows the converter to be added to posts and pages, and a sidebar widget is included. For more advanced users the converter can be styled using the plugins own css in the settings menu.

Generate an income stream - <a href="http://fx-foreignexchange.com/become_an_affiliate.php" target="_blank">become an affiliate</a> and earn money from your visitors currency calculations.

= Usage =

Put following shortcode in your post or page. This shortcode has no attribute.
<pre>[zdgcc]</pre>

Add "FX-CurrencyConverter" Widget to your sidebar from widget panel.

= Widget CSS =
Widget CSS is in 2 parts. One for sidebar widget and one for pages/post.

Post/Page Widget CSS:
<ul>
    <li>zdgccwrapper: &lt;div&gt; class. This is the main wrapper of widget, which is around the whole widget</li>
    <li>zdgccwrapper h3: Widget Header is placed in a &lt;h3&gt; tag.</li>
    <li>zdgccbox: &lt;div&gt; class to hold form fields below widget header</li>
    <li>amountlabel: &lt;div&gt; class for "Amount" text</li>
    <li>amountinput: &lt;input&gt; class for amount textfield</li>
    <li>getrate: &lt;div&gt; class. "Get Rate" button &lt;input&gt; is inside this &lt;div&gt;</li>
</ul>


Sidebar Widget CSS:
<ul>
    <li>zdgbox: &lt;div&gt; class. The form is inside this &lt;div&gt;</li>
    <li>amountlabel: &lt;div&gt; class for "Amount" text</li>
    <li>amountinput: &lt;input&gt; class for amount textfield</li>
    <li>getrate: &lt;div&gt; class. "Get Rate" button &lt;input&gt; is inside this &lt;div&gt;</li>
</ul>


== Installation ==

1. Upload the full directory into your 'wp-content/plugins' directory
2. Activate the plugin at the plugin administration page
3. Use [zdgcc] shortcode in your post or page.
4. Add 'FX-CurrencyConverter' widget to your sidebar.

== Frequently Asked Questions ==

= Minimum PHP Version =

PHP 5.1.x

== Screenshots ==

1. Widget Preview
2. Plugin Admin Page
3. Widget Panel

== Support ==

Email at support@proloy.me