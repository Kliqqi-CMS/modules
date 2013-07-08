<?php

// the path to the module. the probably shouldn't be changed unless you rename the greybox folder(s)
define('greybox_path', my_pligg_base . '/modules/greybox/');
// the path to the modules templates. 
define('greybox_tpl_path', '../modules/greybox/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('greybox_path', greybox_path);
	$main_smarty->assign('greybox_tpl_path', greybox_tpl_path);
}

?>
