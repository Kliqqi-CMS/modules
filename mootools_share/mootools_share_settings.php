<?php
// the path to the module. the probably shouldn't be changed unless you rename the mootools_share folder(s)
define('mootools_share_path', my_pligg_base . '/modules/mootools_share/');
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
define('mootools_share_lang_conf', lang_loc . '/modules/mootools_share/lang.conf');
define('mootools_share_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the mootools_share folder(s)
define('mootools_share_tpl_path', '../modules/mootools_share/templates/');

if(is_object($main_smarty)){
	$main_smarty->assign('mootools_share_path', mootools_share_path);
	$main_smarty->assign('mootools_share_lang_conf', mootools_share_lang_conf);
	$main_smarty->assign('mootools_share_pligg_lang_conf', mootools_share_pligg_lang_conf);
	$main_smarty->assign('mootools_share_tpl_path', mootools_share_tpl_path);
}

?>
