<?php

// the path to the module. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('thickbox_path', my_pligg_base . '/modules/thickbox/');

// the path to the module. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('thickbox_lang_conf', '/modules/thickbox/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('thickbox_tpl_path', '../modules/thickbox/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('thickbox_path', thickbox_path);
	$main_smarty->assign('thickbox_lang_conf', thickbox_lang_conf);
	$main_smarty->assign('thickbox_tpl_path', thickbox_tpl_path);
}

?>