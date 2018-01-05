<?php

class aio_pro_init {

	function __construct() {

		// Move these to some other function.
		require_once( AIOSEOP_PLUGIN_DIR . 'pro/functions_general.php' );
		require_once( AIOSEOP_PLUGIN_DIR . 'pro/functions_class.php' );
		require_once( AIOSEOP_PLUGIN_DIR . 'pro/aioseop_pro_updates_class.php' );
		require_once( AIOSEOP_PLUGIN_DIR . 'pro/class-translations_check.php' );
	}
}

$aioproinit = new aio_pro_init();
