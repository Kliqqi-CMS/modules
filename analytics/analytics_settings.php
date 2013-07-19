<?php

// the path to the module. the probably shouldn't be changed unless you rename the analytics folder(s)
define('analytics_path', my_pligg_base . '/modules/analytics/');

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
define('analytics_lang_conf', lang_loc . '/modules/analytics/lang.conf');
define('analytics_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the analytics folder(s)
define('analytics_tpl_path', '../modules/analytics/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('analytics_path', analytics_path);
	$main_smarty->assign('analytics_lang_conf', analytics_lang_conf);
	$main_smarty->assign('analytics_tpl_path', analytics_tpl_path);
}

?>
