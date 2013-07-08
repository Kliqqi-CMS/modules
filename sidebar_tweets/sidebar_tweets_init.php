<?php

	include_once('sidebar_tweets_settings.php');
	$do_not_include_in_pages = array();	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = sidebar_tweets_plugins_path;

			module_add_action_tpl('tpl_pligg_sidebar_end', sidebar_tweets_tpl_path . 'sidebar_tweets_index.tpl');

		}
	}
	
	// Settings page in the admin panel
	$include_in_pages = array('module','admin_index','admin_widgets','admin_modules','admin_links','admin_comments','admin_users','admin_config','admin_categories','admin_page','admin_group','admin_editor');
	if( do_we_load_module() ) {
		module_add_action_tpl('tpl_header_admin_main_links', sidebar_tweets_tpl_path . 'sidebar_tweets_link.tpl');

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'sidebar_tweets'){
			module_add_action('module_page', 'sidebar_tweets_showpage', '');
		
			include_once(mnmmodules . 'sidebar_tweets/sidebar_tweets_main.php');
		}
	}	
	
?>
