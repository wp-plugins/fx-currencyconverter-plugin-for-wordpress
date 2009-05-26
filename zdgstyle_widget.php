<?php
/**
* Global Currency Converter CSS
* Fetch Widget CSS from DB and ouput it.
*
*/

require_once("../../../wp-config.php");

//Plugn DB option name
$ZDGCC_DB_option = 'ZDGlobalCurrencyConverter_options';

//DB Plugin Options
$options = get_option($ZDGCC_DB_option);

//Output CSS
header('Content-type: text/css');
echo $options['widgetcss'];
?>