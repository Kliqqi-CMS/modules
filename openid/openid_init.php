<?php
	include_once('openid_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('login');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = openid_plugins_path;
		}
		module_add_action_tpl('tpl_login_top', openid_tpl_path . 'openid_login_top.tpl');
	}
	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'openid'){

			module_add_action('module_page', 'openid_showpage', '');
		
			include_once(mnmmodules . 'openid/openid_main.php');
		}
	}
	
?>
