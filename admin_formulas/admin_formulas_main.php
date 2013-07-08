<?php

function admin_formulas_showpage(){
	global $main_smarty, $the_template, $db;

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{

		$main_smarty = do_sidebar($main_smarty);

		if($_REQUEST['type'] == "report"){

			include_once(mnminclude.'link.php');
			$linkres = new Link();
			if($linkres->return_formula_system_version() != 0.2){
				$msg = "This module not compatible with your version of Pligg.<br />";
				$msg .= "This module is for 'report formula system' ver 0.1 and your Pligg has 'report formula system' ver " . $linkres->return_formula_system_version();
				$main_smarty->assign('formula_message', $msg);
				$main_smarty->assign('tpl_center', admin_formulas_tpl_path . '/blank');
				$main_smarty->display($the_template . '/pligg.tpl');
				return;
			}
		}
			
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		
		$main_smarty->display(admin_formulas_tpl_path . '/blank.tpl');

		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Admin_Formulas_BreadCrumb_Modify');
		$navwhere['link2'] = URL_admin_formulas;

		if($_REQUEST['action'] == "eipsave"){
			//print_r($_REQUEST);
			//eip_editformula_1_formula

			$var_id = $_REQUEST["var_id"];
			$var_value = stripslashes($_REQUEST["var_value"]);
			
			$values = explode('_', $var_id);
			if($values[1] == 'editformula'){
				$sql = "Update `" . table_formulas . "` set `" . $values[3] . "` = '". $var_value ."' where `id` = " . $values[2] . ";";
				$db->query($sql);
				echo $var_value;
			}
		
		
			die();
		}
		
		if($_REQUEST['type'] != ""){
			if($_REQUEST['type'] == "report"){
				$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Admin_Formulas_BreadCrumb_Reporting');
				$navwhere['link3'] = URL_admin_formulas . '&type=report';
			}
			
			if($_REQUEST['action'] == "eval_formula"){
				if(isset($_REQUEST['id'])){
					$sql = "Select * from `" . table_formulas . "` where `id` = " . $_REQUEST['id'] . ";";
				} else {
					$sql = "Select * from `" . table_formulas . "` where `enabled` = 1 and `type` = '" . $_REQUEST['type'] . "';";
				}
				$results = $db->get_results($sql);

				$votes = $_REQUEST['votes'];
				$reports = $_REQUEST['reports'];
				$hours_since_submit = $_REQUEST['hours_since_submit'];

				$doit = FALSE;
				foreach($results as $result){
					$formula = $result->formula;

					$evalthis = 'if (' . $formula . '){return "1";}else{return "0";}';
					if(eval($evalthis) == 1){
						$doit = TRUE;
					}
				}

				if($doit == TRUE){
					echo '<font color=green>TRUE</font> - The story would be moved back to DISCARD.';
				} else {
					echo '<font color=red>FALSE</font> - The story will not be moved.';
				}

				die();
			}

			
			if($_REQUEST['action'] == "edit_formula"){
				$sql = mysql_query("Select * from `" . table_formulas . "` where `id` = " . $_REQUEST['id'] . ";");
				$the_formula = array();
				while ($rows = mysql_fetch_array ($sql, MYSQL_ASSOC)) array_push ($the_formula, $rows);

				$main_smarty->assign('the_formula', $the_formula);
			}

			if($_REQUEST['action'] == "delete_formula"){
				$sql = mysql_query("delete from `" . table_formulas . "` where `id` = " . $_REQUEST['id'] . ";");
				$db->query($sql);			

				$redirect = URL_admin_formulas . "&type=" . $_REQUEST['type'];
				header('Location: ' . $redirect);
			}

			if($_REQUEST['action'] == "new_formula"){
				$sql = "Insert into `" . table_formulas . "` (`title`, `type`) values ('new formula', 'report');";
				$db->query($sql);
				
				$redirect = URL_admin_formulas . "&type=" . $_REQUEST['type'];
				header('Location: ' . $redirect);
			}
			
			if($_REQUEST['action'] == "disable_formula"){
				$sql = "Update `" . table_formulas . "` set `enabled` = 0 where `id` = " . $_REQUEST['id'] . ";";
				$db->query($sql);
				
				$redirect = URL_admin_formulas . "&type=" . $_REQUEST['type'];
				header('Location: ' . $redirect);
			}
			
			if($_REQUEST['action'] == "enable_formula"){
				$sql = "Update `" . table_formulas . "` set `enabled` = 1 where `id` = " . $_REQUEST['id'] . ";";
				$db->query($sql);
				
				$redirect = URL_admin_formulas . "&type=" . $_REQUEST['type'];
				header('Location: ' . $redirect);
			}

			//rename these vars
			$categories = mysql_query("Select * from `" . table_formulas . "` where `type` = 'report';");
			$categorylist = array();
			while ($rows = mysql_fetch_array ($categories, MYSQL_ASSOC)) array_push ($categorylist, $rows);
			$main_smarty->assign('formulas', $categorylist);

			$eipHtml = rawurlencode('eip_editformula_' . $_REQUEST['id'] . '_title');
			$editinplace_init .= "EditInPlaceAF.makeEditable({ id: '".$eipHtml."', on_blur: 'cancel'});";
			
			$eipHtml = rawurlencode('eip_editformula_' . $_REQUEST['id'] . '_formula');
			$editinplace_init .= "EditInPlaceAF.makeEditable({ id: '".$eipHtml."', on_blur: 'cancel'});";

			$main_smarty->assign('editinplace_init_formulas', $editinplace_init);	
		}
		
		define('pagename', 'admin_formulas'); 
	    $main_smarty->assign('pagename', pagename);
		
		// Method for identifying modules rather than pagename
		define('modulename', 'admin_formulas'); 
		$main_smarty->assign('modulename', modulename);
	   
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		$main_smarty->assign('tpl_center', admin_formulas_tpl_path . 'admin_formulas_main');
		$main_smarty->display($the_template . '/pligg.tpl');
	} else {
		echo "not for you.";
	}
}
?>