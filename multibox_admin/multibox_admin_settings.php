<?php

define('multibox_admin_path', my_pligg_base . '/modules/multibox_admin/');
define('multibox_admin_tpl_path', '../modules/multibox_admin/templates/');
define('URL_multibox_admin', 'module.php?module=multibox_admin');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('multibox_admin_path', multibox_admin_path);
	$main_smarty->assign('multibox_admin_lang_conf', multibox_admin_lang_conf);
	$main_smarty->assign('multibox_admin_tpl_path', multibox_admin_tpl_path);
	$main_smarty->assign('multibox_admin_doc_path', multibox_admin_doc_path);
	$main_smarty->assign('URL_multibox_admin', URL_multibox_admin);	
}

?>