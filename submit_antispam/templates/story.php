<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'pageview.php');

if(isset($_REQUEST['id'])){$requestID = strip_tags($_REQUEST['id']);}
if(!is_numeric($theid)){$theid = 0;}
if(isset($_REQUEST['title'])){$requestTitle = strip_tags($_REQUEST['title']);}
// if we're using "Friendly URL's for categories"
if(isset($_REQUEST['category'])){$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".urlencode(sanitize($_REQUEST['category'], 1))."';");}

if(isset($requestID) && enable_friendly_urls == true){
	// if we're using friendly urls, don't call /story.php?id=XX  or /story/XX/
	// this is to prevent google from thinking it's spam
	// more work needs to be done on this

	$link = new Link;
	$link->id=$requestID;
	$link->read();	

	$url = getmyurl("storyURL", $link->category_safe_name($link->category), urlencode($link->title_url), $link->id);

	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location: " . $url );
	
	die();
}
 
// if we're using "Friendly URL's for stories"
if(isset($requestTitle)){$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '$requestTitle';");}

if(is_numeric($requestID)) {
	$id = $requestID;
	$link = new Link;
	$link->id=$requestID;
	$link->read();
	if(isset($_POST['process'])){
		if ($_POST['process']=='newcomment') {
			insert_comment();
		}
	}

	// log the pageview
	$pageview = new Pageview;
	$pageview->type='story';
	$pageview->page_id=$link->id;
	$pageview->user_id=$current_user->user_id;
	require_once(mnminclude.'check_behind_proxy.php');
	$pageview->user_ip=check_ip_behind_proxy();
	
	// find the last pageview
	$last_visit = $pageview->last_visit();
	if($last_visit != 0){$last_visit = txt_time_diff($pageview->last_visit(), time());}
	$main_smarty->assign('last_visit', $last_visit);
	$pageview->insert();
	
	// Set globals
	$globals['link_id']=$link->id;
	$globals['category_id']=$link->category;
	$globals['category_name']=$link->category_name();
	$globals['category_url']=$link->category_safe_name();
	check_actions('story_top');

	$main_smarty->assign('link_submitter', $link->username());

	// setup breadcrumbs and page title
	$main_smarty->assign('posttitle', $link->title);
	$navwhere['text1'] = $globals['category_name'];
	$navwhere['link1'] = getmyurl('maincategory', makeCategoryFriendly($globals['category_url']));
	$navwhere['text2'] = $link->title;
	$navwhere['link2'] = getmyurl('storycattitle', makeCategoryFriendly($globals['category_url']), urlencode($link->title_url));
	$main_smarty->assign('navbar_where', $navwhere);

	// for the comment form
	$randkey = rand(1000000,100000000);
	$main_smarty->assign('randkey', $randkey);
	$main_smarty->assign('link_id', $link->id);
	$main_smarty->assign('user_id', $current_user->user_id);
	$main_smarty->assign('randmd5', md5($current_user->user_id.$randkey));

	// for login to comment
	$main_smarty->assign('register_url', getmyurl("register", ''));
	$main_smarty->assign('login_url', getmyurl("login", $_SERVER['REQUEST_URI']));

	// for show who voted
	$main_smarty->assign('user_url', getmyurl('userblank', ""));
	$main_smarty->assign('voter', who_voted($id, 'small'));

	// misc smarty
	$main_smarty->assign('Enable_Comment_Voting', Enable_Comment_Voting);
	$main_smarty->assign('enable_show_last_visit', enable_show_last_visit);
	$main_smarty->assign('Spell_Checker',Spell_Checker);
	$main_smarty->assign('UseAvatars', do_we_use_avatars());
    $main_smarty->assign('related_title_url', getmyurl('storytitle', ""));
    $main_smarty->assign('related_story', related_stories($id, $link->tags, $link->category));

	// meta tags
	$main_smarty->assign('meta_description',$link->truncate_content());
	$main_smarty->assign('meta_keywords', $link->tags);
	
	//sidebar
	$main_smarty = do_sidebar($main_smarty);	

	// pagename
	define('pagename', 'story'); 
	$main_smarty->assign('pagename', pagename);

	$main_smarty->assign('tpl_center', $the_template . '/story_center');
	$main_smarty->display($the_template . '/pligg.tpl');
}

function get_comments (){
	Global $db, $main_smarty, $current_user, $CommentOrder, $link;
	
	//Set comment order to 1 if it's not set in the admin panel
	if(!isset($CommentOrder)){$CommentOrder = 1;}
	If ($CommentOrder == 1){$CommentOrderBy = "comment_votes DESC, comment_date DESC";}
	If ($CommentOrder == 2){$CommentOrderBy = "comment_date DESC";}
	If ($CommentOrder == 3){$CommentOrderBy = "comment_votes DESC, comment_date ASC";}
	If ($CommentOrder == 4){$CommentOrderBy = "comment_date ASC";}
	
	// get all parent comments
  $comments = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_link_id=$link->id and comment_parent = 0 ORDER BY " . $CommentOrderBy);
  
  if ($comments) {
    require_once(mnminclude.'comment.php');
    $comment = new Comment;
    foreach($comments as $comment_id) {
      $comment->id=$comment_id;
      $comment->read();
      $comment->print_summary($link);			
	                                                 
			// get all child comments
			$comments2 = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_parent=$comment_id ORDER BY " . $CommentOrderBy);
			if ($comments2) {
				echo '<div style="margin-left:40px">';
				require_once(mnminclude.'comment.php');
				$comment2 = new Comment;
				foreach($comments2 as $comment_id) {
					$comment2->id=$comment_id;
					$comment2->read();
					$comment2->print_summary($link);
				}
				echo "</div>\n";
			}
	
 		}
  }
}


function insert_comment () {
	global $link, $db, $current_user;
  check_actions('story_insert_comment',$vars);

	require_once(mnminclude.'comment.php');
	$comment = new Comment;

	$cancontinue = false;
	if($_POST['link_id'] == $link->id && $current_user->authenticated && $_POST['user_id'] == $current_user->user_id &&	$_POST['randkey'] > 0) {
		if(strlen($_POST['comment_content']) > 0){
			$comment->content=$_POST['comment_content'];
			$cancontinue = true;
			// this is a normal new comment
		}

		if(strlen($_POST['reply_comment_content-'.$_POST['comment_parent_id']]) > 0){
			$comment->content = $_POST['reply_comment_content-'.$_POST['comment_parent_id']];
			$comment->parent=$_POST['comment_parent_id'];
			$cancontinue = true;
			// this is a reply to an existing comment
		}

		if($cancontinue == true){
			$comment->link=$link->id;
			$comment->randkey=$_POST['randkey'];
			$comment->author=$_POST['user_id'];
			$comment->store();
			header('Location: '.$_SERVER['REQUEST_URI']);
			die;
		}
	}
}
?>
