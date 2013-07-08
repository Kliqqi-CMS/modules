<?php

// the path to the module. the probably shouldn't be changed unless you rename the moo_login folder(s)
define('moo_login_path', my_pligg_base . '/modules/moo_login/');

// the path to the modules templates. the probably shouldn't be changed unless you rename the moo_login folder(s)
define('moo_login_tpl_path', '../modules/moo_login/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('moo_login_path', moo_login_path);
	$main_smarty->assign('moo_login_tpl_path', moo_login_tpl_path);
}

?>