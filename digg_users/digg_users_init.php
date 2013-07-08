<?php
if(defined('mnminclude')){
	include_once('digg_users_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('profile');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		
		module_add_action('profile_save', 'add_user_feeds', '');
		include_once(mnmmodules . 'digg_users/digg_users_main.php');
	}
}
?>
