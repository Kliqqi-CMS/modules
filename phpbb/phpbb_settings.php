<?php
// the path to the module. the probably shouldn't be changed unless you rename the phpbb folder(s)
define('phpbb_path', my_pligg_base . '/modules/phpbb/');

// the path to the module. the probably shouldn't be changed unless you rename the phpbb folder(s)
define('phpbb_lang_conf', '/modules/phpbb/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the phpbb folder(s)
define('phpbb_tpl_path', '../modules/phpbb/templates/');

// the language path for the module
/*	if(!defined('lang_loc')){
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
*/
//define('phpbb_lang_conf', '/modules/phpbb/lang.conf');
//define('phpbb_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the phpbb folder(s)
//define('phpbb_tpl_path', '../modules/phpbb/templates/');

$phpbb_groups = array(
array(1,"Guests"),
array(2,"Registered users"),
array(3,"Registered COPPA users"),
array(4,"Global moderators"),
array(5,"Administrators"),
array(6,"Bots")
);



// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('phpbb_path', phpbb_path);
	$main_smarty->assign('phpbb_pligg_lang_conf', phpbb_pligg_lang_conf);
	$main_smarty->assign('phpbb_lang_conf', phpbb_lang_conf);
	$main_smarty->assign('phpbb_tpl_path', phpbb_tpl_path);
	$main_smarty->assign('phpbb_groups', $phpbb_groups);
}

?>
