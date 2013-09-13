<?php
	$module_info['name'] = 'Featured';
	$module_info['desc'] = 'A story manager that lets you embed featured stories.';
	$module_info['version'] = 2.0;
	$module_info['settings_url'] = '../module.php?module=featured';

	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "featured",
	'sql' => "CREATE TABLE `".table_prefix . "featured` (
	  `featured_id` int(11) NOT NULL auto_increment,
	  `featured_link_id` int(11) NOT NULL,	  
	  `featured_link_title` varchar(255) default NULL,
	  `featured_description` text default NULL,
	  `featured_enabled` enum('Yes','No') NOT NULL,
	  `featured_image` longblob NOT NULL,
	  PRIMARY KEY  (`featured_id`)
	) ENGINE=MyISAM ");
?>