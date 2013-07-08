<?php

// the path to the module. the probably shouldn't be changed unless you rename the blocker folder(s)
define('blocker_path', my_pligg_base . '/modules/blocker/');
// the path to the module. the probably shouldn't be changed unless you rename the blocker folder(s)
define('blocker_lang_conf', '/modules/blocker/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the blocker folder(s)
define('blocker_tpl_path', '../modules/blocker/templates/');
// the path for smarty / template lite plugins
define('blocker_plugins_path', 'modules/blocker/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('blocker_path', blocker_path);
	$main_smarty->assign('blocker_lang_conf', blocker_lang_conf);
	$main_smarty->assign('blocker_tpl_path', blocker_tpl_path);
}

?>
