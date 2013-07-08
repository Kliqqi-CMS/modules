<?php
if(defined('mnminclude')){
	include_once('page_statistics_settings.php');

	
	$include_in_pages = array('module');
	$do_not_include_in_pages = array();
	
	if( do_we_load_module() ) {	

		$moduleName = $_REQUEST['module'];
		// add the custom css
		module_add_css(my_pligg_base . '/modules/page_statistics/page_statistics.css');
		
		if($moduleName == 'pagestatistics'){
			
			module_add_action('module_page', 'page_statistics', '');
				
			include_once(mnmmodules . 'page_statistics/page_statistics_main.php');
	
		}
	}
}
?>