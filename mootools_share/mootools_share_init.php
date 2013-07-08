<?php
	include_once('mootools_share_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			module_add_action_tpl('tpl_pligg_head_end', mootools_share_tpl_path . 'mootools_share_head.tpl');
			module_add_action_tpl('tpl_pligg_story_tools_end', mootools_share_tpl_path . 'mootools_share_link.tpl');
		}
	}
?>