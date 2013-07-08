<?php
if(defined('mnminclude')) {
	include_once('featured_settings.php');
	
	$do_not_include_in_pages = array('');
	$include_in_pages = array('all');	
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', featured_tpl_path . 'featured_admin_main_link.tpl');
		module_add_action('all_pages_top', 'featured_getdata', '');
		include_once(mnmmodules . 'featured/featured_main.php');
	}
	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {
		$moduleName = $_REQUEST['module'];		
		if($moduleName == 'featured') {
			module_add_action('module_page', 'featured_showpage', '');
			module_add_css(featured_path . '/css/admin.css');
			include_once(mnmmodules . 'featured/featured_main.php');
		}
	}
}
?>