<?php
function close_comments_register(&$vars){
	global $main_smarty, $the_template, $cc_registered;

	if ($cc_registered) return;
	$cc_registered = true;

	// smarty prefilter
	$main_smarty->register_prefilter('close_comments');
	$main_smarty->register_prefilter('close_anonymous_comments');
}

// prefilter routine
function close_comments($tpl_source, &$smarty)
{	
	// Logged in users
	return preg_replace('/(\{checkActionsTpl\s+location="tpl_pligg_story_comments_form_start"\})(.+)(\{checkActionsTpl\s+location="tpl_pligg_story_comments_form_end"\})/is', '$1{if $comments_active}$2{/if}$3', $tpl_source);
}

function close_anonymous_comments($tpl_source, &$smarty)
{
	// Anonymous comment form and users who aren't logged in.
	return preg_replace('/(\{checkActionsTpl\s+location="anonymous_comment_form_start"\})(.+)(\{checkActionsTpl\s+location="anonymous_comment_form_end"\})/is', '$1{if $comments_active}$2{/if}$3', $tpl_source);
}


//
// Settings page
//
function close_comments_showpage(){
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
			$close_comment_method = trim($_REQUEST['close_comment_method']);
			$close_comment_time = trim($_REQUEST['close_comment_time']);
			
			if ($close_comment_method == 'time'){
				misc_data_update('close_comment_method', mysql_real_escape_string($close_comment_method));
			} elseif ($close_comment_method == 'manual'){
				misc_data_update('close_comment_method', mysql_real_escape_string($close_comment_method));
			} elseif ($close_comment_method == 'both'){
				misc_data_update('close_comment_method', mysql_real_escape_string($close_comment_method));
			} else {
				$main_smarty->assign('module_error', "Method POST data did not contain an expected value");
			}
			
			if (is_numeric($close_comment_time)){
				misc_data_update('close_comment_time', mysql_real_escape_string($close_comment_time));
			} else {
				$main_smarty->assign('module_error', "Time POST data did not contain a numerical value. Please give the second field a value of 0 or higher.");
			}
			
		}
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'close_comments'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'close_comments_settings'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_close_comments_settings());
		$main_smarty->assign('tpl_center', close_comments_tpl_path . 'close_comments_settings');
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
function get_close_comments_settings()
{
    return array(
		'method' => get_misc_data('close_comment_method'), 
		'time' => get_misc_data('close_comment_time')
	);
}

?>