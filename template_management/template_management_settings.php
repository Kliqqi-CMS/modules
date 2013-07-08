<?php

// the path to the module. the probably shouldn't be changed unless you rename the template_management folder(s)
define('template_management_path', my_pligg_base . '/modules/template_management/');

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
define('template_management_lang_conf', lang_loc . '/modules/template_management/lang.conf');
define('template_management_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the template_management folder(s)
define('template_management_tpl_path', '../modules/template_management/templates/');

// the path to the modules images. the probably shouldn't be changed unless you rename the template_management folder(s)
define('template_management_image_path', my_pligg_base . '/modules/template_management/images/');

define('URL_template_management', my_pligg_base . '/module.php?module=template_management');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('template_management_path', template_management_path);
	$main_smarty->assign('template_management_lang_conf', template_management_lang_conf);
	$main_smarty->assign('template_management_pligg_lang_conf', template_management_pligg_lang_conf);
	$main_smarty->assign('template_management_tpl_path', template_management_tpl_path);
	$main_smarty->assign('template_management_image_path', template_management_image_path);
	$main_smarty->assign('URL_template_management', URL_template_management);	
}

?>
