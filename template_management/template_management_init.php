<?php
if(defined('mnminclude')){
	include_once('template_management_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and shakeit.php becomes 'shakeit'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', template_management_tpl_path . 'template_management_admin_main_link.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'template_management'){

			module_add_action('module_page', 'template_management_showpage', '');
			module_add_js(template_management_path . 'js/EditInPlaceAF.js');
		
			include_once(mnmmodules . 'template_management/template_management_main.php');
		}
	}
}	
?>
