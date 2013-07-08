<?php
	$module_info['name'] = 'Digg.com User Feeds';
	$module_info['desc'] = 'Adds an additional field to users\' profiles and then adds rss feeds for those users digg submit and vote feeds to a specified category.';
	$module_info['version'] = 0.1;
	$module_info['requires'][] = array('users_extra_fields', 0.2);
	
	$module_info['db_add_field'][]=array('users', 'digg_user_id', 'VARCHAR',  255, '', 0, '');
?>
