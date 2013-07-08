<?php

// the path to the module. the probably shouldn't be changed unless you rename the random_story folder(s)
define('random_story_path', my_pligg_base . '/modules/random_story/');

// the path to the module. the probably shouldn't be changed unless you rename the random_story folder(s)
define('random_story_lang_conf', '/modules/random_story/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the random_story folder(s)
define('random_story_tpl_path', '../modules/random_story/templates/');



// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('random_story_path', random_story_path);
	$main_smarty->assign('random_story_lang_conf', random_story_lang_conf);
	$main_smarty->assign('random_story_tpl_path', random_story_tpl_path);
}

?>