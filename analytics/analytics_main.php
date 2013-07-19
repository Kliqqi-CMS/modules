<?php

//
// Settings page
//
function analytics_showpage(){
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
			$analytics_input = substr($_REQUEST['analytics_id'], 0, 10);  // Shorten input to 10 characters (length of Analytics IDs)
			if (strlen($analytics_input) != '10'){
				$msg = "Error! The value entered was not 10 characters in length. Please try again.";
			}
			misc_data_update('analytics_id', mysql_real_escape_string($analytics_input));
		}
		
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		define('modulename', 'analytics');
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_analytics'); 
		$main_smarty->assign('pagename', pagename);
		
		$main_smarty->assign('msg', $msg); // Error messages
		$main_smarty->assign('settings', get_analytics_settings());
		$main_smarty->assign('tpl_center', analytics_tpl_path . 'settings');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

?>
