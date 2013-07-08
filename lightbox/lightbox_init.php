<?php
if(defined('mnminclude')){
	include_once('lightbox_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {		

		module_add_action_tpl('tpl_pligg_head_end', lightbox_tpl_path . 'pligg_pre_title.tpl');
	
		module_add_action_tpl('tpl_footer', lightbox_tpl_path . 'lightbox_footer.tpl');

	}
}
?>