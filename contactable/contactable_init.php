<?php
include_once('contactable_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and upcoming.php becomes 'upcoming'
$do_not_include_in_pages = array();

$include_in_pages = array('all');
if( do_we_load_module() ) {		
	if(is_object($main_smarty)){
		$main_smarty->plugins_dir[] = contactable_plugins_path;
		$main_smarty->assign('contactable', get_contactable_settings());
		module_add_action_tpl('tpl_pligg_body_start', contactable_tpl_path . 'contactable.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', contactable_tpl_path . 'admin_link.tpl');
	}
}

$include_in_pages = array('module');
if( do_we_load_module() ) {		

	$moduleName = $_REQUEST['module'];

	if($moduleName == 'contactable'){
		module_add_action('module_page', 'contactable_showpage', '');
	
		include_once(mnmmodules . 'contactable/contactable_main.php');
	}
}

// 
// Read module settings
//
function get_contactable_settings()
{
	return array(
		'contactable_mail' => get_misc_data('contactable_mail')
	);
}
?>