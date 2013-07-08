<?php
		
function comment_subscription_mail(&$vars)
{

	global $db,$main_smarty;
	$linkid = $vars['link_id'];
	$userid = $vars['user_id'];
	
	$user = new User;
	$user->id = $userid;
	$user->read();
	
	$link = new Link;
	$link->id=$linkid;
	$link->read();
	
	$author_email = $user->email;
	$username = $user->username;
	
	if(phpnum() == 4) {
		require_once(mnminclude.'class.phpmailer4.php');
	} else {
		require_once(mnminclude.'class.phpmailer5.php');
	}
	//$site_mail = $main_smarty->get_config_vars('PLIGG_Comment_mail_from');
	$from = "noreply@pligg.com";
	$str .= "A new comment has been posted on your story:<br/><a href='".my_base_url.my_pligg_base."/story.php?id=".$linkid."'>".$link->title."</a><br />";
	$str .= "<br />By <a href='".my_base_url.my_pligg_base."/user.php?login=".$username."'>".$username."</a><br />";
	$subject = "Recent Comment on Your Article";
	$to = $author_email;
	
	$message = $str;
	
	//echo $str.":".$to.":".$from.":".$subject;
	
	$mail = new PHPMailer();
	$mail->From = $site_mail;
	$mail->FromName = "Administrator";
	$mail->AddAddress($to);
	$mail->AddReplyTo($site_mail);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->Send();
}
function comment_subscription_insert(&$vars)
{
	$linkid = $vars['link_id'];
	global $db;
	$sql = "UPDATE " . table_links . " set comment_subscription = 1 where link_id = $linkid";
	$db->query($sql);
}
?>