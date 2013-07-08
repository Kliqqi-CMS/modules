<?php
if(defined('mnminclude')){
	include_once('age_verification_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('register_showform', 'age_verification_register', '');
		module_add_action('register_check_errors', 'age_verification_register_check_error', '');

		include_once(mnmmodules . 'age_verification/age_verification_main.php');
	}
}
?>
