<?php
function pligg_web_toolbar_showpage(){
	global $main_smarty, $the_template, $db;

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{
		define('pagename', 'pligg_web_toolbar'); 
		$main_smarty->assign('pagename', pagename);
		
		// Method for identifying modules rather than pagename
		define('modulename', 'pligg_web_toolbar'); 
		$main_smarty->assign('modulename', modulename);

		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_pligg_web_toolbar_BreadCrumb');
		$navwhere['link2'] = URL_pligg_web_toolbar;

		$navwhere['text3'] = '';
		$navwhere['link3'] = '';
		$navwhere['text4'] = '';
		$navwhere['link4'] = '';

		if(isset($_REQUEST['action'])){$action = $_REQUEST['action'];}else{$action = '';}

		if($action == 'enable'){
			enable_pligg_web_toolbar();
		}

		if($action == 'disable'){
			disable_pligg_web_toolbar();
		}


		$main_smarty = do_sidebar($main_smarty);
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));	
		$main_smarty->assign('tpl_center', pligg_web_toolbar_tpl_path . 'pligg_web_toolbar_main');		

		$main_smarty->display($template_dir . '/admin/admin.tpl');
	} else {
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}

function enable_pligg_web_toolbar(){
	misc_data_update('pligg_web_toolbar', "enabled");
	header('Location: ' . URL_pligg_web_toolbar);
}

function disable_pligg_web_toolbar(){
	misc_data_update('pligg_web_toolbar', "disabled");
	header('Location: ' . URL_pligg_web_toolbar);
}

function pligg_web_toolbar_story(&$vars){
	if(pligg_web_toolbar == true){
		global $URLMethod, $my_base_url, $my_pligg_base, $main_smarty, $the_template, $link;
		if ($URLMethod==2) {
			$link->url = my_base_url.my_pligg_base."/toolbar/".$link->id;
		}else{
			$link->url = my_base_url.my_pligg_base."/modules/pligg_web_toolbar/toolbar.php?id=".$link->id;
		}
	}
}

?>