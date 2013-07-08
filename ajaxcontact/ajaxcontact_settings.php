<?php

// Configure the 3 lines below
define('ajaxcontact_youremail', 'user@example.com');
define('ajaxcontact_yourname', 'John Doe');
define('ajaxcontact_subject', 'Contact Form: ');

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

define('ajaxcontact_lang_conf', lang_loc . '/modules/ajaxcontact/lang.conf');
define('ajaxcontact_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// The path to the module
define('ajaxcontact_path', my_pligg_base . '/modules/ajaxcontact/');

// The path to the modules templates
define('ajaxcontact_tpl_path', '../modules/ajaxcontact/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('ajaxcontact_path', ajaxcontact_path);
	$main_smarty->assign('ajaxcontact_pligg_lang_conf', ajaxcontact_pligg_lang_conf);
	$main_smarty->assign('ajaxcontact_lang_conf', ajaxcontact_lang_conf);
	$main_smarty->assign('ajaxcontact_tpl_path', ajaxcontact_tpl_path);
	$main_smarty->assign('ajaxcontact_youremail', ajaxcontact_youremail);
	$main_smarty->assign('ajaxcontact_yourname', ajaxcontact_yourname);
	$main_smarty->assign('ajaxcontact_subject', ajaxcontact_subject);
}

?>