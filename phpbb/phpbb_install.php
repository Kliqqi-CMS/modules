<?php
	$module_info['name'] = 'phpBB';
	$module_info['desc'] = 'Allows to synchronize users with phpBB database';
	$module_info['version'] = 0.11;
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=phpbbintegration';
	$module_info['homepage_url'] = 'http://forums.pligg.com/pligg-modules/16319-phpbb-integration-module.html';
	$module_info['db_sql'][] = "ALTER TABLE `pligg_users` ADD  `user_phpbb` INT NOT NULL";
?>
