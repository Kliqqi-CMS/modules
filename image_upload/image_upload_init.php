<?php

include_once('image_upload_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and shakeit.php becomes 'shakeit'
$include_in_pages = array('all');
$do_not_include_in_pages = array();

if( do_we_load_module() ) 
{		
	module_add_action('image_upload_process', 'image_upload_process_handler', '');
	module_add_action('image_upload_preview', 'image_upload_preview_handler', '');
	module_add_action('image_upload_form', 'image_upload_form_handler', '');

	// future use	
	# module_add_action('image_upload_delete', 'image_upload_delete_handler', '');
	
	include_once(mnmmodules . 'image_upload/image_upload_main.php');
}

?>