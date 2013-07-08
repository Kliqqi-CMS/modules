<?php
	$module_info['name'] = 'Yahoo Publishers Network Revenue Sharing';
	$module_info['desc'] = 'Allows you to share your YPN revenue';
	$module_info['version'] = 0.1;
	$module_info['requires'][] = array('users_extra_fields', 0.1);
	
	$module_info['db_add_field'][]=array('users', 'ypn_id', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'ypn_channel', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'ypn_percent', 'TINYINT',  3, "UNSIGNED", 0, '50');
?>
