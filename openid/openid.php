<?php
require_once('class.openid.php');


// EXAMPLE
if ($_POST['openid_action'] == "login"){ // Get identity from user and redirect browser to OpenID Server
    $openid = new SimpleOpenID;
    $openid->SetIdentity($_POST['openid_url']);
    $openid->SetTrustRoot(openid_TrustRoot);
    $openid->SetRequiredFields(array('email','fullname'));
    //$openid->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
    if ($openid->GetOpenIDServer()){
        $openid->SetApprovedURL(my_base_url . my_pligg_base . '/module.php?module=openid');      // Send Response from OpenID server to this script
        $openid->Redirect();     // This will redirect user to OpenID Server
    }else{
        $error = $openid->GetError();
        echo "ERROR CODE: " . $error['code'] . "<br>";
        echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
    }
    exit;
}
else if($_GET['openid_mode'] == 'id_res'){     // Perform HTTP Request to OpenID server to validate key

    $openid = new SimpleOpenID;
    $openid->SetIdentity($_GET['openid_identity']);
    $openid_validation_result = $openid->ValidateWithServer();
    if ($openid_validation_result == true){         // OK HERE KEY IS VALID


			global $db, $current_user, $main_smarty, $the_template;
		
			$sql = "Select user_login, user_pass from `".table_users."` where openid_url = '" .$_GET['openid_identity']. "';";
			$login = $db->get_row($sql);
			if(!$login){
				$main_smarty->assign('tpl_center', openid_tpl_path . 'openid_login_error');
				$main_smarty->display($the_template . '/pligg.tpl');
				die();
			} else {
				$user_login = $login->user_login;
				$user_pass = $login->user_pass;
			}
	
		
			if($current_user->Authenticate($user_login, '', $persistent, $user_pass) == false) {
				die($main_smarty->get_config_vars('PLIGG_Visual_Login_Error'));
			} else {
				if(strlen($_REQUEST['return']) > 1) {
					$return = $_REQUEST['return'];
				} else {
					$return =  my_pligg_base.'/';
				}
				
				define('logindetails', $username . ";" . $password . ";" . $return);
				
				check_actions('login_success_pre_redirect');
		
				header('Location: '.$return);
			}


    }else if($openid->IsError() == true){            // ON THE WAY, WE GOT SOME ERROR
        $error = $openid->GetError();
        echo "ERROR CODE: " . $error['code'] . "<br>";
        echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
    }else{                                            // Signature Verification Failed
        echo "INVALID AUTHORIZATION";
    }
    
    die();
    
}else if ($_GET['openid_mode'] == 'cancel'){ // User Canceled your Request
    echo "USER CANCELED REQUEST";
}






	global $main_smarty, $the_template;

	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'ts.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);


	$main_smarty->assign('tpl_center', openid_tpl_path . 'openid_login');
	$main_smarty->display($the_template . '/pligg.tpl');



?>
