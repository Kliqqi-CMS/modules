<?php

// the path to the module. the probably shouldn't be changed unless you rename the share_revenue folder(s)
define('openid_path', my_pligg_base . '/modules/openid/');
// the path to the module. the probably shouldn't be changed unless you rename the openid folder(s)
define('openid_lang_conf', '/modules/openid/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the openid folder(s)
define('openid_tpl_path', '../modules/openid/templates/');
// the path for smarty / template lite plugins
define('openid_plugins_path', 'modules/openid/plugins');

// the URL that will appear in the 'A site identifying as' section on the
// openid servers verification page
define('openid_TrustRoot', my_base_url . my_pligg_base);



$users_extra_fields_field[]=array(
	'name' => 'openid_url',
	'show_to_user' => true,
	'show_to_user_text' => 'openid_url:',
	'show_to_user_text_2' => '<em>http://you.myopenid.com/</em>',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true,
	);

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('openid_path', openid_path);
	$main_smarty->assign('openid_lang_conf', openid_lang_conf);
	$main_smarty->assign('openid_tpl_path', openid_tpl_path);
}

?>
