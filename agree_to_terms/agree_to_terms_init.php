<?php
if(defined('mnminclude')){
	include_once('agree_to_terms_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('register_showform', 'agree_to_terms_register', '');
		module_add_action('register_check_errors', 'agree_to_terms_register_check_error', '');

		include_once(mnmmodules . 'agree_to_terms/agree_to_terms_main.php');
	}
}
?>
