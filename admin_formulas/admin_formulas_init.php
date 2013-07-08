<?php
if(defined('mnminclude')){
	include_once('admin_formulas_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and shakeit.php becomes 'shakeit'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', admin_formulas_tpl_path . 'admin_formulas_admin_main_link.tpl');
	}
	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'admin_formulas'){

			module_add_action('module_page', 'admin_formulas_showpage', '');
			module_add_js(admin_formulas_path . 'js/EditInPlaceAF.js');
		
			include_once(mnmmodules . 'admin_formulas/admin_formulas_main.php');
		}
	}
}	
?>