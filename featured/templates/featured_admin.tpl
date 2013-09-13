{config_load file=featured_lang_conf}
<div id="featured">
	<fieldset>
		<legend>{#PLIGG_featured#}</legend>
		<p>
			This module lets you manage stories that you want to feature on your website. 
		</p>
		<table class="table table-bordered table-condensed">
			<thead>
			<tr class="odd">
				<th style="min-width:75px;">{#PLIGG_featured_ID#}</th>
				<th style="min-width:150px;">{#PLIGG_featured_Title#}</th>	
				<th>{#PLIGG_featured_Description#}</th>
				{* <th style="min-width:75px;text-align:center;">{#PLIGG_featured_Status#}</th> *}
				<th style="min-width:175px;text-align:center;" style="text-align:center;">{#PLIGG_featured_Actions#}</th>
			</tr>	
			</thead>		
			<tbody>
			{section name=featured loop=$news}
			<tr>
				<td style="text-align:center;">{$news[featured].featured_link_id}</td>
				<td>{$news[featured].featured_link_title}</td>
				<td>{$news[featured].featured_description}</td>
				{*
				<td style="text-align:center;">
					<div style="margin-top:10px;" class="featured_active">
						{if $news[featured].featured_enabled eq "Yes"}
							<i class="icon-check icon-2x" title="Yes"></i>
						{else}
							<i class="icon-check-empty icon-2x" title="No"></i>
						{/if}
					</div>
				</td>
				*}
				<td style="text-align:center;">
					<div style="margin:10px 0;" class="featured_actions">
						<a href="#" onclick="window.open('{$featured_URL}&amp;action=view_image&amp;id={$news[featured].featured_id}', null, 'width=300, height=300, top=50, left=50, status=yes, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no');"><i class="icon-camera-retro icon-2x icon-border" title="{#PLIGG_featured_ViewImage#}"></i></a> &nbsp;
						<a href="{$featured_URL}&amp;action=editfeatured&amp;id={$news[featured].featured_id}"><i class="icon-edit icon-2x icon-border" title="{#PLIGG_featured_Edit#}"></i></a> &nbsp;
						<a href="{$featured_URL}&amp;action=manage_news&amp;delete=delete&amp;id={$news[featured].featured_id}"><i class="icon-trash icon-2x icon-border" title="{#PLIGG_featured_Delete#}"></i></a>
					</div>
				</td>
			</tr>
			{/section}	
			</tbody>
		</table>
		<br />
		<a href="{$featured_URL}&amp;action=addfeatured" class="btn btn-primary">{#PLIGG_featured_AddNew#}</a>
	</fieldset>
</div>
{config_load file=featured_pligg_lang_conf}