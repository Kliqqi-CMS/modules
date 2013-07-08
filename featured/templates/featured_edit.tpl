{config_load file=featured_lang_conf}
<div id="featured">
	<fieldset>
		<legend><a href="./module.php?module=featured">{#PLIGG_featured#}</a></legend>
		<form action="{$featured_URL}&amp;action=editfeatured" method="post" enctype="multipart/form-data">
			<input type="hidden" value="{$news[0].featured_id}" id="id" name="id">
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr class="odd">
					<th colspan="2">{#PLIGG_featured_Edit2#}</th>
				</tr>
				</thead>
				<tbody>
				{if $msg ne ''}
					<tr>
						<td colspan="3" style="padding-top:5px;background:#D5FFD5;border:1px solid #497C49;"><div class="success">{$msg}</div></td>
					</tr>
				{/if}
				{if $err ne ''}
					<tr>
						<td colspan="3" style="padding-top:5px;background:#EBC1C1;border:1px solid #991C1C;"><div class="error">{$err}</div></td>
					</tr>
				{/if}
					<tr>
						<td width="200" style="font-weight:bold;">{#PLIGG_featured_ID#}</td>
						<td><input type="text" id="featured_link_id" name="featured_link_id" value="{$news[0].featured_link_id}" /></td>
					</tr>
					<tr>
						<td style="font-weight:bold;">{#PLIGG_featured_Title2#}</td>
						<td><input type="text" id="featured_link_title" name="featured_link_title" value="{$news[0].featured_link_title}" style="width:500px;" /></td>
					</tr>
					<tr>
						<td valign="top" style="font-weight:bold;">{#PLIGG_featured_Description#}</td>
						<td><textarea type="text" id="featured_description" name="featured_description" style="width:500px;height:300px;">{$news[0].featured_description}</textarea></td>
					</tr>
					<tr>
						<td style="font-weight:bold;">{#PLIGG_featured_Status#}?</td>
						<td>
							<input type="radio" id="status" name="status" value="Yes" {if $news[0].featured_enabled eq 'Yes'}checked="checked"{/if} />Yes
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="radio" name="status" value="No" {if $news[0].featured_enabled eq 'No'}checked="checked"{/if} />No
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">{#PLIGG_featured_Image#}</td>
						<td><input type="file" name="image" /></td>
					</tr>
					<tr>
						<td valign="top">{#PLIGG_featured_CurrentImage#}</td>
						<td><img src="{$featured_URL}&amp;action=view_image&amp;id={$news[0].featured_id}" alt="{$news[0].featured_link_title}" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="submit" value="Edit featured News" /></td>
					</tr>
				</tbody>
			</table>
		</form>
		<br />
		<p><a href="{$featured_URL}"><img src="{$featured_path}/images/manage.gif" alt="Manage featured News" /></a></p>
	</fieldset>
</div>
{config_load file=featured_pligg_lang_conf}