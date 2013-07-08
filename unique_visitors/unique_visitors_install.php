<?php
	$module_info['name'] = 'Unique Visitors';
	$module_info['desc'] = 'Displays how many unique visitors have visited your site';
	$module_info['version'] = 0.1;

	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "unique_visitors",
	'sql' => "CREATE TABLE ".table_prefix . "unique_visitors (
	  `ip` varchar(100) default NULL,
	  `session` varchar(100) default NULL,
	  `date` varchar(100) default NULL,
		PRIMARY KEY  (`ip`)
		) ENGINE=MyISAM ");
?>