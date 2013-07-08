<?php

// the path to the module. the probably shouldn't be changed unless you rename the jquery folder(s)
define('jquery_path', my_pligg_base . '/modules/jquery/');
// the path to the modules templates. 
define('jquery_tpl_path', '../modules/jquery/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('jquery_path', jquery_path);
	$main_smarty->assign('jquery_tpl_path', jquery_tpl_path);
}

?>
