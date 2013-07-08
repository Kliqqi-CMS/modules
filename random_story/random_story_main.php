<?php

function random_story_getdata(){
	global $view, $db, $current_user, $main_smarty;

	$cols = $db->get_col('select link_id from ' . table_links . ' where `link_status` = "published" order by link_id desc limit 200;');
	//echo count($cols);
	if($cols){
		$randstory = rand(0, count($cols)-1);
		$randstoryurl = getmyurl("story", $cols[$randstory]);
		$main_smarty->assign('random_story_randstoryurl', $randstoryurl);
	}	
}	


?>