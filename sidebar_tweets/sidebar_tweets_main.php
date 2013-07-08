<?php

//
// Settings page
//

function sidebar_tweets_showpage(){
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
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('sidebar_tweets_id', sanitize($_REQUEST['sidebar_tweets_id'], 3));
			misc_data_update('sidebar_tweets_num', sanitize($_REQUEST['sidebar_tweets_num'], 3));
			$main_smarty->assign('error', $error);
		}
		// breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = "Sidebar Tweets";
		$navwhere['link2'] = my_pligg_base . "/module.php?module=sidebar_tweets";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		// breadcrumbs
		define('modulename', 'sidebar_tweets'); 
		$main_smarty->assign('modulename', modulename);

		$main_smarty->assign('settings', str_replace('"','&#034;',get_sidebar_tweets_settings()));
		$main_smarty->assign('tpl_center', sidebar_tweets_tpl_path . 'sidebar_tweets_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}

// 
// Read module settings
//
function get_sidebar_tweets_settings()
{
    return array(
		'sidebar_tweets_id' => get_misc_data('sidebar_tweets_id'), 
		'sidebar_tweets_num' => get_misc_data('sidebar_tweets_num')
		);
}


?>