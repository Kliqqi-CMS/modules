<?php

// the path to the module. the probably shouldn't be changed unless you rename the snapcasa_link_thumbnails folder(s)
define('snapcasa_link_thumbnails_path', my_pligg_base . '/modules/snapcasa_link_thumbnails/');

// the path to the modules templates. the probably shouldn't be changed unless you rename the snapcasa_link_thumbnails folder(s)
define('snapcasa_link_thumbnails_tpl_path', '../modules/snapcasa_link_thumbnails/templates/');

// don't touch anything past this line.
if(is_object($main_smarty)){
	$main_smarty->assign('snapcasa_link_thumbnails_path', snapcasa_link_thumbnails_path);
	$main_smarty->assign('snapcasa_link_thumbnails_tpl_path', snapcasa_link_thumbnails_tpl_path);
}

?>
