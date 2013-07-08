<?php
	include_once('unique_visitors_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			module_add_action_tpl('tpl_pligg_sidebar_end', unique_visitors_tpl_path . 'unique_visitors.tpl');
		}
	}
?>