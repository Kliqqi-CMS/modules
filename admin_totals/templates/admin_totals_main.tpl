{config_load file=admin_totals_lang_conf}

<table>
	<tr><th>Status</th><th>Total</th></tr>
	{section name=result loop=$results}
		<tr>
			<td>
				{$results[result].name}
			</td>
			<td>
				{$results[result].total}
			</td>
		</tr>
	{/section}
</table>

{if isset($new_results)}
<hr /><h2>Regenerating Totals</h2><hr />
<table>
	<tr><th>Status</th><th>Total</th></tr>
	{section name=result loop=$new_results}
		<tr>
			<td>
				{$results[result].name}
			</td>
			<td>
				{$results[result].total}
			</td>
		</tr>
	{/section}
</table>
{/if}

<hr />
<a href = "{$URL_admin_totals}&action=regen">Regenerate Totals</a>

{config_load file=admin_pligg_totals_lang_conf}