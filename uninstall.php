<?php
	/**
	* Uninstall
	* Clean up the WP DB by deleting the options created by the plugin.
	*
	*/
	// register widget control
	unregister_widget_control('FX-CurrencyConverter');
	
	//Register Widget
	unregister_sidebar_widget('FX-CurrencyConverter');
    	
    //Delete DB data
	delete_option('ZDGlobalCurrencyConverter_options');
?>