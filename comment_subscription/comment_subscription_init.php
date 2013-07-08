<?php
if(defined('mnminclude')){
	include_once('comment_subscription_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	
	if( do_we_load_module() ) {		
		
		
		module_add_action('comment_subscription_insert_function', 'comment_subscription_insert', '');
		module_add_action('comment_subscription', 'comment_subscription_mail', '');
		module_add_action_tpl('submit_step_2_pre_extrafields', comment_subscription_tpl_path . 'comment_subscription_admin_main_link.tpl');
		
		include_once(mnmmodules . 'comment_subscription/comment_subscription_main.php');

	}
}	
?>