<?php
// the path to the module. the probably shouldn't be changed unless you rename the email_article folder(s)
define('email_article_path', my_pligg_base . '/modules/email_article/');

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

define('email_article_lang_conf', lang_loc . '/modules/email_article/lang.conf');
define('email_article_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the email_article folder(s)
define('email_article_tpl_path', '../modules/email_article/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('email_article_path', email_article_path);
	$main_smarty->assign('email_article_lang_conf', email_article_lang_conf);
	$main_smarty->assign('email_article_tpl_path', email_article_tpl_path);
}

?>