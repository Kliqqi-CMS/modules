<?php
function embed_videos_lib_link_summary_fill_smarty(){
	global $smarty;
	include_once('embed_videos_settings.php');
	$smarty->plugins_dir[] = embed_videos_plugins_path;
}
?>