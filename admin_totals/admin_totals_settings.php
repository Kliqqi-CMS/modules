<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_totals folder(s)
define('admin_totals_path', my_pligg_base . '/modules/admin_totals/');

// the path to the module. the probably shouldn't be changed unless you rename the module_store folder(s)
	if(!defined('lang_loc')){
		// determine if we're in root or another folder like admin
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/"){$path = "";}
			
			if($path != my_pligg_base){
				define('lang_loc', '..');
			} else {
				define('lang_loc', '.');
			}
	}
	
define('admin_totals_lang_conf', lang_loc . '/modules/admin_totals/lang.conf');
define('admin_pligg_totals_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");


// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_totals folder(s)
define('admin_totals_tpl_path', '../modules/admin_totals/templates/');

define('URL_admin_totals', my_pligg_base . '/module.php?module=admin_totals');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('admin_totals_path', admin_totals_path);
	$main_smarty->assign('admin_totals_lang_conf', admin_totals_lang_conf);
	$main_smarty->assign('admin_totals_tpl_path', admin_totals_tpl_path);

	$main_smarty->assign('URL_admin_totals', URL_admin_totals);	
}

?>