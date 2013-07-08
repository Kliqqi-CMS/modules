<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>	
		<meta name="title" content="{$title}">
		<meta name="description" content="{$summary}" /> 
		<title>{#PLIGG_Visual_Name#} - {$title}</title>
		<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/modules/pligg_web_toolbar/css/style.css" media="screen" />
	</head>
	<body dir="{#PLIGG_Visual_Language_Direction#}" {$body_args}>
{* {config_load file=pligg_web_toolbar_lang_conf} *}
		<table width="100%" cellpadding="2" cellspacing="1" class="bar" style="background-image: url('{$pligg_web_toolbar_img_path}back.gif');">
			<tr >
				<td width="140px">
					<a href="{$my_pligg_base}"><img src="{$pligg_web_toolbar_img_path}logo.gif" border="0"></a>
				</td>
				<td width="80px">
					<div class="votes" style=" background-image: url('{$pligg_web_toolbar_img_path}vote.png');"><div class="votes_votecount">{$votes}</div></div>
				</td>
				<td class="main"><span class="title">
					<a href="story.php?title={$titleurl}">{$title}</a></span>
					<br><span class="grey"><a href="story.php?title={$titleurl}"><img src="{$pligg_web_toolbar_img_path}comment.gif" align="absmiddle" border="0" style="margin-right:1px;">{$comments}</a> | <img src="{$pligg_web_toolbar_img_path}link.gif" align="absmiddle" border="0" style="margin-right:1px;">{$url}</span>
				</td>
				<td width="150px"> 
					<div style="float:right;position:relative;z-index:1001;">
						<!-- AddThis Button BEGIN -->
						<a class="addthis_button" href="http://addthis.com/bookmark.php?v=250"><img src="http://s7.addthis.com/static/btn/v2/lg-bookmark-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
						<!-- AddThis Button END -->
					</div>
				</td>
				<td width="50px">
					<a href="{$url}" target="_top"><img src="{$pligg_web_toolbar_img_path}cross.png" border="0"></a>
				</td>
			</tr>
		</table>
		<iframe src="{$url}" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto" noresize="noresize"></iframe>
	</body>
</html>
{* {config_load file=pligg_web_toolbar_pligg_lang_conf} *}