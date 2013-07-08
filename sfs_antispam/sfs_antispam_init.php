<?php
	include_once('sfs_antispam_settings.php');
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = sfs_antispam_plugins_path;

			module_add_action_tpl('tpl_admin_user_show_center_fields', sfs_antispam_tpl_path . 'sfs_antispam_index.tpl');
                        module_add_action_tpl('tpl_header_admin_main_links', sfs_antispam_tpl_path . 'count.tpl');
		}
		
	}
?>
