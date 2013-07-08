{config_load file=page_statistics_lang_conf}

<fieldset><legend>{#Pligg_page_statistics#}</legend>

	<div class="statistics-item">
		<div class="statistics-title"><strong>{#Pligg_page_statistics_title#}</strong></div>
		<div class="statistics-pid"><strong>{#Pligg_page_statistics_id#}</strong></div>
		<div class="statistics-views"><strong>{#Pligg_page_statistics_views#}</strong></div>			
	</div>
	
	{section name=nr loop=$stats}
		<div class="statistics-title"><a href="{$stats[nr].link_url}">{$stats[nr].link_title}</a></div>			
		<div class="statistics-pid">{$stats[nr].link_id}</div>			
		<div class="statistics-views">{$stats[nr].views}</div>			
	{/section}	
	
</fieldset>

{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/languages/lang_".$pligg_language.".conf"}

{php}
global $db, $main_smarty, $rows, $page_size, $offset;
do_pages($rows, $page_size, $the_page); 
{/php}