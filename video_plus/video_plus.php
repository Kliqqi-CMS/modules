<?php
// blip.tv
// cbsnews.com (currently broken)
// cnn.com
// colbertnation.com
// collegehumor.com
// comedycentral.com
// funnyordie.com
// guba.com
// IceFilms.info
// liveleak.com
// livevideo.com
// MegaVideo.com
// metacafe.com
// own3d.tv
// redtube.com
// reuters.com
// revver.com
// spike.com
// StageVu.com
// thedailyshow.com
// thenewsroom.com
// vbox7.com
// vids.myspace.com
// video.google.com
// vimeo.com
// veoh.com
// youare.tv
// youku.com
// youtube.com

include('../../config.php');

$id = mysql_real_escape_string(strip_tags($_GET['id']));
$play_query = mysql_query("SELECT link_votes,link_tags,link_url FROM " . table_links . " WHERE link_id=\"$id\" LIMIT 1");
$play_array = mysql_fetch_array($play_query);
$play = $play_array['link_url'];
$tags = $play_array['link_tags'];


function embed_video($url){

    // code to display Google Video .com
    if (preg_match("/http:\/\/video.google.com\/videoplay\?docid=([0-9\-]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="426">'.
			   '<embed src="http://video.google.com/googleplayer.swf?docId='.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" />'.
			   '</object>';
    }
 // code to display Google Video .nl
    if (preg_match("/http:\/\/video.google.nl\/videoplay\?docid=([0-9\-]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="426">'.
			   '<embed src="http://video.google.com/googleplayer.swf?docId='.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" />'.
			   '</object>';
    }

    // code to display Google Video co.uk
    if (preg_match("/http:\/\/video.google.co.uk\/videoplay\?docid=([0-9\-]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="426">'.
			   '<embed src="http://video.google.co.uk/googleplayer.swf?docId='.$matches[1].'" type="application/x-shockwave-flash" width="400" height="400" />'.
			   '</object>';
    }

    // code to display YouTube WWW
    if (preg_match("/http:\/\/www.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://www.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparent" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube NO WWW
    if (preg_match("/http:\/\/youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://www.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparent" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

 // code to display YouTube United Kingdom
    if (preg_match("/http:\/\/uk.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://uk.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparent" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Brazil
    if (preg_match("/http:\/\/br.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://br.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube France
    if (preg_match("/http:\/\/fr.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://fr.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Ireland
    if (preg_match("/http:\/\/ie.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://ie.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Italy
    if (preg_match("/http:\/\/it.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://it.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Japan
    if (preg_match("/http:\/\/jp.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://jp.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Netherland
    if (preg_match("/http:\/\/nl.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://nl.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Poland
    if (preg_match("/http:\/\/pl.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://pl.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }

    // code to display YouTube Spain
    if (preg_match("/http:\/\/es.youtube.com\/watch\?v=([0-9a-zA-Z-_]*)(.*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
               '<param name="movie" value="http://es.youtube.com/v/'.$matches[1].'" />'.
               '<param name="wmode" value="transparnt" />'.
               '<embed src="http://www.youtube.com/v/'.$matches[1].'&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400" />'.
               '</object>';
    }
	
	// code to display vbox7
	if (preg_match("/http:\/\/vbox7.com\/play:([0-9a-zA-Z-_]*)/i", $url, $matches)) {
		return  '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="473" height="405" />'.
				'<param name="movie" value="http://i47.vbox7.com/player/ext.swf?vid='.$matches[1].'" />'.
				'<param name="quality" value="high" />'.
				'<embed src="http://i47.vbox7.com/player/ext.swf?vid='.$matches[1].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="473" height="405" />'.
				'</embed>'.
				'</object>';
	}

    // code to display RedTube
    if (preg_match("/http:\/\/www.redtube.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object height="405" width="700">
			<param name="movie" value="http://embed.redtube.com/player/">
			<param name="FlashVars" value="id='.$matches[1].'&style=redtube">
			<embed 
				src="http://embed.redtube.com/player/?id='.$matches[1].'&style=redtube" 
				pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" 
				type="application/x-shockwave-flash" height="405" width="700" />
		</object>';
    }
    if (preg_match("/http:\/\/redtube.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object height="405" width="700">
			<param name="movie" value="http://embed.redtube.com/player/">
			<param name="FlashVars" value="id='.$matches[1].'&style=redtube">
			<embed 
				src="http://embed.redtube.com/player/?id='.$matches[1].'&style=redtube" 
				pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" 
				type="application/x-shockwave-flash" height="405" width="700" />
		</object>';
    }
	
    // code to display Revver
    if (preg_match("/http:\/\/revver.com\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<script src="http://flash.revver.com/player/1.0/player.js?mediaId:'.$matches[1].';width:700;height:405;" type="text/javascript"></script>';
    }

    // code to display My Space
    if (preg_match("/http:\/\/vids.myspace.com\/index.cfm\?fuseaction=vids.individual&VideoID=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="415">'.
					'<param name="movie" value="http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID='.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://lads.myspace.com/videos/vplayer.swf" flashvars="m='.$matches[1].'&type=video" type="application/x-shockwave-flash" width="700" height="400" />'.
				'</object>';
    }

    // code to display Vimeo NO WWW!!!
    if (preg_match("/http:\/\/vimeo.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="415">'.
					'<param name="movie" value="http://vimeo.com/'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.vimeo.com/moogaloop.swf?clip_id='.$matches[1].'" quality="best" scale="exactfit" width="700" height="400" type="application/x-shockwave-flash" />'.
				'</object>';
    }

    // code to display Vimeo WWW
    if (preg_match("/http:\/\/www.vimeo.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="415">'.
					'<param name="movie" value="http://vimeo.com/'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.vimeo.com/moogaloop.swf?clip_id='.$matches[1].'" quality="best" scale="exactfit" width="700" height="400" type="application/x-shockwave-flash" />'.
				'</object>';
    }

	// code to display Veoh
    if (preg_match("/http:\/\/www.veoh.com\/browse\/videos\/#watch%3Dv([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="400" id="veohFlashPlayer" name="veohFlashPlayer"><param name="movie" value="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.2.1003&permalinkId=v'.$matches[1].'&player=videodetailsembedded&videoAutoPlay=0&id=anonymous"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.2.1003&permalinkId=v'.$matches[1].'&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="700" height="400" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed></object>';
    }

	// code to display Veoh
    if (preg_match("/http:\/\/www.veoh.com\/search\/videos\/q\/([0-9a-zA-Z\-\_]*)#watch%3Dv([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="400" id="veohFlashPlayer" name="veohFlashPlayer"><param name="movie" value="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.2.1003&permalinkId=v'.$matches[2].'&player=videodetailsembedded&videoAutoPlay=0&id=anonymous"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.2.1003&permalinkId=v'.$matches[2].'&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="700" height="400" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed></object>';
    }

    // code to display MetaCafe
    if (preg_match("/http:\/\/www.metacafe.com\/watch\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://www.metacafe.com/fplayer/'.$matches[1].'/'.$matches[2].'.swf" width="700" height="400" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_'.$matches[1].'"></embed>
';
    }

    // code to display Spike
    if (preg_match("/http:\/\/www.spike.com\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed width="550" height="410" src="http://www.spike.com/efp" quality="high" bgcolor="000000" name="efp" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="flvbaseclip='.$matches[2].'" allowfullscreen="true"></embed>';
    }

	// code to display StageVu
	if (preg_match("/http:\/\/stagevu.com\/video\/([a-z]*)/i", $url, $matches)) {
	return '<iframe style="overflow: hidden; border: 0; width: 700px; height: 400px" src="http://stagevu.com/embed?width=700&amp;height=400&amp;background=000& amp;uid=' .$matches[1]. '" scrolling="no">'.
	'</iframe>';
	}

	// code to display MegaVideo
	if (preg_match("/http:\/\/www.megavideo.com\/\?v=([A-Z0-9]*)/i", $url, $matches)) {
		return '<object width="700" height="400">'.
		'<param name="movie" value="http://www.megavideo.com/v/'.$matches[1].'" />'.
		'<param name="wmode" value="transparent" />'.
		'<embed src="http://www.megavideo.com/v/'.$matches[1].'" type="application/x-shockwave-flash" wmode="transparent" allowfullscreen="true" width="700" height="400" />'.
		'</object>';
	}
    // code to display Guba
    if (preg_match("/http:\/\/www.guba.com\/watch\/([A-Z0-9]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
    //    return "<embed src='http://www.guba.com/static/f/player__v12735.swf?isEmbeddedPlayer=true&bid=".$matches[1]."' quality='best' bgcolor='#000000' menu='true' width='700px' height='400px' name='root' id='root' align='middle' scaleMode='noScale' allowScriptAccess='never' allowFullScreen='true' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed>";
		return '<object width="700" height="400" data="http://www.guba.com/static/f/player__v12735.swf?bid='.$matches[1].'&config=/playerConfig" type="application/x-shockwave-flash">
		  <param name="movie" value="http://www.guba.com/static/f/player__v12735.swf?bid='.$matches[1].'&config=/playerConfig"/>
		  <param name="allowfullscreen" value="true"/>
		  <param name="wmode" value="transparent"/>
		</object>';
	}

    // code to display Live Video
    if (preg_match("/http:\/\/www.livevideo.com\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*).aspx/i", $url, $matches)) {
        return '<object width="700" height="420">'.
					'<param name="movie" value="http://www.livevideo.com/flvplayer/embed/'.$matches[2].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.livevideo.com/flvplayer/embed/'.$matches[2].'" type="application/x-shockwave-flash" quality="high" WIDTH="700" HEIGHT="420" wmode="transparent" />'.
				'</object>';
    }
	
    // code to display Live Video
    if (preg_match("/http:\/\/www.livevideo.com\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*).aspx/i", $url, $matches)) {
        return '<object width="700" height="420">'.
					'<param name="movie" value="http://www.livevideo.com/flvplayer/embed/'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.livevideo.com/flvplayer/embed/'.$matches[1].'" type="application/x-shockwave-flash" quality="high" WIDTH="700" HEIGHT="420" wmode="transparent" />'.
				'</object>';
    }

    // code to display LiveLeak NOWWW
    if (preg_match("/http:\/\/liveleak.com\/view\?i=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
					'<param name="movie" value="http://www.liveleak.com/e/'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.liveleak.com/e/'.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" wmode="transparent" />'.
				'</object>';
    }

    // code to display LiveLeak WWW
    if (preg_match("/http:\/\/www.liveleak.com\/view\?i=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
					'<param name="movie" value="http://www.liveleak.com/e/'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.liveleak.com/e/'.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" wmode="transparent" />'.
				'</object>';
    }

	// BROKEN code to display Blip.tv WWW
    if (preg_match("/http:\/\/www.blip.tv\/file\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://blip.tv/play/'.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" allowscriptaccess="always" allowfullscreen="true"></embed>';
    }

    // BROKEN code to display Blip.tv NOWWW
    if (preg_match("/http:\/\/blip.tv\/file\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://blip.tv/play/'.$matches[1].'" type="application/x-shockwave-flash" width="700" height="400" allowscriptaccess="always" allowfullscreen="true"></embed>';
    }
	
	
		
    // BROKEN code to display YouAreTv WWW
    if (preg_match("/http:\/\/www.youare.tv\/watch.php\?id=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://www.youare.tv/yatvplayer.swf?videoID='.$matches[1].'&serverDomain=" allowScriptAccess="always" loop="false" quality="best" wmode="transparent" width="700" height="400" type="application\x-shockwave-flash" ></embed>';
    }

    // BROKEN code to display YouAreTv NOWWW
    if (preg_match("/http:\/\/youare.tv\/watch.php\?id=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://www.youare.tv/yatvplayer.swf?videoID='.$matches[1].'&serverDomain=" allowScriptAccess="always" loop="false" quality="best" wmode="transparent" width="700" height="400" type="application\x-shockwave-flash" ></embed>';
    }
	
    // code to display CollegeHumor
    if (preg_match("/http:\/\/www.collegehumor.com\/video:([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object width="700" height="400">'.
					'<param name="movie" value="http://www.collegehumor.com/video:'.$matches[1].'" />'.
					'<param name="allowfullscreen" value="true" />'.
					'<embed src="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id='.$matches[1].'" quality="best" width="700" height="400" type="application/x-shockwave-flash" />'.
				'</object>';
    }

    // code to display Reuters
    if (preg_match("/http:\/\/www.reuters.com\/news\/video\?videoID=([0-9a-zA-Z\-\_]*)&videoChannel=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object type="application/x-shockwave-flash" data="http://static.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" width="700" height="400"><param name="wmode" value="transparent" /><param name="movie" value="http://www.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" /><embed src="http://www.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400"></embed></object>';
    }
    if (preg_match("/http:\/\/www.reuters.com\/news\/video\?videoID=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object type="application/x-shockwave-flash" data="http://static.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" width="700" height="400"><param name="wmode" value="transparent" /><param name="movie" value="http://www.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" /><embed src="http://www.reuters.com/resources/flash/include_video.swf?edition=US&videoId='.$matches[1].'" type="application/x-shockwave-flash" wmode="transparent" width="700" height="400"></embed></object>';
    }
	
	// code to display thenewsroom.com
    if (preg_match("/http:\/\/www.thenewsroom.com\/details\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object id="swfclipV'.$matches[1].'" width="700" height="400" type="application/x-shockwave-flash" data="http://www.thenewsroom.com/mash/swf/cube.swf?a=V'.$matches[1].'&amp;m=820422"><param name="movie" value="http://www.thenewsroom.com/mash/swf/cube.swf?a=V'.$matches[1].'&amp;m=820422"/><param name="allowScriptAccess" value="always"/><param name="base" value="." /><param name="wmode" value="transparent"/><param name="allowfullscreen" value="true"/></object>';
    }

	// code to display thedailyshow.com
    if (preg_match("/http:\/\/www.thedailyshow.com\/video\/index.jhtml\?videoId=([0-9a-zA-Z\-\_]*)&([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
		return '<embed src="http://media.mtvnservices.com/mgid:cms:item:comedycentral.com:'.$matches[1].'" width="700" height="400" type="application/x-shockwave-flash" wmode="window" allowFullscreen="true" flashvars="autoPlay=false" bgcolor="#000000"></embed>';
    }

	// code to display colbertnation.com
    if (preg_match("/http:\/\/www.colbertnation.com\/the-colbert-report-videos\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return "<embed src='http://media.mtvnservices.com/mgid:cms:item:comedycentral.com:".$matches[1]."' width='700' height='400' type='application/x-shockwave-flash' wmode='window' allowFullscreen='true' flashvars='autoPlay=false' allowscriptaccess='always' allownetworking='all' bgcolor='#000000'></embed>";
    }

	// code to display comedycentral.com
    if (preg_match("/http:\/\/www.comedycentral.com\/videos\/index.jhtml\?videoId=([0-9a-zA-Z\-\_]*)&([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<embed src="http://media.mtvnservices.com/mgid:cms:item:comedycentral.com:'.$matches[1].'" width="700" height="400" type="application/x-shockwave-flash" wmode="window" allowFullscreen="true" flashvars="autoPlay=false" bgcolor="#000000"></embed>';
    }

	// code to display KeezMovies.com WWW
    if (preg_match("/http:\/\/www.keezmovies.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object type="application/x-shockwave-flash" data="http://www.keezmovies.com/cdn_files/flash/player_embed.swf" width="700" height="410"><param name="movie" value="http://www.keezmovies.com/cdn_files/flash/player_embed.swf" /><param name="bgColor" value="#000000" /><param name="allowfullscreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="FlashVars" value="options=http://www.keezmovies.com/embed_player.php?id='.$matches[1].'"/></object>';
    }
	// code to display KeezMovies.com NO WWW
    if (preg_match("/http:\/\/keezmovies.com\/([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
        return '<object type="application/x-shockwave-flash" data="http://www.keezmovies.com/cdn_files/flash/player_embed.swf" width="700" height="410"><param name="movie" value="http://www.keezmovies.com/cdn_files/flash/player_embed.swf" /><param name="bgColor" value="#000000" /><param name="allowfullscreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="FlashVars" value="options=http://www.keezmovies.com/embed_player.php?id='.$matches[1].'"/></object>';
    }
	
	// code to display cnn.com
	if (preg_match("/http:\/\/www.cnn.com\/video\/#\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/(.*)/i", $url, $matches)) {
        return '<script src="http://i.cdn.turner.com/cnn/.element/js/2.0/video/evp/module.js?loc=dom&vid=/video/'.$matches[1].'/'.$matches[2].'/'.$matches[3].'/'.$matches[4].'/'.$matches[5].'" type="text/javascript"></script>';
    }
	if (preg_match("/http:\/\/www.cnn.com\/video\/\?JSONLINK=\/video\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/([0-9a-zA-Z\-\_]*)\/(.*)/i", $url, $matches)) {
        return '<script src="http://i.cdn.turner.com/cnn/.element/js/2.0/video/evp/module.js?loc=dom&vid=/video/'.$matches[1].'/'.$matches[2].'/'.$matches[3].'/'.$matches[4].'/'.$matches[5].'" type="text/javascript"></script>';
    }

	/* code to display cbsnews.com
	if (preg_match("/http:\/\/www.cbsnews.com\/video\/watch\/\?id=([0-9a-zA-Z\-\_]*)/i", $url, $matches)) {
		$short = substr($matches[1],0,7);
		$videoid = 43917348+$short;
		return "<embed src='http://cnettv.cnet.com/av/video/cbsnews/atlantis2/player-dest.swf' FlashVars='linkUrl=http://www.cbsnews.com/video/watch/?id=".$matches[1]."&tag=mg;mostpopvideo&releaseURL=http://cnettv.cnet.com/av/video/cbsnews/atlantis2/player-dest.swf&videoId=".$videoid."&autoPlayVid=false&name=cbsPlayer&allowScriptAccess=always&wmode=transparent&embedded=y&scale=noscale&rv=n&salign=tl' allowFullScreen='true' width='700' height='415' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed>";
	}
	*/

	// code to display IceFilms.info
	if (preg_match("/http:\/\/icefilms.info\/index\.php\?option=com_iceplayer&Itemid=([A-Z0-9]*)&video=([A-Z0-9]*)/i", $url, $matches)) {
	return '<iframe style="overflow: hidden; border: 0; width: 720px; height: 400px" src="http://icefilms.info/components/com_iceplayer/video.php?h=300&w=720&item='.$matches[1].'&vid='.$matches[2].'" width="720" height="420" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">'.
	'</iframe>';
	}

	// code to display www.IceFilms.info
	if (preg_match("/http:\/\/www.icefilms.info\/index\.php\?option=com_iceplayer&Itemid=([A-Z0-9]*)&video=([A-Z0-9]*)/i", $url, $matches)) {
	return '<iframe style="overflow: hidden; border: 0; width: 720px; height: 400px" src="http://icefilms.info/components/com_iceplayer/video.php?h=300&w=720&item='.$matches[1].'&vid='.$matches[2].'" width="720" height="420" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">'.
	'</iframe>';
	}
	
	 // code to display own3d.tv http://www.own3d.tv/watch/nobody,16992.html
    if (preg_match("/http:\/\/www.own3d.tv\/watch\/([0-9a-zA-Z\-\_]*)\,([0-9]*).html/i", $url, $matches)) {
        return '<object width="710" height="400">'.
			   '<param name="movie" value="http://www.own3d.tv/stream/'.$matches[2].'" />'.
                           '<param name="allowfullscreen" value="true" />'.
                           '<param name="wmode" value="transparent" />'.
                           '<embed src="http://www.own3d.tv/stream/'.$matches[2].'" type="application/x-shockwave-flash" allowfullscreen="true" width="710" height="400" wmode="transparent" /></embed>'.
               '</object>';
    }

    // code to display own3d.tv http://www.own3d.tv/watch/16992
    if (preg_match("/http:\/\/www.own3d.tv\/watch\/([0-9]*)/i", $url, $matches)) {
        return '<object width="710" height="400">'.
			   '<param name="movie" value="http://www.own3d.tv/stream/'.$matches[1].'" />'.
                           '<param name="allowfullscreen" value="true" />'.
                           '<param name="wmode" value="transparent" />'.
                           '<embed src="http://www.own3d.tv/stream/'.$matches[1].'" type="application/x-shockwave-flash" allowfullscreen="true" width="710" height="400" wmode="transparent" /></embed>'.
               '</object>';
    }
	
    // code to display Funnyordie.com
    if (preg_match("/http:\/\/www.funnyordie.com\/videos\/([0-9a-zA-Z-_]*)\/([0-9a-zA-Z-_]*)/i", $url, $matches)) {
        return '<object width="700" height="400" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="ordie_player_'.$matches[1].'"><param name="movie" value="http://player.ordienetworks.com/flash/fodplayer.swf" /><param name="flashvars" value="key='.$matches[1].'" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always"></param><embed width="700" height="400" flashvars="key='.$matches[1].'" allowfullscreen="true" allowscriptaccess="always" quality="high" src="http://player.ordienetworks.com/flash/fodplayer.swf" name="ordie_player_'.$matches[1].'" type="application/x-shockwave-flash"></embed></object>';
    }
	
    // code to display Youku.com
    if (preg_match("/http:\/\/v.youku.com\/v_show\/id_(.*).html/i", $url, $matches)) {
        return '<embed src="http://player.youku.com/player.php/sid/'.$matches[1].'/v.swf" quality="high" width="700" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>';
    }
	
	return '';

}

?>


<?php if($type == 0) { ?>
<div style="background:#000;text-align:center;">
	<?php echo embed_video($play); ?>
</div>
<?php } ?>
