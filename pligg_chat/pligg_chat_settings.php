<?php

// the path to the module. the probably shouldn't be changed unless you rename the pligg_chat folder(s)
define('pligg_chat_path', my_pligg_base . '/modules/pligg_chat/');
// the path to the modules templates. the probably shouldn't be changed unless you rename the pligg_chat folder(s)
define('pligg_chat_tpl_path', '../modules/pligg_chat/templates/');
// the path for smarty / template lite plugins
define('pligg_chat_plugins_path', 'modules/pligg_chat/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('pligg_chat_path', pligg_chat_path);
	$main_smarty->assign('pligg_chat_tpl_path', pligg_chat_tpl_path);
}

?>
