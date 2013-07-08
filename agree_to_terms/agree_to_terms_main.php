<?php

function agree_to_terms_register(){

	global $main_smarty;

	if(isset($_REQUEST['agree']) && $_REQUEST['agree'] == 'agree'){$main_smarty->assign('register_agree_checked', true);}

	$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
	$register_step_1_extra .= $main_smarty->fetch(agree_to_terms_tpl_path . '/show_agree.tpl');
	$main_smarty->assign('register_step_1_extra', $register_step_1_extra);

}


function agree_to_terms_register_check_error(&$registration_details){

	global $main_smarty, $the_template;

	if(isset($_REQUEST['agree']) && $_REQUEST['agree'] == 'agree'){


	} else {

		$main_smarty->assign('register_agree_error', "You must agree to our terms.");
		$registration_details['error'] = true;

	}
}
?>
