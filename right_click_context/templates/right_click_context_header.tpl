{config_load file=right_click_context_lang_conf}
<!-- Right Click Context -->
<section contextmenu="mymenu">
	{literal}
	<script>
		function goTo(url) { window.open(url, "shareWindow"); }
	</script>
	{/literal}
	<menu type="context" id="mymenu">
	  {if $isadmin}<menuitem label="{#PLIGG_Right_Click_Context_Admin#}" onclick="goTo('//{$my_base_url|replace:'http://www.':''}{$my_pligg_base}/admin/' + window.location.href);" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/admin.png"></menuitem>{/if}
	  <menuitem label="{#PLIGG_Right_Click_Context_Refresh#}" onclick="window.location.reload();" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/refresh.png"></menuitem>
	  {if $pagename eq "story"}<menuitem label="{#PLIGG_Right_Click_Context_Comments#}" onclick="window.location='#comments';" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/comment.png"></menuitem>{/if}
	  <menu label="{#PLIGG_Right_Click_Context_Share#}" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/share.gif">
		<menuitem label="{#PLIGG_Right_Click_Context_Twitter#}" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/twitter.gif" onclick="goTo('//twitter.com/intent/tweet?text={$posttitle}:  ' + window.location.href);"></menuitem>
		<menuitem label="{#PLIGG_Right_Click_Context_Facebook#}" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/facebook.gif" onclick="goTo('//facebook.com/sharer/sharer.php?u=' + window.location.href);"></menuitem>
		<menuitem label="{#PLIGG_Right_Click_Context_Pinterest#}" icon="{$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/pinterest.png" onclick="goTo('//pinterest.com/pin/create/button/?url=' + window.location.href + '&media={$my_base_url}{$my_pligg_base}/modules/right_click_context/templates/images/pinterest_large.jpg');"></menuitem>
	  </menu>
	</menu>
{config_load file=right_click_context_pligg_lang_conf}