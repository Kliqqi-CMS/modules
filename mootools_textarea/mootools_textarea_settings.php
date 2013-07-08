<?php
// the path to the module. the probably shouldn't be changed unless you rename the mootools_textarea folder(s)
define('mootools_textarea_path', my_pligg_base . '/modules/mootools_textarea/');
// the path to the modules templates. the probably shouldn't be changed unless you rename the mootools_textarea folder(s)
define('mootools_textarea_tpl_path', '../modules/mootools_textarea/templates/');

if(is_object($main_smarty)){
	$main_smarty->assign('mootools_textarea_path', mootools_textarea_path);
	$main_smarty->assign('mootools_textarea_tpl_path', mootools_textarea_tpl_path);
}

?>
