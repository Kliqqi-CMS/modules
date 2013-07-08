<?php
define('jquery_ui_path', my_pligg_base . '/modules/jquery_ui/');
define('jquery_ui_tpl_path', '../modules/jquery_ui/templates/');
define('jquery_ui_plugins_path', 'modules/jquery_ui/plugins');
if(is_object($main_smarty)){
	$main_smarty->assign('jquery_ui_path', jquery_ui_path);
	$main_smarty->assign('jquery_ui_lang_conf', jquery_ui_lang_conf);
	$main_smarty->assign('jquery_ui_tpl_path', jquery_ui_tpl_path);
}

?>
