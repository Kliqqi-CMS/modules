<?php
include_once('tinymce_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and upcoming.php becomes 'upcoming'
$include_in_pages = array('all');
$do_not_include_in_pages = array();

if( do_we_load_module() ) {
	$loadable_js_files = array();

	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	module_add_action_tpl('tpl_pligg_head_end', tinymce_tpl_path . 'tinymce.tpl');
	module_add_action_tpl('tpl_pligg_admin_head_end', tinymce_tpl_path . 'tinymce.tpl');


}

?>
