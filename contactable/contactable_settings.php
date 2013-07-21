<?php

// the path to the module. the probably shouldn't be changed unless you rename the contactable folder(s)
define('contactable_path', my_pligg_base . '/modules/contactable/');

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
define('contactable_lang_conf', lang_loc . '/modules/contactable/lang.conf');
define('contactable_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the contactable folder(s)
define('contactable_tpl_path', '../modules/contactable/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('contactable_path', contactable_path);
	$main_smarty->assign('contactable_lang_conf', contactable_lang_conf);
	$main_smarty->assign('contactable_tpl_path', contactable_tpl_path);
}

?>
