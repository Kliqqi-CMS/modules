<?php
if(defined('mnminclude')){
    include_once('submit_antispam_settings.php');

	// tell pligg what pages this modules should be included in	
	$include_in_pages = array('submit','story');
    
	$do_not_include_in_pages = array();
		                                         
	if( do_we_load_module() ) {		
        
		module_add_action('submit_post_authentication', 'check_submit_authorization','');        		        
        module_add_action('story_insert_comment','check_submit_authorization','');
        include_once(mnmmodules . 'submit_antispam/submit_antispam_main.php');
        
        //add js
        module_add_js(submit_antispam_path . '/js/countdown.js');
        
        //add smartty
        module_add_action_tpl('tpl_submit_step_3_end', submit_antispam_tpl_path . '/submit_info.tpl');

	}
}
?>
