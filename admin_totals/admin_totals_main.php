<?php


function admin_totals_showpage(){
	global $main_smarty, $the_template, $db;

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{
		define('pagename', 'admin_totals'); 
		$main_smarty->assign('pagename', pagename);

		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');

		$main_smarty->display(admin_totals_tpl_path . '/blank.tpl');
		
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Admin_Totals_BreadCrumb');
		$navwhere['link2'] = URL_admin_totals;

		$navwhere['text3'] = '';
		$navwhere['link3'] = '';
		$navwhere['text4'] = '';
		$navwhere['link4'] = '';


		$main_smarty = do_sidebar($main_smarty);

		$sql = "SELECT * FROM " . table_totals;
		$results = $db->get_results($sql);
		$main_smarty->assign('results', object_2_array($results));

		if(isset($_REQUEST['action'])){
			$main_smarty->assign('action', $_REQUEST['action']);
			totals_regenerate();
			$sql = "SELECT * FROM " . table_totals;
			$results = $db->get_results($sql);
			$main_smarty->assign('new_results', object_2_array($results));
			
		}


		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		$main_smarty->assign('tpl_center', admin_totals_tpl_path . 'admin_totals_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	} else {
		echo "not for you.";
	}
}
?>