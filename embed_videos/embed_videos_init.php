<?php
if(defined('mnminclude')){
	include_once('embed_videos_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	
	if( do_we_load_module() ) {		

		module_add_action('lib_link_summary_fill_smarty', 'embed_videos_lib_link_summary_fill_smarty', '');

		module_add_action_tpl('tpl_link_summary_pre_story_content', embed_videos_tpl_path . 'link_summary_pre_story_content.tpl');
		
		include_once(mnmmodules . 'embed_videos/embed_videos_main.php');
	}
}	
?>