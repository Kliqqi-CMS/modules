<?php

// the path to the module. the probably shouldn't be changed unless you rename the digg_users folder(s)
define('digg_users_path', my_pligg_base . '/modules/digg_users/');
// the path to the module. the probably shouldn't be changed unless you rename the digg_users folder(s)
define('digg_users_lang_conf', '/modules/digg_users/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the digg_users folder(s)
define('digg_users_tpl_path', '../modules/digg_users/templates/');

// you will want to change the following
// digg submit rss url (<<username>> is where the username goes)
define('digg_users_digg_submit_url', 'http://www.digg.com/rss/<<username>>/index1.xml');
// digg vote rss url (<<username>> is where the username goes)
define('digg_users_digg_vote_url', 'http://www.digg.com/rss/<<username>>/index2.xml');
// category id to store submitted articles
define('digg_users_submit_category', '1');
// category id to store voted articles
define('digg_users_vote_category', '1');
// field in the digg rss for the link
define('digg_users_digg_url_field', 'link');
// field in the digg rss for the title
define('digg_users_digg_title_field', 'title');
// field in the digg rss for the description
define('digg_users_digg_description_field', 'description');
// number of hours to refresh submit feeds
define('digg_users_submit_feed_freq_hours', '1');
// number of hours to refresh vote feeds
define('digg_users_vote_feed_freq_hours', '1');
// number of votes to start with on submit feeds
define('digg_users_submit_feed_votes', '1');
// number of votes to start with on vote feeds
define('digg_users_vote_feed_votes', '1');
// number of items to load at a time in the submit load process
define('digg_users_submit_feed_item_limit', '10');
// number of items to load at a time in the vote load process
define('digg_users_vote_feed_item_limit', '10');

$users_extra_fields_field[]=array(
	'name' => 'digg_user_id',
	'show_to_user' => true,
	'show_to_user_text' => 'Digg User ID:',
	'show_to_user_text_2' => '<em>Your Digg User Name</em>',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true,
	);

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('digg_users_path', digg_users_path);
	$main_smarty->assign('digg_users_lang_conf', digg_users_lang_conf);
	$main_smarty->assign('digg_users_tpl_path', digg_users_tpl_path);
}

?>
