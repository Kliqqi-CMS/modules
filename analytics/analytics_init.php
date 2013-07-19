<?php
include_once('analytics_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and upcoming.php becomes 'upcoming'
$do_not_include_in_pages = array();

$include_in_pages = array('all');
if( do_we_load_module() ) {		
	if(is_object($main_smarty)){
		$main_smarty->plugins_dir[] = analytics_plugins_path;
		$main_smarty->assign('settings', get_analytics_settings());
		module_add_action_tpl('tpl_pligg_head_end', analytics_tpl_path . 'analytics.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', analytics_tpl_path . 'admin_link.tpl');
	}
}

$include_in_pages = array('module');
if( do_we_load_module() ) {		

	$moduleName = $_REQUEST['module'];

	if($moduleName == 'analytics'){
		module_add_action('module_page', 'analytics_showpage', '');
	
		include_once(mnmmodules . 'analytics/analytics_main.php');
	}
}

// 
// Read module settings
//
function get_analytics_settings()
{
	return array(
		'analytics_id' => get_misc_data('analytics_id')
	);
}
?>