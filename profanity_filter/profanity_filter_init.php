<?php
if(defined('mnminclude')){
	include_once('profanity_filter_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->load_filter('output','profanity_filter');
		}
	}
}
?>
