<?php

// the path to the module. the probably shouldn't be changed unless you rename the video_plus folder(s)
define('video_plus_path', my_pligg_base . '/modules/video_plus/');
// the path to the module. the probably shouldn't be changed unless you rename the video_plus folder(s)
define('video_plus_lang_conf', '/modules/video_plus/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the video_plus folder(s)
define('video_plus_tpl_path', '../modules/video_plus/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('video_plus_path', video_plus_path);
	$main_smarty->assign('video_plus_tpl_path', video_plus_tpl_path);
}

?>
