<?php
if(defined('mnminclude')){
	include_once('email_article_settings.php');
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_pligg_story_tools_end', email_article_tpl_path . 'email_article.tpl');
	}
}
?>