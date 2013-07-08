<?php
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'smartyvariables.php');
	include_once(mnminclude.'utf8/utf8.php');
	
	global $main_smarty, $offset, $page_size, $db, $the_template;
	
	$main_smarty = do_sidebar($main_smarty);
				
	$offset = (get_current_page()-1)*$page_size;	
	$rows = $db->get_var("SELECT count(*) FROM ".table_pageviews.",".table_links." WHERE `pv_type`='story' AND link_id IN(SELECT DISTINCT link_id FROM ".table_links." WHERE link_id=pv_page_id)");
	
	$sql = mysql_query("SELECT link_title,link_url,link_id,pv_page_id,count(*) views FROM ".table_pageviews.",".table_links." WHERE `pv_type`='story' AND link_id IN(SELECT DISTINCT link_id FROM ".table_links." WHERE link_id=pv_page_id) GROUP BY `pv_page_id` ORDER BY views DESC LIMIT $offset,$page_size");	
	$stats = array();
	
	while ($row = mysql_fetch_array($sql, MYSQL_ASSOC)) array_push ($stats, $row);	
		$main_smarty->assign('stats', $stats);		
	
	// breadcrumbs
	$navwhere['text1'] = "Page Statistics";
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	
	// pagename
	define('pagename', 'statistics'); 
	$main_smarty->assign('pagename', pagename);
	
	// show the template
	$main_smarty->assign('tpl_center',page_statistics_tpl_path . 'page_statistics');
	$main_smarty->display($the_template . '/pligg.tpl');

	function page_statistics() {  
		// the above code should be in this function but it breaks pagination. Without this function there is an
		// error on the bottom of the page.
	}

?>
