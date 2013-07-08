<?php
	$module_info['name'] = 'Close Comments';
	$module_info['desc'] = 'Automatically close comments on articles older than X.';
	$module_info['version'] = 1.0;
	$module_info['settings_url'] = '../module.php?module=close_comments';

	// Add new table to keep track of individually close comments.
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "close_comments",
	'sql' => "CREATE TABLE `".table_prefix . "close_comments` (
	  `close_link_id` int(11) NOT NULL,
  	  UNIQUE KEY `close_link_id` (`close_link_id`)
	  ) ENGINE=MyISAM");	
	
?>
