<?php

// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('embed_videos_path', my_pligg_base . '/modules/embed_videos/');
// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('embed_videos_lang_conf', '/modules/embed_videos/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('embed_videos_tpl_path', '../modules/embed_videos/templates/');
// the path for smarty / template lite plugins
define('embed_videos_plugins_path', 'modules/embed_videos/plugins');


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('embed_videos_path', embed_videos_path);
	$main_smarty->assign('embed_videos_lang_conf', embed_videos_lang_conf);
	$main_smarty->assign('embed_videos_tpl_path', embed_videos_tpl_path);
}

?>