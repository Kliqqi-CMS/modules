<?php
if(defined('mnminclude')){
	include_once('phpbb_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
//		module_add_action_tpl('tpl_header_admin_links', phpbb_tpl_path . 'phpbb_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', phpbb_tpl_path . 'phpbb_admin_main_link.tpl');

		module_add_action('admin_users_save', 'phpbb_admin_users_save', '');
		module_add_action('profile_save', 'phpbb_profile_save', '');

		include_once(mnmmodules . 'phpbb/phpbb_main.php');
	}

	$include_in_pages = array('register');
	if( do_we_load_module() ) {		
		module_add_action('register_success_pre_redirect', 'phpbb_register', '');

		include_once(mnmmodules . 'phpbb/phpbb_main.php');
	}

	$include_in_pages = array('login');
	if( do_we_load_module() ) {		
		module_add_action('login_success_pre_redirect', 'phpbb_login', '');
		module_add_action('logout_success', 'phpbb_logout', '');

		include_once(mnmmodules . 'phpbb/phpbb_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'phpbb'){
			module_add_action('module_page', 'phpbb_showpage', '');
		
			include_once(mnmmodules . 'phpbb/phpbb_main.php');
		}
	}
}
?>