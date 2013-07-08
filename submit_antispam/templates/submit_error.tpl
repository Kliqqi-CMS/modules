{config_load file=submit_antispam_lang_conf}
<link rel="stylesheet" href="{$submit_antispam_css_path}/submit_antispam.css"  type="text/css" />

<h2>{#PLIGG_SUBMIT_ANTISPAM_Submit_Limit_Exceeded#}!</h2><br />
<div class="submit_error_t"><img src="{$submit_antispam_images_path}/error_stop.png " style="height:32px;width:32px;"/>
<div style="font-size:11pt;margin-top:-28px;margin-left:40px;margin-bottom:3px">{#PLIGG_SUBMIT_ANTISPAM_Cannot_Submit_More#}
{if $submit_mode eq "link"}
 {#PLIGG_SUBMIT_ANTISPAM_links#}
{else}
{#PLIGG_SUBMIT_ANTISPAM_comments#}
{/if}
{#PLIGG_SUBMIT_ANTISPAM_At_Current_Auth_Level#}
</div></div>

<table class="submit_table" border="0" cellspacing="0">
    <tr>
        <th class="submit_table_th"><font size="2" color="#000000">{#PLIGG_SUBMIT_ANTISPAM_Required_avg_link_votes#}</font></th>
        <th class="submit_table_th"><font size="2" color="#000000">{#PLIGG_SUBMIT_ANTISPAM_Authorization_Level#}</font></th>
        <th class="submit_table_th"><font size="2" color="#000000">{#PLIGG_SUBMIT_ANTISPAM_Submissions_day#}</font></th>
    </tr>
    <tr>
        <td {if $current_authorization_level eq 0}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>0 {if $current_authorization_level eq 0}
        ({#PLIGG_SUBMIT_ANTISPAM_Your_Value#} = {$average_votes_value}){/if}</td>
        <td {if $current_authorization_level eq 0}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>0</td>
        <td {if $current_authorization_level eq 0}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_0_submit_allowed}</td>
    </tr>
        <tr>
        <td {if $current_authorization_level eq 1}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_1_required_votes} {if $current_authorization_level eq 1}({#PLIGG_SUBMIT_ANTISPAM_Your_Value#} = {$average_votes_value}){/if}</td>
        <td {if $current_authorization_level eq 1}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>1</td>
        <td {if $current_authorization_level eq 1}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_1_submit_allowed}</td>
    </tr>
        <tr>
        <td {if $current_authorization_level eq 2}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_2_required_votes} {if $current_authorization_level eq 2}({#PLIGG_SUBMIT_ANTISPAM_Your_Value#} = {$average_votes_value}){/if}</td>
        <td {if $current_authorization_level eq 2}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>2</td>
        <td {if $current_authorization_level eq 2}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_2_submit_allowed}</td>
    </tr>
        <tr>
        <td {if $current_authorization_level eq 3}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_3_required_votes} {if $current_authorization_level eq 3}({#PLIGG_SUBMIT_ANTISPAM_Your_Value#} = {$average_votes_value}){/if}</td>
        <td {if $current_authorization_level eq 3}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>3</td>
        <td {if $current_authorization_level eq 3}class="submit_table_td_selected" {else}class="submit_table_td"{/if}>{$authorization_level_3_submit_allowed}</td>
    </tr>
</table>

<div style="border:1px solid black;padding:4px 4px 4px 4px;font-size:10pt;margin-top:4px;font-weight:normal;color:black;background:#ededed">
<div style="font-size:10pt">
{if $submit_mode eq "comment"}



{/if}
{#PLIGG_SUBMIT_ANTISPAM_You_Have_Already_Sub#} <b>{$submitted_in_24h}</b>  {#PLIGG_SUBMIT_ANTISPAM_Of#} <b>{$actual_limit_r}</b> 
{if $submit_mode eq "link"} {#PLIGG_SUBMIT_ANTISPAM_links#}{else} {#PLIGG_SUBMIT_ANTISPAM_comments#}{/if} {#PLIGG_SUBMIT_ANTISPAM_Actual_Limit#}.<br />
{#PLIGG_SUBMIT_ANTISPAM_To_Submit_More#}
{if $submit_mode eq "link"}{#PLIGG_SUBMIT_ANTISPAM_links#}{else}{#PLIGG_SUBMIT_ANTISPAM_comments#}{/if} {#PLIGG_SUBMIT_ANTISPAM_You_Must_Wait#}:   ({$last_date_plus_24h})

<script language="JavaScript">    
    initiate_countdown('{$last_date_plus_24h}','{if $submit_mode eq "link"}{#PLIGG_SUBMIT_ANTISPAM_links#}{else}{#PLIGG_SUBMIT_ANTISPAM_comments#}{/if}');
    var SetTimeOutPeriod = (Math.abs(CountStepper)-1)*1000 + 990;     
    putspan(BackColor, ForeColor);
    var dthen = new Date(TargetDate);
    var dnow = new Date();
    if(CountStepper>0)
        ddiff = new Date(dnow-dthen);
    else
    ddiff = new Date(dthen-dnow);
    gsecs = Math.floor(ddiff.valueOf()/1000);
    CountBack(gsecs);                

</script>
</div>
</div>
                                   