<?php

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

define('user_flags_path', my_pligg_base . '/modules/user_flags/');
define('user_flags_lang_conf', lang_loc . '/modules/user_flags/lang.conf');
define('user_flags_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");
define('user_flags_tpl_path', '../modules/user_flags/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('user_flags_path', user_flags_path);
	$main_smarty->assign('user_flags_lang_conf', user_flags_lang_conf);
	$main_smarty->assign('user_flags_tpl_path', user_flags_tpl_path);
}

?>
