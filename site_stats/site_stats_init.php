<?php
	include_once('site_stats_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = site_stats_plugins_path;
			module_add_action_tpl('tpl_link_summary_pre_story_content', site_stats_tpl_path . 'site_stats.tpl');
			module_add_action_tpl('tpl_pligg_story_body_end', site_stats_tpl_path . 'site_stats_end.tpl');
		}
	}
?>