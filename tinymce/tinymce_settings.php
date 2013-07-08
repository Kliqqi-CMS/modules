<?php

// the path to the module. the probably shouldn't be changed unless you rename the tinymce folder(s)
define('tinymce_path', my_pligg_base . '/modules/tinymce/');
// the path to the modules templates. 
define('tinymce_tpl_path', '../modules/tinymce/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('tinymce_path', tinymce_path);
	$main_smarty->assign('tinymce_tpl_path', tinymce_tpl_path);
}

?>
