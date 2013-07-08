<?php

// the path to the module. the probably shouldn't be changed unless you rename the basic_box folder(s)
define('basic_box_path', my_pligg_base . '/modules/basic_box/');
// the path to the module. the probably shouldn't be changed unless you rename the basic_box folder(s)
define('basic_box_lang_conf', '/modules/basic_box/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the basic_box folder(s)
define('basic_box_tpl_path', '../modules/basic_box/templates/');
// the path for smarty / template lite plugins
define('basic_box_plugins_path', 'modules/basic_box/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('basic_box_path', basic_box_path);
	$main_smarty->assign('basic_box_lang_conf', basic_box_lang_conf);
	$main_smarty->assign('basic_box_tpl_path', basic_box_tpl_path);
}

?>
