{config_load file=submit_antispam_lang_conf}
{if $admin_present neq true}
<div style="border:1px solid black;padding:4px 4px 4px 4px;background:#F4FEFF;margin-top:5px">{#PLIGG_SUBMIT_ANTISPAM_except_this_link#} <b>{if $submitted_links_24h eq ""}0{else}{$submitted_links_24h}{/if}</b>  {#PLIGG_SUBMIT_ANTISPAM_Of#} <b>{$links_actual_limit}</b> {#PLIGG_SUBMIT_ANTISPAM_links#} {#PLIGG_SUBMIT_ANTISPAM_in_last_24_hours#}.</div>
{/if}