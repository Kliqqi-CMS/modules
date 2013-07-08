<?php
	$module_info['name'] = 'Sidebar Tweets';
	$module_info['desc'] = 'Displays your most recent Twitter updates in the sidebar.';
	$module_info['version'] = 1.1;
	$module_info['settings_url'] = '../module.php?module=sidebar_tweets';
	$module_info['homepage_url'] = 'http://forums.pligg.com/free-modules/22477-sidebar-tweets.html';
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=sidebar_tweets';
	
	// Database adjustments
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('sidebar_tweets_id','pligg')";
    $module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('sidebar_tweets_num','3')";
	
?>
