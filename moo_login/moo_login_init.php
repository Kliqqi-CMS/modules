<?php
if(defined('mnminclude')){
	include_once('moo_login_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {		

		module_add_action_tpl('tpl_pligg_head_end', moo_login_tpl_path . 'pligg_end_head.tpl');
		module_add_action_tpl('tpl_pligg_body_start', moo_login_tpl_path . 'pligg_start_body.tpl');

	}
}
?>