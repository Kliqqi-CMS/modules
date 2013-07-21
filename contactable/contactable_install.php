<?php
	$module_info['name'] = 'Contactable';
	$module_info['desc'] = 'A simple, jQuery based, contact form embedded on the left side of your site.';
	$module_info['version'] = 1.0;
	$module_info['settings_url'] = '../module.php?module=contactable';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/contactable/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/contactable/version/';
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('contactable_mail','')";

?>
