<?php

function age_verification_register(){

	global $main_smarty;

	if(isset($_REQUEST['agree']) && $_REQUEST['agree'] == 'agree'){$main_smarty->assign('register_agree_checked', true);}

	$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
	$register_step_1_extra .= $main_smarty->fetch(age_verification_tpl_path . '/show_verification.tpl');
	$main_smarty->assign('register_step_1_extra', $register_step_1_extra);

}


function age_verification_register_check_error(&$registration_details){

	global $main_smarty, $the_template;

	if(isset($_REQUEST['agree']) && $_REQUEST['agree'] == 'agree'){


	} else {

		$main_smarty->assign('register_agree_error', "You must verify your age.");
		$registration_details['error'] = true;

	}
}
?>
