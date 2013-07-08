{config_load file=email_article_pligg_lang_conf}

<div style="display: inline; margin:9px 5px 0pt;float:left;" class="email_this">
	<a style="text-decoration:none;" href="mailto:?subject={$title_short}&body={$my_base_url}{$story_url}"><img src="{$my_base_url}{$my_pligg_base}/modules/email_article/templates/images/email.gif" width="16px" height="16px"style="border:none;" /></a> 
</div>

{* {$story_content|strip_tags|truncate:200} *}