<table style="border:none;">
	{section name=fields loop=$users_extra_fields_field}
	{if $users_extra_fields_field[fields].show_to_user eq TRUE}
		{if {$users_extra_fields_field[fields].value neq ""}
		<tr>
			{*================================*}
			{* First we put in a table cell the description of the field, which is defined in *}
			{* profiles_settings.php *}
			{*================================*}

			<td><B>{$users_extra_fields_field[fields].show_to_user_text}</B></td>

			{*================================*}
			{* Now we check the value of the stored field and we convert it to *}
			{* a description that applies to the checked option of the radio button *}
			{* to understand it better, check the code of the radio button option in *}
			{* /modules/users_extra_fields/templates/profile_center_fields.tpl *}
			{*================================*}

			{if $users_extra_fields_field[fields].show_to_user_text eq 'Subscription:'}
				{if $users_extra_fields_field[fields].value eq "0"}
					<td>Hourly</td>
				{elseif $users_extra_fields_field[fields].value eq "1"}
					<td>Daily</td>
				{elseif $users_extra_fields_field[fields].value eq "2"}
					<td>Weekly</td>
				{elseif $users_extra_fields_field[fields].value eq "3"}
					<td>No Notifications</td>
				{/if}

			{*================================*}
			{* If the field is for Bio, then we put it in a READONLY textarea *}
			{*  to maintain the format of the text *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Bio:'}
				<td>
					<textarea name="{$users_extra_fields_field[fields].name}" rows="10" cols="25" id="bio" WRAP=SOFT  READONLY>{$users_extra_fields_field[fields].value}</textarea>
				</td>

			{*================================*}
			{* If none of the above applies, then we just put the value as plain text *}
			{*  in the table cell *}
			{*================================*}

			{else}
				<td>{$users_extra_fields_field[fields].value}</td>
			{/if}
		</tr>
		{/if}
	{/if}
	{/section}
</table>
