<?php
define('sidebar_tweets_path', my_pligg_base . '/modules/sidebar_tweets/');
define('sidebar_tweets_tpl_path', '../modules/sidebar_tweets/templates/');
define('sidebar_tweets_plugins_path', 'modules/sidebar_tweets/plugins');
if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_tweets_path', sidebar_tweets_path);
	$main_smarty->assign('sidebar_tweets_lang_conf', sidebar_tweets_lang_conf);
	$main_smarty->assign('sidebar_tweets_tpl_path', sidebar_tweets_tpl_path);
}

$sidebar_tweets_id = get_misc_data('sidebar_tweets_id');
$main_smarty->assign('sidebar_tweets_id', $sidebar_tweets_id);
$sidebar_tweets_num = get_misc_data('sidebar_tweets_num');
$main_smarty->assign('sidebar_tweets_num', $sidebar_tweets_num);


?>
