<?php
if(defined('mnminclude')){
	include_once('profiles_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('user', 'profile');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {
		// execute the function that retreives extra profile data
		module_add_action('index_top', 'profiles_retrieve', '');

		module_add_action_tpl('tpl_pligg_profile_info_middle', profiles_tpl_path . 'profile_extend.tpl');
		include_once(mnmmodules . 'profiles/profiles_main.php');

		include_once(mnmmodules . 'profiles/profiles_main.php');
	}
}
?>