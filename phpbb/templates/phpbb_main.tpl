{config_load file=phpbb_lang_conf}

{literal}
	<style type="text/css">
		td {line-height:18px;}
		label {font-weight:bold;}
	</style>
{/literal}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<fieldset><legend> <a href="http://forums.pligg.com/pligg-modules/16319-phpbb-integration-module-2.html">{#PLIGG_phpbb#}</a></legend>
<p>{#PLIGG_phpbb_Instructions_1#}</p>
<p>{#PLIGG_phpbb_Instructions_2#}</p>
<br />
	<form action="" method="POST" id="thisform">
		<table border="0">
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_DB#}:</label><br />{#PLIGG_phpbb_DB_Example#}</td><td><input type="text" name="phpbb_db" id="phpbb_db" size="66" value="{$settings.db}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_User#}: </label></td><td><input type="text" name="phpbb_user" id="phpbb_user" size="66" value="{$settings.user}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Password#}: </label></td><td><input type="text" name="phpbb_pass" id="phpbb_pass" size="66" value="{$settings.pass}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Host#}: </label></td><td><input type="text" name="phpbb_host" id="phpbb_host" size="66" value="{$settings.host}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Cookie_Name#}:</label><br />{#PLIGG_phpbb_Cookie_Name_Example#}</td><td><input type="text" name="cookie_name" id="cookie_name" size="66" value="{if $settings.cookie_name==''}phpbb{else}{$settings.cookie_name}{/if}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Cookie_Path#}: </label></td><td><input type="text" name="cookie_path" id="cookie_path" size="66" value="{if $settings.cookie_path==''}/{else}{$settings.cookie_path}{/if}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Cookie_Domain#}: </label></td><td><input type="text" name="cookie_domain" id="cookie_domain" size="66" value="{$settings.cookie_domain}" style="width: 420px;"/></td>
		</tr>
{*
		<tr>
		<td width="175"><label>{#PLIGG_phpbb_Cookie_Secure#}: </label></td><td><input type="checkbox" name="cookie_secure" id="cookie_secure" value="1" {if $settings.cookie_secure}checked{/if}/></td>
		</tr>
*}
		<tr>
		<td><label>{#PLIGG_phpbb_Default_Group#}: </label></td><td><select name="phpbb_group" style="width: 420px;">
			{foreach from=$phpbb_groups item=group}
				<option value='{$group.0}' {if $settings.group_id==$group.0}selected{/if}>{$group.1}</option>
			{/foreach}
			</select></td>
		</tr>
	 	<tr><td colspan="2">
		<div class="submitbuttonfloat">
		<br />
			<input type="submit" name="submit" value="{#PLIGG_phpbb_Submit#}" class="log2" /> 
		</div>
		</td></tr>
		</table>
		<a href="?module=phpbb&mode=convert">{#PLIGG_phpbb_Convert_All#}</a>
	</form>
</fieldset>


{config_load file="/languages/lang_".$pligg_language.".conf"}
