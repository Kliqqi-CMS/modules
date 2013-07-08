<?php
// the path to the module. the probably shouldn't be changed unless you rename the pligg_update folder(s)
define('pligg_update_path', my_pligg_base . '/modules/pligg_update/');
// the language path for the module
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
define('pligg_update_lang_conf', lang_loc . '/modules/pligg_update/lang.conf');
define('pligg_update_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");
// the path to the modules templates. the probably shouldn't be changed unless you rename the pligg_update folder(s)
define('pligg_update_tpl_path', '../modules/pligg_update/templates/');
// the path for smarty / template lite plugins
define('pligg_update_plugins_path', 'modules/pligg_update/plugins');

// don't touch anything past this line.
if(is_object($main_smarty)){
	$main_smarty->assign('pligg_update_path', pligg_update_path);
	$main_smarty->assign('pligg_update_lang_conf', pligg_update_lang_conf);
	$main_smarty->assign('pligg_update_pligg_lang_conf', pligg_update_pligg_lang_conf);
	$main_smarty->assign('pligg_update_tpl_path', pligg_update_tpl_path);
}
?>
