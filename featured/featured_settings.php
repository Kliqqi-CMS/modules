<?php
define('featured_path', my_pligg_base . '/modules/featured/');

if(!defined('lang_loc')){
	$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
	$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
	if ($path == "/"){$path = "";}
	
	if($path != my_pligg_base){
		define('lang_loc', '..');
	} else {
		define('lang_loc', '.');
	}
}
define('featured_lang_conf', lang_loc . '/modules/featured/lang.conf');
define('featured_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

define('featured_tpl_path', '../modules/featured/templates/');
define('featured_URL', 'module.php?module=featured');

if(is_object($main_smarty)) {
	$main_smarty->assign('featured_path', featured_path);
	$main_smarty->assign('featured_phpthumb', featured_phpthumb);
	$main_smarty->assign('featured_lang_conf', featured_lang_conf);
	$main_smarty->assign('featured_pligg_lang_conf', featured_pligg_lang_conf);
   	$main_smarty->assign('featured_tpl_path', featured_tpl_path);
	$main_smarty->assign('featured_URL', featured_URL);
}
?>