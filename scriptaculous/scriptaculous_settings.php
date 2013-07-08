<?php

// the path to the module. the probably shouldn't be changed unless you rename the scriptaculous folder(s)
define('scriptaculous_path', my_pligg_base . '/modules/scriptaculous/');
// the path to the modules templates. 
define('scriptaculous_tpl_path', '../modules/scriptaculous/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('scriptaculous_path', scriptaculous_path);
	$main_smarty->assign('scriptaculous_tpl_path', scriptaculous_tpl_path);
}

?>
