<?php
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
define('pligg_web_toolbar_lang_conf', lang_loc . '/modules/pligg_web_toolbar/lang.conf');
define('pligg_web_toolbar_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// Path of folders used by module
define('pligg_web_toolbar_path', my_pligg_base . '/modules/pligg_web_toolbar/');
define('pligg_web_toolbar_tpl_path', '../modules/pligg_web_toolbar/templates/');
define('pligg_web_toolbar_img_path',  my_pligg_base . '/modules/pligg_web_toolbar/images/');
define('URL_pligg_web_toolbar', 'module.php?module=pligg_web_toolbar');
$pligg_web_toolbar_enabled = (get_misc_data('pligg_web_toolbar') == '') ? true : get_misc_data('pligg_web_toolbar');
$pligg_web_toolbar_enabled = ($pligg_web_toolbar_enabled == 'enabled') ? true : false;
define('pligg_web_toolbar_enabled', $pligg_web_toolbar_enabled);

// don't touch anything past this line.
if(is_object($main_smarty)){
	$main_smarty->assign('pligg_web_toolbar_path', pligg_web_toolbar_path);
	$main_smarty->assign('pligg_web_toolbar_lang_conf', pligg_web_toolbar_lang_conf);
	$main_smarty->assign('pligg_web_toolbar_pligg_lang_conf', pligg_web_toolbar_pligg_lang_conf);
	$main_smarty->assign('pligg_web_toolbar_tpl_path', pligg_web_toolbar_tpl_path);
	$main_smarty->assign('pligg_web_toolbar_img_path', pligg_web_toolbar_img_path);
	$main_smarty->assign('pligg_web_toolbar_enabled', pligg_web_toolbar_enabled);
	$main_smarty->assign('URL_pligg_web_toolbar', URL_pligg_web_toolbar);	
}
?>