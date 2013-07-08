<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_formulas folder(s)
define('admin_formulas_path', my_pligg_base . '/modules/admin_formulas/');

// the path to the module. the probably shouldn't be changed unless you rename the admin_formulas folder(s)
define('admin_formulas_lang_conf', '/modules/admin_formulas/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_formulas folder(s)
define('admin_formulas_tpl_path', '../modules/admin_formulas/templates/');

define('URL_admin_formulas', my_pligg_base . '/module.php?module=admin_formulas'); 

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('admin_formulas_path', admin_formulas_path);
	$main_smarty->assign('admin_formulas_lang_conf', admin_formulas_lang_conf);
	$main_smarty->assign('admin_formulas_tpl_path', admin_formulas_tpl_path);
	$main_smarty->assign('URL_admin_formulas', URL_admin_formulas);	
}

?>