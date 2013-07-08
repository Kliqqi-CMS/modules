<?php

// the path to the module. the probably shouldn't be changed unless you rename the mootools folder(s)
define('mootools_path', my_pligg_base . '/modules/mootools/');
// the path to the modules templates. 
define('mootools_tpl_path', '../modules/mootools/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('mootools_path', mootools_path);
	$main_smarty->assign('mootools_tpl_path', mootools_tpl_path);
}

?>
