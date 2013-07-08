<?php
if(defined('mnminclude')){
	include_once('random_story_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	if( do_we_load_module() ) {		

		module_add_action('all_pages_top', 'random_story_getdata', '');

		module_add_action_tpl('tpl_sidebar_top', random_story_tpl_path . 'random_story.tpl');
	
		include_once(mnmmodules . 'random_story/random_story_main.php');
	}
}
?>