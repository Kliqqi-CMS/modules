<?php

// the path to the module. the probably shouldn't be changed unless you rename the submit_antispam folder(s)
define('submit_antispam_path',  my_pligg_base .'/modules/submit_antispam/');
// the path to the module. the probably shouldn't be changed unless you rename the submit_antispam folder(s)
define('submit_antispam_lang_conf','modules/submit_antispam/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the submit_antispam folder(s)
define('submit_antispam_tpl_path','../modules/submit_antispam/templates');
// the path to the modules css the probably shouldn't be changed unless you rename the submit_antispam folder(s)
define('submit_antispam_css_path', my_pligg_base .'/modules/submit_antispam/css');
// the path to the modules images the probably shouldn't be changed unless you rename the submit_antispam folder(s)
define('submit_antispam_images_path', my_pligg_base .'/modules/submit_antispam/images');                                   
// the path to the modules js folder
define('submit_antispam_js_path', my_pligg_base .'/modules/submit_antispam/js');      

if(is_object($main_smarty)){
	$main_smarty->assign('submit_antispam_path', submit_antispam_path);
	$main_smarty->assign('submit_antispam_lang_conf', submit_antispam_lang_conf);
	$main_smarty->assign('submit_antispam_tpl_path', submit_antispam_tpl_path);
    $main_smarty->assign('submit_antispam_css_path', submit_antispam_css_path);
    $main_smarty->assign('submit_antispam_images_path', submit_antispam_images_path);
    $main_smarty->assign('submit_antispam_js_path', submit_antispam_js_path);
}

?>
