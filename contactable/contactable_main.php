<?php

//
// Settings page
//
function contactable_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		if ($_POST['submit'])
		{
			$_REQUEST = str_replace('"',"'",$_REQUEST);
			$contactable_input = $_REQUEST['contactable_mail'];
			$result = filter_var( $contactable_input, FILTER_VALIDATE_EMAIL ); // Checking if the email is valid. Returns 'false' if not valid.
			
			if (!$result){
				// Email is not valid
				$msg = "Error! Your email address does not appear to be valid.";
			} else {
				// Add email address to database field
				misc_data_update('contactable_mail', mysql_real_escape_string($contactable_input));
			}
			
		}
		
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		define('modulename', 'contactable');
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_contactable'); 
		$main_smarty->assign('pagename', pagename);
		
		$main_smarty->assign('msg', $msg); // Error messages
		$main_smarty->assign('contactable', get_contactable_settings());
		$main_smarty->assign('tpl_center', contactable_tpl_path . 'settings');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

?>
