<?php

// the path to the module. the probably shouldn't be changed unless you rename the close_comments folder(s)
define('close_comments_path', my_pligg_base . '/modules/close_comments/');

// Language files
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
define('close_comments_lang_conf', '/modules/close_comments/lang.conf');
define('close_comments_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the close_comments folder(s)
define('close_comments_tpl_path', '../modules/close_comments/templates/');

define('close_comments_url', my_pligg_base . '/module.php?module=close_comments'); 

// Assign Smarty variables
if(is_object($main_smarty)){
	$main_smarty->assign('close_comments_path', close_comments_path);
	$main_smarty->assign('close_comments_lang_conf', close_comments_lang_conf);
	$main_smarty->assign('close_comments_tpl_path', close_comments_tpl_path);
	$main_smarty->assign('close_comments_url', close_comments_url);
}

?>
