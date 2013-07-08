<?php

// the path to the module. the probably shouldn't be changed unless you rename the addthis folder(s)
define('addthis_path', my_pligg_base . '/modules/addthis/');
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
define('addthis_lang_conf', lang_loc . '/modules/addthis/lang.conf');
define('addthis_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the addthis folder(s)
define('addthis_tpl_path', '../modules/addthis/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('addthis_path', addthis_path);
	$main_smarty->assign('addthis_lang_conf', addthis_lang_conf);
	$main_smarty->assign('addthis_tpl_path', addthis_tpl_path);
}

?>
