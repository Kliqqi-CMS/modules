<?php
	$module_info['name'] = 'OpenId';
	$module_info['desc'] = 'OpenId login BETA';
	$module_info['version'] = 0.1;
	$module_info['requires'][] = array('users_extra_fields', 0.1);
	// $module_info['requires'][] = array('', 0.1);

	$module_info['db_add_field'][]=array('users', 'openid_url', 'VARCHAR',  127, '', 0, '');
?>
