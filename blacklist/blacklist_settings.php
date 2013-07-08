<?php

// the path to the module. the probably shouldn't be changed unless you rename the blacklist folder(s)
define('blacklist_path', my_pligg_base . '/modules/blacklist/');

// the path to the module. the probably shouldn't be changed unless you rename the blacklist folder(s)
define('blacklist_lang_conf', '/modules/blacklist/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the blacklist folder(s)
define('blacklist_tpl_path', '../modules/blacklist/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the blacklist folder(s)
define('blacklist_lib_path', './modules/blacklist/libs/');

// the path to the images. the probably shouldn't be changed unless you rename the blacklist folder(s)
define('blacklist_img_path', './modules/blacklist/images/');

define('blacklist_list_path', './modules/blacklist/blacklist.php');

define('URL_blacklist', 'module.php?module=blacklist');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('blacklist_path', blacklist_path);
	$main_smarty->assign('blacklist_lang_conf', blacklist_lang_conf);
	$main_smarty->assign('blacklist_tpl_path', blacklist_tpl_path);
	$main_smarty->assign('blacklist_lib_path', blacklist_lib_path);
	$main_smarty->assign('blacklist_img_path', blacklist_img_path);
	$main_smarty->assign('blacklist_list_path', blacklist_list_path);
	$main_smarty->assign('URL_blacklist', URL_blacklist);
}

?>
