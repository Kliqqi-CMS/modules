<?php
define('angular_js_path', my_pligg_base . '/modules/angular_js/');
define('angular_js_tpl_path', '../modules/angular_js/templates/');
define('angular_js_plugins_path', 'modules/angular_js/plugins');
if(is_object($main_smarty)){
	$main_smarty->assign('angular_js_path', angular_js_path);
	$main_smarty->assign('angular_js_lang_conf', angular_js_lang_conf);
	$main_smarty->assign('angular_js_tpl_path', angular_js_tpl_path);
}

?>
