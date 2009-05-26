<?php
/*
Plugin Name: FX-CurrencyConverter Plugin for Wordpress
Version: 1.0
Plugin URI: http://www.proloy.me/projects/wordpress-plugins/fx-currencyconverter-plugin-for-wordpress/
Description: Simple lightweight currency converter plugin for Wordpress that allows your visitors to search foreign exchange rates between almost any world currencies and displays live interbank rates via a popup. Simple shortcode allows the converter to be added to posts and pages, and a sidebar widget is included. For more advanced users the converter can be styled using the plugins own css in the settings menu.
Tags: Currency, converter, plugin, foreign, exchange, rates
Author: Proloy Chakroborty
Author URI: http://www.proloy.me/
*/

 
/*Copyright (c) 2009, Proloy Chakroborty
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of Proloy Chakroborty nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY Proloy Chakroborty ''AS IS'' AND ANY
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL Proloy Chakroborty BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/

////////////////////////////////////////////////////////////////////////////////////////////////////
// Version history:
//	1.0.0 - 25 May 2009: Initial release
// Usage:
//	Widget and shortcode [zdgcc]
// Attributes: None
////////////////////////////////////////////////////////////////////////////////////////////////////

//Check minimum required WordPress Version
global $wp_version;
$exit_msg = 'FX-CurrencyConverter Plugin for Wordpress require WordPress 2.5 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
if (version_compare($wp_version, "2.5", "<")) {
	exit($exit_msg);
}

//Make sure we're running an up-to-date version of PHP
$phpVersion = phpversion();
$verArray = explode('.', $phpVersion);
$error_msg = "'FX-CurrencyConverter Plugin for Wordpress' requires PHP version 5 or newer.<br>Your server is running version $phpVersion<br>";
if( (int)$verArray[0] < 5 ) {
	exit($error_msg);
}

class ZDGlobalCurrencyConverter {
	//Name for our options in the DB
 	private $ZDGCC_DB_option = 'ZDGlobalCurrencyConverter_options';
	private $plugin_url;
	private $plugin_dir;
	private $zdgplugin = array('name'=>'FX-CurrencyConverter Plugin for Wordpress',
							 'version'=>'1.0',
							 'date'=>'2009-05-25',
							 'pluginhome'=>'http://www.proloy.me/projects/wordpress-plugins/fx-currencyconverter-plugin-for-wordpress/',
							 'authorhome'=>'http://www.proloy.me/',
							 'rateplugin'=>'http://wordpress.org/extend/plugins/fx-currencyconverter-plugin-for-wordpress/',
							 'support'=>'mailto:support@proloy.me',
							 'more'=>'http://www.proloy.me/projects/wordpress-plugins/');
		
	//Initialize WordPress hooks
 	public function __construct() {
 		$this->plugin_dir = dirname(__FILE__);
		$this->plugin_url = defined('WP_PLUGIN_URL') ? WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)) : trailingslashit(get_bloginfo('wpurl')) . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)); 
		
		//Widget Initialization
		add_action('init', array(&$this, 'initWidget'));
		
		//add shortcode handler
	 	add_shortcode('zdgcc', array(&$this, 'displayBadge'));
	 	
	 	// Add Options Page
		add_action('admin_menu', array(&$this, 'addAdminMenu'));
		
		//add css to header
		add_action('wp_head', array(&$this, 'addCSS'));
    }
    
    //Set-up DB Variables
	public function install() {
		//Plugin Images
		$imgpath = $this->plugin_url.'/images/';
		
		//Widget CSS
		$widgetCSS  = '/*--Post and Page Widget--*/'."\n";
		$widgetCSS .= '.zdgccwrapper { width: 200px; padding: 0px; margin: 0px; }'."\n";
		$widgetCSS .= '.zdgccwrapper * { padding: 0px; margin: 0px; }'."\n";
		$widgetCSS .= '.zdgccwrapper h3 { background-image: url('.$imgpath.'BGsidebar.jpg); background-position: top left; background-repeat: no-repeat; color: #ffffff; font-size: 12px; font-weight: bold; height: 25px; line-height: 25px; padding-left: 12px; text-align: left; }'."\n";
		$widgetCSS .= '.zdgccbox { background-color: #ffffff; border: 1px solid #424242; padding: 15px; }'."\n";
		$widgetCSS .= '.zdgccbox * { padding: 0px; margin: 0px; }'."\n";
		$widgetCSS .= '.zdgccbox select { width: 168px; height: 22px; margin: 0px 0px 4px 0px; }'."\n";
		$widgetCSS .= '.zdgccbox br { clear: both; display: inline; }'."\n";
		$widgetCSS .= '.zdgccbox .amountlabel { font-size: 14px; float: left; width: 60px; margin: 0px 0px 4px 0px; line-height: 22px; }'."\n";
		$widgetCSS .= '.zdgccbox .amountinput { float: right; width: 100px; height: 22px; }'."\n";
		$widgetCSS .= '.zdgccbox .getrate { padding: 4px 0px 0px 0px; text-align: right; width: 100%; }'."\r\n";
		$widgetCSS .= '/*--Sidebar Widget--*/'."\n";
		$widgetCSS .= '.zdgbox { padding: 10px; margin: 0px; }'."\n";
		$widgetCSS .= '.zdgbox * { padding: 0px; margin: 0px; }'."\n";
		$widgetCSS .= '.zdgbox select { width: 98%; height: 22px; margin: 0px 0px 4px 0px; }'."\n";
		$widgetCSS .= '.zdgbox br { clear: both; display: inline; }'."\n";
		$widgetCSS .= '.zdgbox .amountlabel { font-size: 14px; float: left; width: 60px; margin: 0px 10px 4px 0px; line-height: 22px; }'."\n";
		$widgetCSS .= '.zdgbox .amountinput { float: left; width: 150px; height: 22px; }'."\n";
		$widgetCSS .= '.zdgbox .getrate { padding: 4px 0px 0px 0px; text-align: left; width: 100%; }'."\n";
		
		$options = array('landingpageoption' => 'branded', 'referralcode' => '', 'pluginurl' => $this->plugin_url, 'widgetcss' => $widgetCSS, 'widgettitle' => 'Currency Converter', 'referralurl' => 'http://www.gatehouseintl.com/wordpress-plugin-currency-converter/');
              
		update_option($this->ZDGCC_DB_option, $options);
	}
    
    //Register Widget
    public function initWidget() {
    	//Register Widget
		register_sidebar_widget('FX-CurrencyConverter', array(&$this, 'displayWidget'));
    	
    	// register widget control
		register_widget_control('FX-CurrencyConverter', array(&$this, 'displayWidgetControl'));
    }
    
    //Hook the options page
	public function addAdminMenu() {
		$plugin_page = add_options_page('FX-Currency Converter Options', 'FX-Currency Converter', 10, basename(__FILE__), array(&$this, 'handleOptions'));
		add_action('admin_head-'. $plugin_page, array(&$this, 'myplugin_admin_header'));		
	}
	
	public function myplugin_admin_header(){
		echo '<link href="'.$this->plugin_url.'/zdgstyle_admin.css" rel="stylesheet" type="text/css">'."\n";
	}
	
	//Add CSS to Frontend
	public function addCSS() {
		echo '<link href="'.$this->plugin_url.'/zdgstyle_widget.php" rel="stylesheet" type="text/css">'."\n";
	}
	
	//Hancles Admin Page Options
	public function handleOptions() {
		//Plugin Information
		$zplugin_info = $this->zdgplugin;
		
		//DB Plugin Options
		$options = get_option($this->ZDGCC_DB_option);
		
		//Plugin Images
		$imgpath = $this->plugin_url.'/images/';
		
		//Form Action URL
		$action_url = $_SERVER['REQUEST_URI'];
              
		if (isset($_POST['submitted'])) {
			//check security
			check_admin_referer('zdgcc-nonce');
	
			$options['landingpageoption'] = $_POST['landingpageoption'];
			$options['referralcode'] = $_POST['referralcode'];
			$options['widgetcss'] = $_POST['widgetcss'];
				
			update_option($this->ZDGCC_DB_option, $options);
				
			echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
		}
			
		include('zdg-cc-options.php');
	}
	
	//Display Players in Post and Page
	public function displayWidget($args = array()) {
		// extract the parameters
		extract($args);
		
		//DB Plugin Options
		$options = get_option($this->ZDGCC_DB_option);
		
		$title = $options['widgettitle'];
		
		//Ouput Widget
		echo $before_widget;
		
		echo $before_title.$title.$after_title;
		
		echo $this->WidgetHTML($options, false);
		
		echo $after_widget;
	}
	
	//Widget Control 
	public function displayWidgetControl() {
		//DB Plugin Options
		$options = get_option($this->ZDGCC_DB_option);
		
		// handle user input
		if($_POST['zdg_submit']) {
			$options['widgettitle'] = strip_tags(stripslashes($_POST['zdwidgettitle']));
			update_option($this->ZDGCC_DB_option, $options);
		}
		$title = $options['widgettitle'];
		
		//Widget Form
		$controlForm  = '<p><label for="zdwidgettitle">Title: <input name="zdwidgettitle" id="zdwidgettitle" type="text" value="'.$title.'" /></label>';
		$controlForm .= '<input type="hidden" id="zdg_submit" name="zdg_submit" value="1" /></p>';
		
		echo $controlForm; 
	}
	
	//Display Players in Post and Page
	public function displayBadge($atts, $content=null) {
		//DB Plugin Options
		$options = get_option($this->ZDGCC_DB_option);
		
		return $this->WidgetHTML($options);
	}
	
	//Widget HTML
	private function WidgetHTML ($options, $badge = true) {
		if($badge) {
			$html .= '<div class="zdgccwrapper">';
			$html .= '<h3>'.$options['widgettitle'].'</h3>';
			$html .= '<div class="zdgccbox">';
		}else {
			$html .= '<div class="zdgbox">';
		}
		
		
		$html .= '<form  method="get" action="http://www.fx-foreignexchange.com/currency.php" target="foo" onsubmit="window.open(\'\', \'foo\', \'width=660,height=880,status=no,resizable=no,scrollbars=yes\')">';
		$html .= '<input name="r" type="hidden" value="'.$options['referralcode'].'" />';
		$html .= '<select name="from" id="from">
	          <option value="" selected="selected">From Currency</option>
	          <option value="GBP">British Pound</option>
	          <option value="EUR">Euro</option>
	          <option value="AED">United Arab Emirates Dirham</option>
	          <option value="USD">United States Dollar</option>
	          <option value="" disabled="disabled">----------------</option>
	          <option value="ALL">Albanian Lek</option>
	          <option value="DZD">Algerian Dinar</option>
	          <option value="ARS">Argentine Peso</option>
	          <option value="AWG">Aruba Florin</option>
	          <option value="AUD">Australian Dollar</option>
	          <option value="BSD">Bahamian Dollar</option>
	          <option value="BHD">Bahraini Dinar</option>
	          <option value="BDT">Bangladesh Taka</option>
	          <option value="BBD">Barbados Dollars</option>
	          <option value="BYR">Belarus Ruble</option>
	          <option value="BZD">Belize Dollar</option>
	          <option value="BMD">Bermuda Dollar</option>
	          <option value="BTN">Bhutan Ngultrum</option>
	          <option value="BOB">Bolivia Boliviano</option>
	          <option value="BWP">Botswana Pula</option>
	          <option value="BRL">Brazilian Real</option>
	          <option value="BND">Brunei Dollar</option>
	          <option value="BGN">Bulgarian Lev</option>
	          <option value="BIF">Burundi Franc</option>
	          <option value="KHR">Cambodia Riel</option>
	          <option value="CAD">Canadian Dollar</option>
	          <option value="CVE">Cape Verde Escudo</option>
	          <option value="KYD">Cayman Islands Dollar</option>
	          <option value="XOF">Central African Republic</option>
	          <option value="CLP">Chilean Peso</option>
	          <option value="CNY">Chinese Yuan</option>
	          <option value="COP">Columbian Peso</option>
	          <option value="KMF">Comoros Franc</option>
	          <option value="CRC">Costa Rica Colon</option>
	          <option value="HRK">Croatian Kuna</option>
	          <option value="CUP">Cuban Peso</option>
	          <option value="CYP">Cyprus Pound</option>
	          <option value="CZK">Czech Koruna</option>
	          <option value="DKK">Denmark Krone</option>
	          <option value="DJF">Djibouti Franc</option>
	          <option value="DOP">Dominican Peso</option>
	          <option value="XCD">East Caribbean Dollar</option>
	          <option value="ECS">Ecuador Sucre</option>
	          <option value="EGP">Egyptian Pound</option>
	          <option value="SVC">El Salvador Colon</option>
	          <option value="ERN">Eritrea Nakfa</option>
	          <option value="EEK">Estonian Kroon</option>
	          <option value="ETB">Ethiopian Birr</option>
	          <option value="FKP">Falkland Islands Pound</option>
	          <option value="FJD">Fiji Dollar</option>
	          <option value="GMD">Gambian Dalasi</option>
	          <option value="GHC">Ghanian Cedi</option>
	          <option value="GIP">Gibraltar Pound</option>
	          <option value="GTQ">Guatemala Quetzal</option>
	          <option value="GNF">Guinea Franc</option>
	          <option value="GYD">Guyana Dollar</option>
	          <option value="HTG">Haiti Gourde</option>
	          <option value="HNL">Honduras Lempira</option>
	          <option value="HKD">Hong Kong Dollar</option>
	          <option value="HUF">Hungarian Forint</option>
	          <option value="ISK">Iceland Krona</option>
	          <option value="INR">Indian Rupee</option>
	          <option value="IDR">Indonesian Rupiah</option>
	          <option value="IRR">Iran Rial</option>
	          <option value="IQD">Iraqi Dinar</option>
	          <option value="ILS">Israeli Shekel</option>
	          <option value="JMD">Jamaican Dollar</option>
	          <option value="JPY">Japanese Yen</option>
	          <option value="JOD">Jordanian Dinar</option>
	          <option value="KZT">Kazakhstan Tenge</option>
	          <option value="KES">Kenyan Shilling</option>
	          <option value="KRW">Korean Won</option>
	          <option value="KWD">Kuwaiti Dinar</option>
	          <option value="LAK">Laos Kip</option>
	          <option value="LVL">Latvian Lat</option>
	          <option value="LBP">Lebanese Pound</option>
	          <option value="LSL">Lesotho Loti</option>
	          <option value="LRD">Liberian Dollar</option>
	          <option value="LYD">Libyan Dinar</option>
	          <option value="LTL">Lithuanian Lita</option>
	          <option value="MOP">Macau Pataca</option>
	          <option value="MKD">Macedoniab Dinar</option>
	          <option value="MWK">Malawi Kwacha</option>
	          <option value="MYR">Malaysian Ringgit</option>
	          <option value="MVR">Maldives Rufiyaa</option>
	          <option value="MTL">Maltese Lira</option>
	          <option value="MRO">Mauritania Ougulya</option>
	          <option value="MUR">Mauritius Rupee</option>
	          <option value="MXN">Mexican Peso</option>
	          <option value="MDL">Moldovan Leu</option>
	          <option value="MNT">Mongolian Tugrik</option>
	          <option value="MAD">Moroccan Dirham</option>
	          <option value="MMK">Myanmar Kyat(Burma)</option>
	          <option value="NAD">Namibian Dollar</option>
	          <option value="NPR">Nepalese Rupee</option>
	          <option value="ANG">Netherlands Antilles Guilder</option>
	          <option value="TRY">New Turkish Lira</option>
	          <option value="NZD">New Zealand Dollar</option>
	          <option value="ZWN">New Zimbabwe Dollar</option>
	          <option value="NIO">Nicaragua Cordoba</option>
	          <option value="NGN">Nigerian  Naira</option>
	          <option value="KPW">North Korean Won</option>
	          <option value="NOK">Norwegian Krone</option>
	          <option value="OMR">Omani Rial</option>
	          <option value="XPF">Pacific Franc</option>
	          <option value="PKR">Pakistani Rupee</option>
	          <option value="PAB">Panama Balboa</option>
	          <option value="PGK">Papua New Guinea Kina</option>
	          <option value="PYG">Paraguayan Guarani</option>
	          <option value="PEN">Peruvian Nuevo Sol</option>
	          <option value="PHP">Philippine Peso</option>
	          <option value="PLN">Polish Zloty</option>
	          <option value="QAR">Qatar Rial</option>
	          <option value="RON">Romanian New Leu</option>
	          <option value="RUB">Russian Rouble</option>
	          <option value="RWF">Rwanda Franc</option>
	          <option value="WST">Samoa Tala</option>
	          <option value="STD">Sao Tome Dobra</option>
	          <option value="SAR">Saudi Arabian Rial</option>
	          <option value="SCR">Seychelles Rupee</option>
	          <option value="SLL">Sierra Leone Leone</option>
	          <option value="SGD">Singapore Dollar</option>
	          <option value="SKK">Slovak Koruna</option>
	          <option value="SIT">Slovenian Tolar</option>
	          <option value="SBD">Solomon Islands Dollar</option>
	          <option value="SOS">Somali Shilling</option>
	          <option value="ZAR">South African Rand</option>
	          <option value="KRW">South Korea Won</option>
	          <option value="LKR">Sri Lanka Rupee</option>
	          <option value="SHP">St Helena Pound</option>
	          <option value="SDD">Sudanese Dinar</option>
	          <option value="SZL">Swaziland Lilageni</option>
	          <option value="SEK">Swedish Krona</option>
	          <option value="CHF">Swiss Franc</option>
	          <option value="SYP">Syrian Pound</option>
	          <option value="TWD">Taiwan Dollar</option>
	          <option value="TZS">Tanzanian Shilling</option>
	          <option value="THB">Thai Baht</option>
	          <option value="TOP">Tonga Pa\'anga</option>
	          <option value="TTD">Trinidad And Tobago Dollar</option>
	          <option value="TND">Tunisian Dinar</option>
	          <option value="UGX">Ugandan Shilling</option>
	          <option value="UAH">Ukraine Hrynvia</option>
	          <option value="AED">United Arab Emirates Dirham</option>
	          <option value="UYU">Uruguayan New Peso</option>
	          <option value="VUV">Vanuatu Vatu</option>
	          <option value="VEB">Venezuelan Bolivar</option>
	          <option value="VND">Vietnam Dong</option>
	          <option value="YER">Yemen Riyal</option>
	          <option value="ZMK">Zambian Kwacha</option>
	        </select>
	        <br />
	        <select name="to" id="to">
	          <option value="" selected="selected">To Currency</option>
	          <option value="GBP">British Pound</option>
	          <option value="EUR">Euro</option>
	          <option value="AED">United Arab Emirates Dirham</option>
	          <option value="USD">United States Dollar</option>
	          <option value="" disabled="disabled">----------------</option>
	          <option value="ALL">Albanian Lek</option>
	          <option value="DZD">Algerian Dinar</option>
	          <option value="ARS">Argentine Peso</option>
	          <option value="AWG">Aruba</option>
	          <option value="AUD">Australian Dollar</option>
	          <option value="BSD">Bahamian Dollar</option>
	          <option value="BHD">Bahraini Dinar</option>
	          <option value="BDT">Bangladesh Taka</option>
	          <option value="BBD">Barbados Dollars</option>
	          <option value="BYR">Belarus Ruble</option>
	          <option value="BZD">Belize Dollar</option>
	          <option value="BMD">Bermuda Dollar</option>
	          <option value="BTN">Bhutan Ngultrum</option>
	          <option value="BOB">Bolivia Boliviano</option>
	          <option value="BWP">Botswana Pula</option>
	          <option value="BRL">Brazilian Real</option>
	          <option value="BND">Brunei Dollar</option>
	          <option value="BGN">Bulgarian Lev</option>
	          <option value="BIF">Burundi Franc</option>
	          <option value="KHR">Cambodia Riel</option>
	          <option value="CAD">Canadian Dollar</option>
	          <option value="CVE">Cape Verde Escudo</option>
	          <option value="KYD">Cayman Islands Dollar</option>
	          <option value="XOF">Central African Republic</option>
	          <option value="CLP">Chilean Peso</option>
	          <option value="CNY">Chinese Yuan</option>
	          <option value="COP">Columbian Peso</option>
	          <option value="KMF">Comoros Franc</option>
	          <option value="CRC">Costa Rica Colon</option>
	          <option value="HRK">Croatian Kuna</option>
	          <option value="CUP">Cuban Peso</option>
	          <option value="CYP">Cyprus Pound</option>
	          <option value="CZK">Czech Koruna</option>
	          <option value="DKK">Denmark Krone</option>
	          <option value="DJF">Djibouti Franc</option>
	          <option value="DOP">Dominican Peso</option>
	          <option value="XCD">East Caribbean Dollar</option>
	          <option value="ECS">Ecuador Sucre</option>
	          <option value="EGP">Egyptian Pound</option>
	          <option value="SVC">El Salvador Colon</option>
	          <option value="ERN">Eritrea Nakfa</option>
	          <option value="EEK">Estonian Kroon</option>
	          <option value="ETB">Ethiopian Birr</option>
	          <option value="FKP">Falkland Islands Pound</option>
	          <option value="FJD">Fiji Dollar</option>
	          <option value="GMD">Gambian Dalasi</option>
	          <option value="GHC">Ghanian Cedi</option>
	          <option value="GIP">Gibraltar Pound</option>
	          <option value="GTQ">Guatemala Quetzal</option>
	          <option value="GNF">Guinea Franc</option>
	          <option value="GYD">Guyana Dollar</option>
	          <option value="HTG">Haiti Gourde</option>
	          <option value="HNL">Honduras Lempira</option>
	          <option value="HKD">Hong Kong Dollar</option>
	          <option value="HUF">Hungarian Forint</option>
	          <option value="ISK">Iceland Krona</option>
	          <option value="INR">Indian Rupee</option>
	          <option value="IDR">Indonesian Rupiah</option>
	          <option value="IRR">Iran Rial</option>
	          <option value="IQD">Iraqi Dinar</option>
	          <option value="ILS">Israeli Shekel</option>
	          <option value="JMD">Jamaican Dollar</option>
	          <option value="JPY">Japanese Yen</option>
	          <option value="JOD">Jordanian Dinar</option>
	          <option value="KZT">Kazakhstan Tenge</option>
	          <option value="KES">Kenyan Shilling</option>
	          <option value="KRW">Korean Won</option>
	          <option value="KWD">Kuwaiti Dinar</option>
	          <option value="LAK">Laos Kip</option>
	          <option value="LVL">Latvian Lat</option>
	          <option value="LBP">Lebanese Pound</option>
	          <option value="LSL">Lesotho Loti</option>
	          <option value="LRD">Liberian Dollar</option>
	          <option value="LYD">Libyan Dinar</option>
	          <option value="LTL">Lithuanian Lita</option>
	          <option value="MOP">Macau Pataca</option>
	          <option value="MKD">Macedoniab Dinar</option>
	          <option value="MWK">Malawi Kwacha</option>
	          <option value="MYR">Malaysian Ringgit</option>
	          <option value="MVR">Maldives Rufiyaa</option>
	          <option value="MTL">Maltese Lira</option>
	          <option value="MRO">Mauritania Ougulya</option>
	          <option value="MUR">Mauritius Rupee</option>
	          <option value="MXN">Mexican Peso</option>
	          <option value="MDL">Moldovan Leu</option>
	          <option value="MNT">Mongolian Tugrik</option>
	          <option value="MAD">Moroccan Dirham</option>
	          <option value="MMK">Myanmar Kyat(Burma)</option>
	          <option value="NAD">Namibian Dollar</option>
	          <option value="NPR">Nepalese Rupee</option>
	          <option value="ANG">Netherlands Antilles Guilder</option>
	          <option value="TRY">New Turkish Lira</option>
	          <option value="NZD">New Zealand Dollar</option>
	          <option value="ZWN">New Zimbabwe Dollar</option>
	          <option value="NIO">Nicaragua Cordoba</option>
	          <option value="NGN">Nigerian  Naira</option>
	          <option value="KPW">North Korean Won</option>
	          <option value="NOK">Norwegian Krone</option>
	          <option value="OMR">Omani Rial</option>
	          <option value="XPF">Pacific Franc</option>
	          <option value="PKR">Pakistani Rupee</option>
	          <option value="PAB">Panama Balboa</option>
	          <option value="PGK">Papua New Guinea Kina</option>
	          <option value="PYG">Paraguayan Guarani</option>
	          <option value="PEN">Peruvian Nuevo Sol</option>
	          <option value="PHP">Philippine Peso</option>
	          <option value="PLN">Polish Zloty</option>
	          <option value="QAR">Qatar Rial</option>
	          <option value="RON">Romanian New Leu</option>
	          <option value="RUB">Russian Rouble</option>
	          <option value="RWF">Rwanda Franc</option>
	          <option value="WST">Samoa Tala</option>
	          <option value="STD">Sao Tome Dobra</option>
	          <option value="SAR">Saudi Arabian Rial</option>
	          <option value="SCR">Seychelles Rupee</option>
	          <option value="SLL">Sierra Leone Leone</option>
	          <option value="SGD">Singapore Dollar</option>
	          <option value="SKK">Slovak Koruna</option>
	          <option value="SIT">Slovenian Tolar</option>
	          <option value="SBD">Solomon Islands Dollar</option>
	          <option value="SOS">Somali Shilling</option>
	          <option value="ZAR">South African Rand</option>
	          <option value="KRW">South Korea Won</option>
	          <option value="LKR">Sri Lanka Rupee</option>
	          <option value="SHP">St Helena Pound</option>
	          <option value="SDD">Sudanese Dinar</option>
	          <option value="SZL">Swaziland Lilageni</option>
	          <option value="SEK">Swedish Krona</option>
	          <option value="CHF">Swiss Franc</option>
	          <option value="SYP">Syrian Pound</option>
	          <option value="TWD">Taiwan Dollar</option>
	          <option value="TZS">Tanzanian Shilling</option>
	          <option value="THB">Thai Baht</option>
	          <option value="TOP">Tonga Pa\'anga</option>
	          <option value="TTD">Trinidad And Tobago Dollar</option>
	          <option value="TND">Tunisian Dinar</option>
	          <option value="UGX">Ugandan Shilling</option>
	          <option value="UAH">Ukraine Hrynvia</option>
	          <option value="AED">United Arab Emirates Dirham</option>
	          <option value="UYU">Uruguayan New Peso</option>
	          <option value="VUV">Vanuatu Vatu</option>
	          <option value="VEB">Venezuelan Bolivar</option>
	          <option value="VND">Vietnam Dong</option>
	          <option value="YER">Yemen Riyal</option>
	          <option value="ZMK">Zambian Kwacha</option>
	        </select>
	        <br />
	        <div class="amountlabel">Amount</div>
	        <input name="value" id="value" type="text" size="14" maxlength="10" class="amountinput" />
	        <br />
	        <div class="getrate"><input type="submit" value="Get Rate" /></div>	        
	      </form>
	      </div>';
  		if($badge) {
	      	$html .= '</div>';
      	}		
		
		return $html;
	}
	
}

//Initialize Plugin
if (class_exists('ZDGlobalCurrencyConverter')) {
	$ZDGlobalCurrencyConverter = new ZDGlobalCurrencyConverter();
	if (isset($ZDGlobalCurrencyConverter)) {
		register_activation_hook(__FILE__, array(&$ZDGlobalCurrencyConverter, 'install'));
	}
}
?>