<?php

include_once('snapcasa_link_thumbnails_settings.php');

$include_in_pages = array('all');
if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_pligg_head_end', snapcasa_link_thumbnails_tpl_path . 'thumbnails_head.tpl');
}

?>