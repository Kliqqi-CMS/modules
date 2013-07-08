{config_load file=featured_lang_conf}
<div id="featured">
	<fieldset>
		<legend>{#PLIGG_featured#}</legend>
		<p>
			This module lets you manage stories that you want to feature on your website. 
		</p>
		<table cellpadding="0" cellspacing="0">
			<thead>
			<tr class="odd">
				<th width="60px">{#PLIGG_featured_ID#}</th>
				<th width="150px">{#PLIGG_featured_Title#}</th>	
				<th>{#PLIGG_featured_Description#}</th>
				<th width="50px">{#PLIGG_featured_Status#}</th>
				<th width="200px" style="text-align:center;">{#PLIGG_featured_Actions#}</th>
			</tr>	
			</thead>		
			<tbody>
			{section name=featured loop=$news}
			<tr>
				<td>{$news[featured].featured_link_id}</td>
				<td>{$news[featured].featured_link_title}</td>
				<td>{$news[featured].featured_description}</td>
				<td>
					{if $news[featured].featured_enabled eq "Yes"}
					<img src="{$featured_path}/images/enabled.gif" alt="Yes" />
					{else}
					<img src="{$featured_path}/images/disabled.png" alt="No" />
					{/if}
				</td>
				<td>
					<a href="#" onclick="window.open('{$featured_URL}&amp;action=view_image&amp;id={$news[featured].featured_id}', null, 'width=300, height=300, top=50, left=50, status=yes, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no');">{#PLIGG_featured_ViewImage#}</a> &nbsp;|&nbsp;
					<a href="{$featured_URL}&amp;action=editfeatured&amp;id={$news[featured].featured_id}">{#PLIGG_featured_Edit#}</a> &nbsp;|&nbsp;
					<a href="{$featured_URL}&amp;action=manage_news&amp;delete=delete&amp;id={$news[featured].featured_id}">{#PLIGG_featured_Delete#}</a>
				</td>
			</tr>
			{/section}	
			</tbody>
		</table>
		<br />
		<a href="{$featured_URL}&amp;action=addfeatured"><img src="{$featured_path}/images/add.gif" alt="Add featured News" /></a>
	</fieldset>
</div>
{config_load file=featured_pligg_lang_conf}