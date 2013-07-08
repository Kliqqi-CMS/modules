<?php
if(defined('mnminclude')){
	include_once('thickbox_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and shakeit.php becomes 'shakeit'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array('admin_config');

	if( do_we_load_module() ) {		

		module_add_action_tpl('tpl_pligg_head_end', thickbox_tpl_path . 'pligg_pre_title.tpl');
	
	}
}
?>