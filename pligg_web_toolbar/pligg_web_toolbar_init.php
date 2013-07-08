<?php
if(defined('mnminclude')){
	include_once('pligg_web_toolbar_settings.php');
	include_once(mnmmodules . 'pligg_web_toolbar/pligg_web_toolbar_main.php');

	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {
		module_add_action_tpl('tpl_header_admin_main_links', pligg_web_toolbar_tpl_path . 'pligg_web_toolbar_admin_main_link.tpl');
		module_add_action('story_top', 'pligg_web_toolbar_story', '');
		module_add_action('pligg_web_toolbar', 'pligg_web_toolbar_display', '');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		
		$moduleName = $_REQUEST['module'];
		if($moduleName == 'pligg_web_toolbar'){
			module_add_action('module_page', 'pligg_web_toolbar_showpage', '');
		}
	}
}	
?>