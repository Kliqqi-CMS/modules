<?php

// the path to the module. the probably shouldn't be changed unless you rename the age_verification folder(s)
define('age_verification_path', my_pligg_base . '/modules/age_verification/');

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
	
define('age_verification_lang_conf', lang_loc . '/modules/age_verification/lang.conf');
define('age_verification_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the age_verification folder(s)
define('age_verification_tpl_path', '../modules/age_verification/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the age_verification folder(s)
define('age_verification_lib_path', './modules/age_verification/libs/');

// the path to the images. the probably shouldn't be changed unless you rename the age_verification folder(s)
define('age_verification_img_path', './modules/age_verification/images/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('age_verification_path', age_verification_path);
	$main_smarty->assign('age_verification_lang_conf', age_verification_lang_conf);
	$main_smarty->assign('age_verification_pligg_lang_conf', age_verification_pligg_lang_conf);
	$main_smarty->assign('age_verification_tpl_path', age_verification_tpl_path);
	$main_smarty->assign('age_verification_lib_path', age_verification_lib_path);
	$main_smarty->assign('age_verification_img_path', age_verification_img_path);
}

?>
