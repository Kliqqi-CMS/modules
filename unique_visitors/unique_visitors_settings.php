<?php

define('unique_visitors_path', my_pligg_base . '/modules/unique_visitors/');
define('unique_visitors_tpl_path', '../modules/unique_visitors/templates/');

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
define('unique_visitors_lang_conf', lang_loc . '/modules/unique_visitors/lang.conf');
define('unique_visitors_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

if(is_object($main_smarty)){
	$main_smarty->assign('unique_visitors_path', unique_visitors_path);
	$main_smarty->assign('unique_visitors_lang_conf', unique_visitors_lang_conf);
	$main_smarty->assign('unique_visitors_tpl_path', unique_visitors_tpl_path);
}

?>
