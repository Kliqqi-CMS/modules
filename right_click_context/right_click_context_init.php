<?php
if(defined('mnminclude')){
	include_once('right_click_context_settings.php');
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	if( do_we_load_module() ) {	
		module_add_action_tpl('tpl_pligg_body_start', right_click_context_tpl_path . 'right_click_context_header.tpl');
		module_add_action_tpl('tpl_pligg_body_end', right_click_context_tpl_path . 'right_click_context_footer.tpl');
	}
}
?>