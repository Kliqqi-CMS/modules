<?php

function add_user_feeds() {

	global $current_user, $user, $db;

	$digg_user_id = $_REQUEST['digg_user_id'];
	$user_id = $_REQUEST['user_id'];
	$digg_submit_url = digg_users_digg_submit_url;
	$digg_vote_url = digg_users_digg_vote_url;

	$digg_submit_url = str_replace('<<username>>', $digg_user_id, $digg_submit_url);
	$digg_vote_url = str_replace('<<username>>', $digg_user_id, $digg_vote_url);

	error_log($digg_submit_url);
	error_log($digg_vote_url);

	// get current digg user id
	$sql = "SELECT digg_user_id FROM ".table_users." WHERE user_login = '".$user->username."'";
	$digg_user_id_db = $db->get_row($sql);

	// Verify we are saving the profile, are logged in,
	// and the digg user id has actually changed since
	// last time
	if (($current_user->user_id > 0) && isset($_POST['save_profile']) && isset($_POST['process']) && ($_POST['user_id'] == $current_user->user_id) && ($digg_user_id_db->digg_user_id != $digg_user_id)) {

		// We don't need the old rss for this user
		if ($digg_user_id_db->digg_user_id != '') {
			$db->query("DELETE FROM ".table_feed_link." WHERE feed_id IN (SELECT feed_id FROM ".table_feeds." WHERE feed_submitter='$user_id')");
			$db->query("DELETE FROM ".table_feeds." WHERE feed_submitter='$user_id'");
		}
	
		if ($digg_user_id != '') {
			// user submit feed
			$sql = "INSERT INTO ".table_feeds." (feed_name, feed_url, feed_freq_hours, feed_votes, feed_submitter, feed_item_limit, feed_category) VALUES ('".$user->username."_submitted_articles','$digg_submit_url','".digg_users_submit_feed_freq_hours."','".digg_users_submit_feed_votes."','$user_id','".digg_users_submit_feed_item_limit."','".digg_users_submit_category."')";
			$db->query($sql);
			$id = $db->insert_id;

			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_title_field."','link_title')";
			$db->query($sql);
			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_description_field."','link_content')";
			$db->query($sql);
			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_url_field."','link_url')";
			$db->query($sql);

			// user vote feed
			$sql = "INSERT INTO ".table_feeds." (feed_name, feed_url, feed_freq_hours, feed_votes, feed_submitter, feed_item_limit, feed_category) VALUES ('".$user->username."_voted_articles','$digg_vote_url','".digg_users_vote_feed_freq_hours."','".digg_users_vote_feed_votes."','$user_id','".digg_users_vote_feed_item_limit."','".digg_users_vote_category."')";
			$db->query($sql);
			$id = $db->insert_id;

			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_title_field."','link_title')";
			$db->query($sql);
			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_description_field."','link_content')";
			$db->query($sql);
			$sql = "INSERT INTO ".table_feed_link." (feed_id, feed_field, pligg_field) VALUES ('$id','".digg_users_digg_url_field."','link_url')";
			$db->query($sql);
		}
	}
}
	
?>
