{config_load file=template_management_lang_conf}

<fieldset>
	<legend><img src="{$template_management_image_path}layout.png" align="absmiddle"/> {#PLIGG_Template_Management_BreadCrumb#}</legend>

	{if $msg neq ""}
		<h2>{$msg}</h2>
	{/if}


	<h3>{#PLIGG_Template_Management_DownloadATemplate#}</h3>
	{if $can_write_to_template_folder eq true}
		View a list of templates available for download <a href = "{$URL_template_management}&action=viewonline">here</a>.<br />
		or <br />
		{#PLIGG_Template_Management_DownloadEnterUrl#}<br />
		<form>
			<input type="hidden" name="module" value="template_management">
			<input type="hidden" name="action" value="download">
			<input type="text" name="path" size="75"><input type="submit" value="{#PLIGG_Template_Management_Download#}"><br /><br />
		</form>
	{else}
		{#PLIGG_Template_Management_CHMOD#}
	{/if}

	<h3>{#PLIGG_Template_Management_Installed_Templates#}</h3>

		{ foreach value=template from=$default_template_details }
			{include file=$template_management_tpl_path."template_details.tpl"}
		{ /foreach }

	{* show only if there are templates available other than the default *}
	{if count($available_template_details) gt 0}
		<h3>{#PLIGG_Template_Management_Available_Templates#}</h3>

			{ foreach value=template from=$available_template_details }
				{include file=$template_management_tpl_path."template_details.tpl"}
			{ /foreach }
	{/if}

	{* show only if there are incompatible templates *}
	{if count($incompatible_template_details) gt 0}
		<h3>{#PLIGG_Template_Management_Incompatible_Templates#}</h3>
		{#PLIGG_Template_Management_Incompatible_Text#}<br />

			{ foreach value=template from=$incompatible_template_details }
				{include file=$template_management_tpl_path."template_details.tpl"}
			{ /foreach }
	{/if}

	{* show only if there are packed templates that have not yet been extracted *}
	{if count($packed_templates) gt 0}
		<h3>{#PLIGG_Template_Management_PackedTemplatesNotExtracted#}</h3>

		{if $can_write_to_template_folder eq true}
			{ foreach value=template from=$packed_templates }
				{$template} <img src="{$template_management_image_path}package_go.png"> <a href = "module.php?module=template_management&action=unpack&template={$template}">{#PLIGG_Template_Management_Extract#}</a> | <img src="{$template_management_image_path}cross.png"> <a href = "module.php?module=template_management&action=deletePacked&template={$template}">{#PLIGG_Template_Management_DeletePacked#}</a><br />
			{ /foreach }
		{else}
			{#PLIGG_Template_Management_CHMOD#}
		{/if}

	{/if}

</fieldset>
{config_load file=template_management_pligg_lang_conf}
