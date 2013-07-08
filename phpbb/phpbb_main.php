<?php
//
// Connect to phpBB database
//
function phpbb_connect()
{
	global $settings, $db, $phpbb_db;

	if ($settings['user'])
	{
		$dbname = strpos($settings['db'],'.') > 0 ? substr($settings['db'],0,strpos($settings['db'],'.')) : $settings['db'];
	 	$db1 = new ezSQL_mysql($settings['user'], $settings['pass'], $dbname, $settings['host']);
		$db1->show_errors = true;
		$db1->quick_connect($settings['user'], $settings['pass'], $dbname, $settings['host']);
		if(count($db1->captured_errors) > 0)
		{
			return null;
		}
		return $db1;
	} else
		return $db;
}

// 
// Read module settings
//
function get_settings()
{
    return array(
		'group_id' => get_misc_data('phpbb_group'), 
		'db' => get_misc_data('phpbb_db'),
		'user' => get_misc_data('phpbb_user'),
		'pass' => get_misc_data('phpbb_pass'),
		'host' => get_misc_data('phpbb_host'),
		'cookie_name' => get_misc_data('phpbb_cookie_name'),
		'cookie_path' => get_misc_data('phpbb_cookie_path'),
		'cookie_domain' => get_misc_data('phpbb_cookie_domain'),
		'cookie_secure' => get_misc_data('phpbb_cookie_secure')
		);
}

//
// Read from phpBB config table into an array
//
function get_phpbb_settings()
{
	global $db, $phpbb_settings, $phpbb_db, $settings;
	
	if (isset($phpbb_settings)) return $phpbb_settings;
	
	$bb_config = $phpbb_db->get_results("SELECT config_name, config_value FROM {$settings['db']}config WHERE config_name IN
									('default_dateformat',
									'board_timezone',
									'default_lang',
									'default_style')");
	foreach($bb_config as $obj) 
		$phpbb_settings[$obj->config_name] = $obj->config_value;

	return $phpbb_settings;
}

//
// Add new groups to phpbb DB
//
function phpbb_update_groups($user_id, $phpbb_groups)
{
	global $db, $phpbb_db, $settings;
	
	// delete not-exsisting groups
	$res = $phpbb_db->get_results($sql = "SELECT group_id FROM {$settings['db']}user_group WHERE user_id = '$user_id'");
	$existing = array();
  	if ($res)
	    foreach ($res as $q)
		$existing[] = $q->group_id;
	foreach (array_diff($existing, $phpbb_groups) as $i)
		$q = $phpbb_db->query("DELETE FROM {$settings['db']}user_group WHERE group_id = '$i' AND user_id = '$user_id'");

	// insert new groups
	if (!$phpbb_groups) return;
	foreach (array_diff($phpbb_groups, $existing) as $i)
		if ($i)
			$phpbb_db->query($sql = "INSERT INTO {$settings['db']}user_group (group_id, user_id, user_pending) VALUES ($i, $user_id, 0)");
}

//
// Return additional groups to add into phpBB as an array
//
function get_additional_groups($max)
{
	global $db;
	
	if (!is_array($max))
		$max = (array)$max;
	
	$ret = array();

	foreach ($max as $group_id)
	{
		if (!in_array($group_id, $ret))
			$ret[] = $group_id;
	}
	$ret = array_unique($ret);
	sort($ret);
	return $ret;
}

//
// Register new user in phpbb
//
function phpbb_register(&$registration_details)
{
	global $settings, $db, $phpbb_db;

	$settings = get_settings();
	if (!($phpbb_db = phpbb_connect())) return;

	$additional_groups = get_additional_groups($settings['group_id']);

	// Find unique username in phpBB
	$username = $registration_details['username'];
	$i = '';
	while ($phpbb_db->get_var($sql = "SELECT user_id FROM {$settings['db']}users WHERE username = '$username$i'"))	
	    $i++;
	$username = $db->escape($username.$i);
	$password = md5($registration_details['password']);
	$user_id = $db->get_var($sql = "SELECT user_phpbb FROM ".table_users." WHERE user_id = '{$registration_details['id']}'");
	
	$user_type = 0;
	$group_colour = $db->escape($phpbb_db->get_var($sql = "SELECT group_colour FROM {$settings['db']}groups WHERE group_id = '{$settings['group_id']}'"));
	
	$bb_config = get_phpbb_settings();
	
	if (!$user_id)  //user does not exists
	{
		$user_id = $phpbb_db->get_var($sql = "SELECT MAX(user_id) FROM {$settings['db']}users");
		
		$user_id++;
		$phpbb_db->query($sql = "INSERT INTO {$settings['db']}users
							(user_id,
							user_type,
							group_id,
							user_ip,
							user_regdate,
							username,
							username_clean,
							user_password,
							user_email,
							user_email_hash,
							user_timezone,
							user_style,
							user_lang,
							user_dateformat,
							user_colour
							)
						VALUES
							('$user_id',
							'$user_type',
							'{$settings['group_id']}',
							'{$_SERVER[REMOTE_ADDR]}',
							UNIX_TIMESTAMP(NOW()),
							'$username',
							'".strtolower($username)."',
							'$password',
							'{$registration_details['email']}',
							'".crc32(strtolower($registration_details['email'])).strlen($registration_details['email'])."',
							'$bb_config[board_timezone]',
							'$bb_config[default_style]',
							'$bb_config[default_lang]',
							'$bb_config[default_dateformat]',
							'$group_colour')
					");

		$phpbb_db->query("UPDATE {$settings['db']}config SET config_value = '$username' WHERE config_name = 'newest_username'");
		$phpbb_db->query("UPDATE {$settings['db']}config SET config_value = '$user_id' WHERE config_name = 'newest_user_id'");
		$phpbb_db->query("UPDATE {$settings['db']}config SET config_value = config_value + 1 WHERE config_name = 'num_users'");
		$phpbb_db->query("UPDATE {$settings['db']}config SET config_value = '$group_colour' WHERE config_name = 'newest_user_colour'");

		$db->query("UPDATE ".table_users." SET user_phpbb='$user_id' WHERE user_id='{$registration_details['id']}'");
	} else {
		if ($registration_details['password']) $setpass = "user_password = '$password',";

		$phpbb_db->query($sql = "UPDATE {$settings['db']}users SET
						user_type = '$user_type',
						group_id = '{$settings['group_id']}',
						$setpass
						user_email = '$registration_details[email]',
						user_email_hash = '".crc32(strtolower($registration_details[email])).strlen($registration_details[email])."',
						user_colour = '$group_colour'
						WHERE user_id = '$user_id'");
	}
	phpbb_update_groups($user_id, $additional_groups);

	// Login after registration
	global $username, $password, $persistent;
	$persistent = 0;
	phpbb_login();
}

//
// Settings page
//
function phpbb_showpage(){
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
			misc_data_update('phpbb_db', sanitize($_REQUEST['phpbb_db'], 3));
			misc_data_update('phpbb_user', sanitize($_REQUEST['phpbb_user'], 3));
			misc_data_update('phpbb_pass', sanitize($_REQUEST['phpbb_pass'], 3));
			misc_data_update('phpbb_host', sanitize($_REQUEST['phpbb_host'], 3));
			misc_data_update('phpbb_group', sanitize($_REQUEST['phpbb_group'], 3));
			misc_data_update('phpbb_cookie_name', sanitize($_REQUEST['cookie_name'], 3));
			misc_data_update('phpbb_cookie_path', sanitize($_REQUEST['cookie_path'], 3));
			misc_data_update('phpbb_cookie_domain', sanitize($_REQUEST['cookie_domain'], 3));
			misc_data_update('phpbb_cookie_secure', sanitize($_REQUEST['cookie_secure'], 3));
			header("Location: ".my_pligg_base."/module.php?module=phpbb");
			die();
		}
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify Snippet";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=phpbb";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'phpbb'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyphpbb'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_settings());
		$main_smarty->assign('tpl_center', phpbb_tpl_path . 'phpbb_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

//
// Save user changes from admin panel
//
function phpbb_admin_users_save(){
	global $userdata;

	$registration_details = array(
		"id" => $userdata->id,
		"username" => $_REQUEST['login'],
		"email" => $_REQUEST['email']);

	phpbb_register($registration_details);
}

//
// Save user changes from user profile
//
function phpbb_profile_save(){
	global $user, $db;

	if(!empty($_POST['newpassword']) || !empty($_POST['newpassword2'])) {
		$oldpass = sanitize($_POST['oldpassword'], 3);
		$userX=$db->get_row("SELECT user_id, user_pass, user_login FROM " . table_users . " WHERE user_login = '".$user->username."'");
		$saltedpass=generateHash($oldpass, substr($userX->user_pass, 0, SALT_LENGTH));
		if($userX->user_pass == $saltedpass){
			if(sanitize($_POST['newpassword'], 3) !== sanitize($_POST['newpassword2'], 3)) {
				return;
			}
		} else {
			return;
		}
	}
	$registration_details = array(
		"id" => $user->id,
		"username" => $user->username,
		"password" => $_POST['newpassword'] ? sanitize($_POST['newpassword'], 3) : $user->pass,
		"email" => $user->email);

	phpbb_register($registration_details);
}

//
// Auto-Login to phpBB
//
function phpbb_login()
{
	global $db, $settings, $phpbb_db, $username, $password, $persistent;

	$settings = get_settings();
	if (!($phpbb_db = phpbb_connect())) return;

	$phpbb_cookie_u = $settings['cookie_name'] ."_u";	  		
	$phpbb_cookie_sid = $settings['cookie_name'] ."_sid";		
	$phpbb_cookie_path = $settings['cookie_path'] == '' ? '/' : $settings['cookie_path'];	
	$phpbb_cookie_domain = $settings['cookie_domain'];		   
	$phpbb_cookie_secure = $settings['cookie_secure'];		   

//	if (!($phpbb_user_id = phpbb_get_userid($username,$password))) return;
	
	$q = $phpbb_db->get_results($sql = "SELECT * FROM {$settings['db']}banlist WHERE ban_userid = '$phpbb_user_id'");
	if ($q)	return;

	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$session_id = md5(uniqid($ip_addr));
	$session_time = time();
	$session_browser = $db->escape($_SERVER['HTTP_USER_AGENT']);
	$session_admin = '0';

	$phpbb_db->query("DELETE FROM {$settings['db']}sessions WHERE session_user_id = '$phpbb_user_id'");
	$phpbb_db->query($sql = "INSERT INTO {$settings['db']}sessions (session_id, session_user_id, session_start, session_time, session_ip, session_browser, session_page, session_admin)
		VALUES ('$session_id', '$phpbb_user_id', '$session_time', '$session_time', '$ip_addr', '$session_browser', 'index.php', $session_admin)");
	
	if($persistent) $time = time() + 3600000; 
	else $time = 0;
	setcookie($phpbb_cookie_u, $phpbb_user_id, $time, $phpbb_cookie_path, $phpbb_cookie_domain, $phpbb_cookie_secure);
	setcookie($phpbb_cookie_sid, $session_id, $time, $phpbb_cookie_path, $phpbb_cookie_domain, $phpbb_cookie_secure);
}

//
// Logout from phpBB
//
function phpbb_logout()
{  
	global $db, $settings, $phpbb_db;

	$settings = get_settings();
	if (!($phpbb_db = phpbb_connect())) return;

	$phpbb_cookie_u = $settings['cookie_name'] ."_u";	  		
	$phpbb_cookie_sid = $settings['cookie_name'] ."_sid";		
	$phpbb_cookie_path = $settings['cookie_path'] == '' ? '/' : $settings['cookie_path'];	
	$phpbb_cookie_domain = $settings['cookie_domain'];		   
	$phpbb_cookie_secure = $settings['cookie_secure'];		   
	if (!($phpbb_session_id = $db->escape($_COOKIE[$phpbb_cookie_sid]))) return;
	
	$q = $phpbb_db->get_results("SELECT * FROM {$settings['db']}sessions WHERE session_id = '$phpbb_session_id'");
	if ($q)
	{
		$phpbb_session = $q[0];
		$session_user_id = intval($phpbb_session->session_user_id);
		// Remove session record in phpBB
		$phpbb_db->query("DELETE FROM {$settings['db']}sessions WHERE 
						session_id = '{$phpbb_session->session_id}'
						AND session_user_id = '$session_user_id'");
	}
	setcookie($phpbb_cookie_u , '', time() - 3600 * 26, $phpbb_cookie_path, $phpbb_cookie_domain, $phpbb_cookie_secure);
	setcookie($phpbb_cookie_sid , '', time() - 3600 * 26, $phpbb_cookie_path, $phpbb_cookie_domain, $phpbb_cookie_secure);
}

/*
function phpbb_get_userid($username,$password)
{
	global $db, $phpbb_db, $settings;

	$user_login = $db->escape($username);
	$user_pass  = $db->escape($password);
	$phpbb_user_q = $phpbb_db->get_results($sql = "SELECT * FROM {$settings['db']}users WHERE username = '$user_login' LIMIT 1");
	if (!$phpbb_user_q) return;

	$phpbb_user = $phpbb_user_q[0];
	if ($phpbb_user->user_password == $password ||
		$phpbb_user->user_password == md5($password) ||
		phpbb_hash_crypt($password, $phpbb_user->user_password) === $phpbb_user->user_password)
		return intval($phpbb_user->user_id);
	else 
		return;
}

function phpbb_hash_crypt($password, $setting)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$output = '*';
	if (substr($setting, 0, 3) != '$H$')
		return $output;

	$count_log2 = strpos($itoa64, $setting[3]);
	if ($count_log2 < 7 || $count_log2 > 30)
		return $output;

	$count = 1 << $count_log2;
	$salt = substr($setting, 4, 8);
	if (strlen($salt) != 8)
		return $output;

	if (PHP_VERSION >= 5)
	{
		$hash = md5($salt . $password, true);
		do
			$hash = md5($hash . $password, true);
		while (--$count);
	}
	else
	{
		$hash = pack('H*', md5($salt . $password));
		do
			$hash = pack('H*', md5($hash . $password));
		while (--$count);
	}

	$output = substr($setting, 0, 12);
	$output .= phpbb_hash_encode64($hash, 16, $itoa64);
	return $output;
}

function phpbb_hash_encode64($input, $count, &$itoa64)
{
	$output = '';
	$i = 0;
	do
	{
		$value = ord($input[$i++]);
		$output .= $itoa64[$value & 0x3f];

		if ($i < $count)
			$value |= ord($input[$i]) << 8;

		$output .= $itoa64[($value >> 6) & 0x3f];
		if ($i++ >= $count)
			break;

		if ($i < $count)
			$value |= ord($input[$i]) << 16;

		$output .= $itoa64[($value >> 12) & 0x3f];
		if ($i++ >= $count)
			break;

		$output .= $itoa64[($value >> 18) & 0x3f];
	}
	while ($i < $count);

	return $output;
}	
*/
?>
