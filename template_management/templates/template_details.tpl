<a onclick="new Effect.toggle('sTemp{$template.name}{$template.version}','blind', {ldelim}queue: 'end'{rdelim});"> + <b>{$template.name}</b> v{$template.version}</a> 

<br />

<div id="sTemp{$template.name}{$template.version}" style="margin: 5px 0 0 0; line-height: {$tags_max_pts}pt; {if $template.folder neq $current_template}display:none;{/if}">
	{if $template.folder neq $current_template}
		{if $template.can_install eq true}
			<img src="{$template_management_image_path}tick.png"> <a href = "module.php?module=template_management&action=setDefault&template={$template.folder}">{#PLIGG_Template_Management_SetAsDefault#}</a><br />
		{else}
			<img src="{$template_management_image_path}tick.png"> <a href = "module.php?module=template_management&action=setDefault&template={$template.folder}">{#PLIGG_Template_Management_SetAsDefault#}</a> <b>{#PLIGG_Template_Management_SetAsDefaultOverride#}</b><br />
		{/if}
	{/if}
	<img src="{$template_management_image_path}book_open.png"> {#PLIGG_Template_Management_Tpl_Description#} {$template.desc}<br />
	<img src="{$template_management_image_path}user.png"> {#PLIGG_Template_Management_Tpl_Author#} {$template.author}<br />
	<img src="{$template_management_image_path}information.png"> {#PLIGG_Template_Management_Tpl_Support#} <a href="{$template.support}" target="_blank">{$template.support}</a><br />
	{if $template.folder neq "yget" && $template.folder neq $current_template}
		<img src="{$template_management_image_path}cross.png"> <a href = "module.php?module=template_management&action=delete&template={$template.folder}">{#PLIGG_Template_Management_DeleteTemplate#}</a>
	{/if}

	{if $template.allow_pack_and_unpack eq true}
		<hr />
		{if $can_write_to_template_folder eq true}
			{if $template.is_packed eq "0"}
				<img src="{$template_management_image_path}package.png"> <a href = "{$template.URL_pack}">{#PLIGG_Template_Management_PackThis#}</a>
			{else}
				<img src="{$template_management_image_path}package.png"> {#PLIGG_Template_Management_HasBeenPacked#} {$template.is_packed}<br />
				<img src="{$template_management_image_path}package_go.png"> <a href = "{$template.is_packed}">{#PLIGG_Template_Management_DownloadPacked#}</a>
			{/if}
		{else}
			{#PLIGG_Template_Management_CHMOD#}
		{/if}
	{/if}
	<br /><br />
</div>

