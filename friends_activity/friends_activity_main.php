<?php

function friends_activity(&$vars)
{
	global $db,$main_smarty;
	$author_id = $vars['author_id'];
	$linkid = $vars['link_id'];
	//for friends voting activity
	include_once(mnminclude.'friend.php');
	$friend = new Friend;
	$sql = 'SELECT ' . table_votes . '.*, ' . table_users . '.user_id FROM ' . table_votes . ' INNER JOIN ' . table_users . ' ON ' . table_votes . '.vote_user_id = ' . table_users . '.user_id WHERE (((' . table_votes . '.vote_value)>0) AND ((' . table_votes . '.vote_link_id)='.$linkid.') AND (' . table_votes . '.vote_type= "links"));';
	$voters = $db->get_results($sql);
	$voters = object_2_array($voters);
	foreach($voters as $key => $val)
	{
		$voteduserid = $val['user_id'];
		if($voteduserid == $friend->get_friend_status($author_id))
		{
			$vars['value'] = true;	
		}
		$main_smarty->assign('friendvoted', $friendvoted);
	}
}
?>