<?php

// the path to the module. the probably shouldn't be changed unless you rename the variable_viewer folder(s)
define('variable_viewer_path', my_pligg_base . '/modules/variable_viewer/');
// the path to the module. the probably shouldn't be changed unless you rename the variable_viewer folder(s)
define('variable_viewer_lang_conf', '/modules/variable_viewer/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the variable_viewer folder(s)
define('variable_viewer_tpl_path', '../modules/variable_viewer/templates/');
// the path for smarty / template lite plugins
define('variable_viewer_plugins_path', 'modules/variable_viewer/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('variable_viewer_path', variable_viewer_path);
	$main_smarty->assign('variable_viewer_lang_conf', variable_viewer_lang_conf);
	$main_smarty->assign('variable_viewer_tpl_path', variable_viewer_tpl_path);
}

?>
