<?php

// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('friends_activity_path', my_pligg_base . '/modules/friends_activity/');
// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('friends_activity_lang_conf', '/modules/friends_activity/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('friends_activity_tpl_path', '../modules/friends_activity/templates/');


define('URL_friends_activity', my_pligg_base.'/module.php?module=friends_activity');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('friends_activity_path', friends_activity_path);
	$main_smarty->assign('friends_activity_lang_conf', friends_activity_lang_conf);
	$main_smarty->assign('friends_activity_tpl_path', friends_activity_tpl_path);
	$main_smarty->assign('URL_friends_activity', URL_friends_activity);
}

?>