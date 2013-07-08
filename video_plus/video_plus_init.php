<?php
	include_once('video_plus_settings.php');

	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			include_once(mnmmodules . 'video_plus/video_plus_main.php');
			module_add_action('lib_link_summary_fill_smarty', 'video_plus_track', '');
			module_add_action_tpl('tpl_link_summary_pre_story_content', video_plus_tpl_path . 'video_plus_index.tpl');
			module_add_action_tpl('tpl_pligg_story_body_end', video_plus_tpl_path . 'video_plus_end.tpl');
		}
	}
	
?>
