<?php
if(defined('mnminclude')){
	include_once('angular_js_settings.php');

	$include_in_pages = array('module');
	$do_not_include_in_pages = array();
        
        $include_in_pages = array('all');
	if( do_we_load_module() ) {	
           if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = angular_js_plugins_path;

			module_add_action_tpl('tpl_pligg_head_end', angular_js_tpl_path . 'angular_js.tpl');

		}	

		$moduleName = $_REQUEST['module'];


		if($moduleName == 'angular_js'){
			//
			module_add_action('module_page', 'ajaxchat_showpage', '');
			
			//
			module_add_js(angular_js_path . 'js/functionAddEvent.js');
			module_add_js(angular_js_path . 'js/contact.js');
			module_add_js(angular_js_path . 'js/xmlHttp.js');

			include_once(mnmmodules . 'angular_js/angular_js_main.php');
	
		}
	}
}
?>