<?php
/*
############### About  ###################
Script name : Pligg Web Toolbar
Version : 0.1 
Developer : GoOpenSource
Email : contact@goopensource.net
Website : http://www.goopensource.net
Forum : http://www.goopensource.net
Download Pligg Web Toolbar at http://goopensource.net
Release date : 09/05/09
*/

chdir('../');
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'link.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

include_once '../settings.php';
include_once '../libs/dbconnect.php';
include_once '../libs/utils.php';

mysql_connect(EZSQL_DB_HOST,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
mysql_select_db(EZSQL_DB_NAME);

$id = sanitize($_REQUEST["id"]);
$sql = "select link_id,link_title_url,link_summary,link_url,link_title,link_votes,date(link_published_date) as link_pub_date from ".table_prefix."links where link_id='" . $id . "'";

$sql .= " order by link_published_date desc limit 15";

$rs = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($rs) == 0){
	echo '[{"error":"No popular stores....."}]';
	exit;
}
$titlelimit = 60;
$summarylimit = 100;
while($row = mysql_fetch_array($rs)){
	$title = $row[link_title];
	if (strlen($title) > $titlelimit)
	  $title = substr($title, 0, strrpos(substr($title, 0, $titlelimit), ' ')) . '...';
	
	$summary = $row[link_summary];
	if (strlen($summary) > $summarylimit)
	  $summary = substr($summary, 0, strrpos(substr($summary, 0, $summarylimit), ' ')) . '...';

	$sql = "select count(1) as cnt from ".table_prefix."comments where comment_link_id=".$row[link_id];
	$result = mysql_query($sql);
	$data = mysql_fetch_array($result);
	$id=$row['link_id'];
	$titleurl =urlencode($row['link_title_url']);
	$url = $row['link_url'];
	$votes = $row['link_votes'];
	$comments = $data['cnt'];
	$pubdate = $row['link_pub_date'];	

	// Language for vote count
	if($votes == 0){
		$votes = $votes . " votes";
	}elseif($votes == 1){
		$votes = $votes . " vote";
	}else{
		$votes = $votes . " votes";
	}
	// Language for comment count
	if($comments == 0){
		$comments = $comments . " comments";
	}elseif($comments == 1){
		$comments = $comments . " comment";
	}else{
		$comments = $comments . " comments";
	}
}	

$vars = '';
check_actions('pligg_web_toolbar_display', $vars);
$main_smarty->assign('id', $id);
$main_smarty->assign('titleurl', $titleurl);
$main_smarty->assign('votes', $votes);
$main_smarty->assign('comments', $comments);
$main_smarty->assign('pubdate', $pubdate);
$main_smarty->assign('url', $url);
$main_smarty->assign('title', $title);
$main_smarty->assign('summary', $summary);

$main_smarty->display(pligg_web_toolbar_tpl_path . '/pligg_web_toolbar.tpl');

?>