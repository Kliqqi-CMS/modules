<?php
	include_once('user_flags_settings.php');

	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = user_flags_plugins_path;
			module_add_action_tpl('tpl_pligg_admin_user_view_tr_start', user_flags_tpl_path . 'tpl_pligg_admin_user_view_tr_start.tpl');
			module_add_action_tpl('tpl_pligg_admin_users_td_start', user_flags_tpl_path . 'tpl_pligg_admin_users_td_start.tpl');
			module_add_action_tpl('tpl_pligg_admin_users_th_start', user_flags_tpl_path . 'tpl_pligg_admin_users_th_start.tpl');
			module_add_action_tpl('tpl_user_profile_social_end', user_flags_tpl_path . 'tpl_user_profile_social_end.tpl');

		}
	}
?>