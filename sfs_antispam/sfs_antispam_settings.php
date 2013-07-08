<?php

// the path to the module. the probably shouldn't be changed unless you rename the sfs_antispam folder(s)
define('sfs_antispam_path', my_pligg_base . '/modules/sfs_antispam/');
// the path to the module. the probably shouldn't be changed unless you rename the sfs_antispam folder(s)
define('sfs_antispam_lang_conf', '/modules/sfs_antispam/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the sfs_antispam folder(s)
define('sfs_antispam_tpl_path', '../modules/sfs_antispam/templates/');
// the path for smarty / template lite plugins
define('sfs_antispam_plugins_path', 'modules/sfs_antispam/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sfs_antispam_path', sfs_antispam_path);
	$main_smarty->assign('sfs_antispam_lang_conf', sfs_antispam_lang_conf);
	$main_smarty->assign('sfs_antispam_tpl_path', sfs_antispam_tpl_path);
}

?>
