<?php
if(defined('mnminclude')){
	include_once('jquery_ui_settings.php');

	$include_in_pages = array('module');
	$do_not_include_in_pages = array();
        
        $include_in_pages = array('all');
	if( do_we_load_module() ) {	
           if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = jquery_ui_plugins_path;

			module_add_action_tpl('tpl_pligg_head_end', jquery_ui_tpl_path . 'jquery_ui.tpl');

		}	

		$moduleName = $_REQUEST['module'];


		if($moduleName == 'jquery_ui'){
			//
			module_add_action('module_page', 'ajaxchat_showpage', '');
			
			//
			module_add_js(jquery_ui_path . 'js/functionAddEvent.js');
			module_add_js(jquery_ui_path . 'js/contact.js');
			module_add_js(jquery_ui_path . 'js/xmlHttp.js');

			include_once(mnmmodules . 'jquery_ui/jquery_ui_main.php');
	
		}
	}
}
?>