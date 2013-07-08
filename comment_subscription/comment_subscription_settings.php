<?php

// the path to the module. 
define('comment_subscription_path', my_pligg_base . '/modules/comment_subscription/');
// the path to the module language file
define('comment_subscription_lang_conf', '/modules/comment_subscription/lang.conf');
// the path to the modules templates. 
define('comment_subscription_tpl_path', '../modules/comment_subscription/templates/');

define('URL_comment_subscription', my_pligg_base.'/module.php?module=comment_subscription');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('comment_subscription_path', comment_subscription_path);
	$main_smarty->assign('comment_subscription_lang_conf', comment_subscription_lang_conf);
	$main_smarty->assign('comment_subscription_tpl_path', comment_subscription_tpl_path);
	$main_smarty->assign('URL_comment_subscription', URL_comment_subscription);
}

?>