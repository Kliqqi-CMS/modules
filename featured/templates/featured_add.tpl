{config_load file=featured_lang_conf}
<div id="featured">
	<fieldset>
		<legend><a href="./module.php?module=featured">{#PLIGG_featured#}</a></legend>
		<form action="{$featured_URL}&amp;action=addfeatured" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr class="odd">
					<th colspan="3">{#PLIGG_featured_AddNew#}</th>
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
						<td width="120" style="font-weight:bold">{#PLIGG_featured_ID#}</td>
						<td><input type="text" id="featured_link_id" name="featured_link_id" /></td>
						<td rowspan="5" valign="top">
							<ul>
								<li>All fields are required.</li>
								<li>
									<strong>Featured News ID</strong> is the <em>ID</em> of the news submitted by the users. To know
									what is the <em>ID</em>, logout first from your Pligg site then point your mouse to the
									&quot;<strong>Vote</strong>&quot; link - don't click. When pointing your mouse, you can see in the
									<a href="http://www.jegsworks.com/Lessons/web/basics/statusbar.htm" target="_blank">status bar</a>
									something like:<br />
									<strong>javascript:vote(0,<span class="red">3</span>,0,'d5ec594f11a236ffe5857c8160c5b267',10)</strong><br />
									The second value above ( <em>which is <span class="red"><strong>3</strong></span></em> ) is the News ID.
								</li>
								<li>
									<strong>Story Title</strong>. Insert the title you would like to use for the featured story.
								</li>
								<li>
									<strong>Story Description</strong>. Insert a description for the featured story.
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold">{#PLIGG_featured_Title2#}</td>
						<td><input type="text" id="featured_link_title" name="featured_link_title" style="width:500px"/></td>
					</tr>
					<tr>
						<td valign="top" style="font-weight:bold">{#PLIGG_featured_Description#}</td>
						<td><textarea id="featured_description" name="featured_description" style="width:500px;height:300px;"></textarea></td>
					</tr>
					<tr>
						<td style="font-weight:bold">{#PLIGG_featured_Status#}?</td>
						<td>
							<input type="radio" id="status" name="status" value="Yes" checked="checked" />Yes
							&nbsp; &nbsp; &nbsp; 
							<input type="radio" name="status" value="No" />No
						</td>
					</tr>
					<tr>
						<td>{#PLIGG_Featured_Image#}</td>
						<td><input type="file" name="image" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="submit" value="Add Featured News" /></td>
					</tr>
				</tbody>
			</table>
		</form>
		<br />
		<a href="{$featured_URL}"><img src="{$featured_path}/images/manage.gif" alt="Manage Featured News" /></a>
	</fieldset>
</div>
{config_load file=featured_pligg_lang_conf}