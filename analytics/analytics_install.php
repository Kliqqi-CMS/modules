<?php
	$module_info['name'] = 'Google Analytics';
	$module_info['desc'] = 'Embed Google web Analytics tracking code the easy way! Just install and add your Google tracking ID to the settings area.';
	$module_info['version'] = 1.0;
	$module_info['settings_url'] = '../module.php?module=analytics';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/analytics/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/analytics/version/';
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('analytics_id','')";

?>
