<?php
// the path to the module. the probably shouldn't be changed unless you rename the right_click_context folder(s)
define('right_click_context_path', my_pligg_base . '/modules/right_click_context/');

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

define('right_click_context_lang_conf', lang_loc . '/modules/right_click_context/lang.conf');
define('right_click_context_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the right_click_context folder(s)
define('right_click_context_tpl_path', '../modules/right_click_context/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('right_click_context_path', right_click_context_path);
	$main_smarty->assign('right_click_context_lang_conf', right_click_context_lang_conf);
	$main_smarty->assign('right_click_context_tpl_path', right_click_context_tpl_path);
}

?>