<?php
if(defined('mnminclude')){
	include_once('multibox_admin_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index'
	
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_pligg_admin_head_start', multibox_admin_tpl_path . 'multibox_admin_head_start.tpl');
		module_add_action_tpl('tpl_pligg_admin_body_end', multibox_admin_tpl_path . 'multibox_admin_body_end.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

	}
}	
?>