<?php

// the path to the module. the probably shouldn't be changed unless you rename the profanity_filter folder(s)
define('profanity_filter_path', my_pligg_base . '/modules/profanity_filter/');
// the path to the module. the probably shouldn't be changed unless you rename the profanity_filter folder(s)
define('profanity_filter_lang_conf', '/modules/profanity_filter/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the profanity_filter folder(s)
define('profanity_filter_tpl_path', '../modules/profanity_filter/templates/');
// the path for smarty / template lite plugins
define('profanity_filter_plugins_path', '../modules/profanity_filter/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('profanity_filter_path', profanity_filter_path);
	$main_smarty->assign('profanity_filter_lang_conf', profanity_filter_lang_conf);
	$main_smarty->assign('profanity_filter_tpl_path', profanity_filter_tpl_path);
}

?>
