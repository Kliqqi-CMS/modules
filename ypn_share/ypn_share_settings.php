<?php

// the path to the module. the probably shouldn't be changed unless you rename the ypn_share folder(s)
define('ypn_share_path', my_pligg_base . '/modules/ypn_share/');
// the path to the module. the probably shouldn't be changed unless you rename the ypn_share folder(s)
define('ypn_share_lang_conf', '/modules/ypn_share/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the ypn_share folder(s)
define('ypn_share_tpl_path', '../modules/ypn_share/templates/');
// the path for smarty / template lite plugins
define('ypn_share_plugins_path', '../modules/ypn_share/plugins');

$users_extra_fields_field[]=array(
	'name' => 'ypn_id',
	'show_to_user' => true,
	'show_to_user_text' => 'Yahoo Publishers ID:',
	'show_to_user_text_2' => '<em>YPN 10 digit ID</em>',
	'show_to_admin' => false,
	'editby_user' => true,
	'editby_admin' => true,
	);


$users_extra_fields_field[]=array(
	'name' => 'ypn_channel',
	'show_to_user_text' => 'ad section (optional):',
	'show_to_user_text_2' => '<em>numerical value</em>',
	'show_to_user' => true,
	'show_to_admin' => false,
	'editby_user' => true,
	'editby_admin' => true,
	);

$users_extra_fields_field[]=array(
	'name' => 'ypn_percent',
	'show_to_admin_text' => 'YPN Revenue Share %: ',
	'show_to_user' => false,
	'show_to_admin' => true,
	'editby_user' => false,
	'editby_admin' => true,
	);


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('ypn_share_path', ypn_share_path);
	$main_smarty->assign('ypn_share_lang_conf', ypn_share_lang_conf);
	$main_smarty->assign('ypn_share_tpl_path', ypn_share_tpl_path);
}

?>