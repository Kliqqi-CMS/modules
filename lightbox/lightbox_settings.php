<?php

// the path to the module. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('lightbox_path', my_pligg_base . '/modules/lightbox/');

// the path to the module. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('lightbox_lang_conf', '/modules/lightbox/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the lightbox folder(s)
define('lightbox_tpl_path', '../modules/lightbox/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('lightbox_path', lightbox_path);
	$main_smarty->assign('lightbox_lang_conf', lightbox_lang_conf);
	$main_smarty->assign('lightbox_tpl_path', lightbox_tpl_path);
}

?>