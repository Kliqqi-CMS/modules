<?php
if(defined('mnminclude')){
	include_once('ajaxcontact_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('module');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];


		if($moduleName == 'ajaxcontact'){
			//
			module_add_action('module_page', 'ajaxchat_showpage', '');
			
			//
			module_add_js(ajaxcontact_path . 'js/functionAddEvent.js');
			module_add_js(ajaxcontact_path . 'js/contact.js');
			module_add_js(ajaxcontact_path . 'js/xmlHttp.js');
	
			include_once(mnmmodules . 'ajaxcontact/ajaxcontact_main.php');
	
		}
	}
}
?>