{config_load file=featured_lang_conf}
<li {if $modulename eq 'featured'}class="active"{/if}><a href="{$my_pligg_base}/module.php?module=featured">{#PLIGG_featured#}</a></li>
{config_load file=featured_pligg_lang_conf}
