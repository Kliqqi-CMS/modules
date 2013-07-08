<?php
// the path to the module. the probably shouldn't be changed unless you rename the site_stats folder(s)
define('site_stats_path', my_pligg_base . '/modules/site_stats/');
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
define('site_stats_lang_conf', lang_loc . '/modules/site_stats/lang.conf');
define('site_stats_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the site_stats folder(s)
define('site_stats_tpl_path', '../modules/site_stats/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('site_stats_path', site_stats_path);
	$main_smarty->assign('site_stats_lang_conf', site_stats_lang_conf);
	$main_smarty->assign('site_stats_tpl_path', site_stats_tpl_path);
}
?>
