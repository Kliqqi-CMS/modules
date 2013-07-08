<?php

// the path to the module. the probably shouldn't be changed unless you rename the version_check folder(s)
define('version_check_path', my_pligg_base . '/modules/version_check/');

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
	
define('version_check_lang_conf', lang_loc . '/modules/version_check/lang.conf');
define('version_check_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the version_check folder(s)
define('version_check_tpl_path', '../modules/version_check/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('version_check_path', version_check_path);
	$main_smarty->assign('version_check_lang_conf', version_check_lang_conf);
	$main_smarty->assign('version_check_pligg_lang_conf', version_check_lang_conf);
	$main_smarty->assign('version_check_tpl_path', version_check_tpl_path);
}

?>