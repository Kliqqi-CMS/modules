<?php

// the path to the module. the probably shouldn't be changed unless you rename the agree_to_terms folder(s)
define('agree_to_terms_path', my_pligg_base . '/modules/agree_to_terms/');

// the path to the module. the probably shouldn't be changed unless you rename the agree_to_terms folder(s)
define('agree_to_terms_lang_conf', '/modules/agree_to_terms/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the agree_to_terms folder(s)
define('agree_to_terms_tpl_path', '../modules/agree_to_terms/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the agree_to_terms folder(s)
define('agree_to_terms_lib_path', './modules/agree_to_terms/libs/');

// the path to the images. the probably shouldn't be changed unless you rename the agree_to_terms folder(s)
define('agree_to_terms_img_path', './modules/agree_to_terms/images/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('agree_to_terms_path', agree_to_terms_path);
	$main_smarty->assign('agree_to_terms_lang_conf', agree_to_terms_lang_conf);
	$main_smarty->assign('agree_to_terms_tpl_path', agree_to_terms_tpl_path);
	$main_smarty->assign('agree_to_terms_lib_path', agree_to_terms_lib_path);
	$main_smarty->assign('agree_to_terms_img_path', agree_to_terms_img_path);
}

?>
