<?php
include_once('close_comments_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and new.php becomes 'new'
$do_not_include_in_pages = array();

$include_in_pages = array('all');
if( do_we_load_module() ) {		
	module_add_action_tpl('tpl_header_admin_main_links', close_comments_tpl_path . 'close_comments_admin_sidebar.tpl');
}

$include_in_pages = array('story');
if( do_we_load_module() ) {		
	if(is_object($main_smarty)){
		module_add_action('story_top', 'close_comments_register', '');
		$main_smarty->plugins_dir[] = close_comments_plugins_path;
		
		// Story admin link
		module_add_action_tpl('tpl_link_summary_admin_links', close_comments_tpl_path . 'close_comments_story_admin.tpl');
		
		// Logged In
		module_add_action_tpl('tpl_pligg_story_comments_form_start', close_comments_tpl_path . 'close_comments_1.tpl');
		module_add_action_tpl('tpl_pligg_story_comments_form_end', close_comments_tpl_path . 'close_comments_2.tpl');
		
		// Not Logged In
		module_add_action_tpl('anonymous_comment_form_start', close_comments_tpl_path . 'close_comments_1.tpl');
		module_add_action_tpl('anonymous_comment_form_end', close_comments_tpl_path . 'close_comments_2.tpl');

		include_once(mnmmodules . 'close_comments/close_comments_main.php');
	}
}

$include_in_pages = array('module');
if( do_we_load_module() ) {		
	$moduleName = $_REQUEST['module'];
	if($moduleName == 'close_comments'){
		module_add_action('module_page', 'close_comments_showpage', '');
		include_once(mnmmodules . 'close_comments/close_comments_main.php');
	}
}

?>
