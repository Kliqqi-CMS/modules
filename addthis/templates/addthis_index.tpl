{config_load file=addthis_lang_conf}

{* Use the .addthis class in your CSS stylesheet to style the module, that way updates won't effect the style. *}

<div style="display:inline;margin:-2px 5px 0 0;float:right;" class="addthis">
	<!-- AddThis Button BEGIN -->
	<a href="http://www.addthis.com/bookmark.php?v=250&pub=pligg" onmouseover="return addthis_open(this, '', '{$my_base_url}{$story_url}', '{$title_short}')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-bookmark-en.gif" width="125" height="16" alt="{#Addthis_Bookmark#}" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=pligg"></script>
	<!-- AddThis Button END -->
</div>

{config_load file=addthis_pligg_lang_conf}