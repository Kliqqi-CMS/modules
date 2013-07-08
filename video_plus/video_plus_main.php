<?php
function video_plus_track($vars)
{
    global $db, $smarty, $dblang, $the_template, $linkres, $current_user;
	$siteurl = my_base_url . my_pligg_base;
	
    $link_id = $vars['smarty']->_vars['link_id'];
    $row = $db->get_row($sql = "SELECT * FROM " . table_links . " where link_id='$link_id'",ARRAY_A);
    if ($row)
	if (preg_match('/\/watch\?v=([^&]+)/',$row['link_url'],$m))	{
	    $vars['smarty']->_vars["video_thumbnail"] = "http://img.youtube.com/vi/{$m[1]}/1.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://img.youtube.com/vi/{$m[1]}/2.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://img.youtube.com/vi/{$m[1]}/3.jpg";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://img.youtube.com/vi/{$m[1]}/0.jpg";
	} elseif (preg_match('/\/www.own3d.tv\/watch\/([0-9a-zA-Z\-\_]*)\,([0-9]*)/',$row['link_url'],$m)) {
	    $vars['smarty']->_vars["video_thumbnail"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[2]}__1.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[2]}__2.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[2]}__3.jpg";
	    $vars['smarty']->_vars["video_thumbnail_large"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[2]}__1.jpg";
	} elseif (preg_match('/\/www.own3d.tv\/watch\/([0-9]*)/',$row['link_url'],$m)) {
	    $vars['smarty']->_vars["video_thumbnail"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[1]}__1.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[1]}__2.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[1]}__3.jpg";
	    $vars['smarty']->_vars["video_thumbnail_large"] = "http://www.own3d.tv/uploads/thumbnails/tn_{$m[1]}__1.jpg";
	} elseif (preg_match('/vimeo.com\/([0-9]*)/',$row['link_url'],$m)) {
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$m[1]}.php"));
	    $vars['smarty']->_vars["video_thumbnail"] = $hash[0]["thumbnail_medium"];
		$vars['smarty']->_vars["video_thumbnail_2"] = $hash[0]["thumbnail_small"];
		$vars['smarty']->_vars["video_thumbnail_3"] = $hash[0]["thumbnail_medium"];
		$vars['smarty']->_vars["video_thumbnail_large"] = $hash[0]["thumbnail_large"];
	} elseif (preg_match('/\/www.metacafe.com\/watch\/([^&]+)\/([^&]+)/',$row['link_url'],$m)) {
	    $vars['smarty']->_vars["video_thumbnail"] = "http://s4.mcstatic.com/thumb/{$m[1]}.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://s4.mcstatic.com/thumb/{$m[1]}.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://s4.mcstatic.com/thumb/{$m[1]}.jpg";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://s4.mcstatic.com/thumb/{$m[1]}.jpg";
	} elseif (preg_match('/\/redtube.com\/([^&]+)/',$row['link_url'],$m)) {
		$number = "{$m[1]}";
		$short = substr($number,0,2);
		$vars['smarty']->_vars["video_thumbnail"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_002.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_003.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_004.jpg";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_001.jpg";
	} elseif (preg_match('/\/www.redtube.com\/([^&]+)/',$row['link_url'],$m)) {
		$number = "{$m[1]}";
		$short = substr($number,0,2);
		$vars['smarty']->_vars["video_thumbnail"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_002.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_003.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_004.jpg";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://thumbs.redtube.com/_thumbs/00000".$short."/00{$m[1]}/00{$m[1]}_001.jpg";
	} elseif (preg_match('/\/keezmovies.com\/([^&]+)/',$row['link_url'],$m)) {
		$number = "{$m[1]}";
		$short1 = substr($number,0,3);
		$short2 = substr($number,3,3);
		$vars['smarty']->_vars["video_thumbnail"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small1.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small2.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small3.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/large.jpg?cache_control=0";
	} elseif (preg_match('/\/www.keezmovies.com\/([^&]+)/',$row['link_url'],$m)) {
		$number = "{$m[1]}";
		$short1 = substr($number,0,3);
		$short2 = substr($number,3,3);
		$vars['smarty']->_vars["video_thumbnail"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small1.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_2"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small2.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_3"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/small3.jpg?cache_control=0";
		$vars['smarty']->_vars["video_thumbnail_large"] = "http://cdn-pics1.keezmovies.com/thumbs/000/".$short1."/".$short2."/large.jpg?cache_control=0";
	} else {
		$vars['smarty']->_vars["video_thumbnail"] = "$siteurl/modules/video_plus/images/noimage.jpg";
		$vars['smarty']->_vars["video_thumbnail_2"] = "$siteurl/modules/video_plus/images/noimage.jpg";
		$vars['smarty']->_vars["video_thumbnail_3"] = "$siteurl/modules/video_plus/images/noimage.jpg";
		$vars['smarty']->_vars["video_thumbnail_large"] = "$siteurl/modules/video_plus/images/noimage_large.jpg";
	}
}

?>