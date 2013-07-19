{config_load file=dropbox_backup_lang_conf}

{if $error}
	<div class="alert alert-error">
		<a data-dismiss="alert" class="close">&times;</a>
		{$error}
    </div>
{elseif $templatelite.post.submit}
	<div class="alert alert-success">
		<a data-dismiss="alert" class="close">&times;</a>
		{#PLIGG_Dropbox_Backup_Saved#}
    </div>
{/if}

<legend>{#PLIGG_Dropbox_Backup#}</legend>
<p>{#PLIGG_Dropbox_Backup_Instructions#}</p>
<p>{#PLIGG_Dropbox_Backup_Error_Warning#}</p>
<br />
<div class="span8">
	<form action="" method="POST" id="thisform">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>{#PLIGG_Dropbox_Backup_Setting#}</th>
					<th>{#PLIGG_Dropbox_Backup_Value#}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Email#}: </label></td>
					<td><input type="text" name="dropbox_backup_email" class="span12" value="{$settings.dropbox_backup_email}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Password#}:</label></td>
					<td>
						<input type="password" name="dropbox_backup_pass" class="span12" value="" />
					</td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Directory#}: </label></td>
					<td>
						<input type="text" name="dropbox_backup_dir" class="span12" value="{$settings.dropbox_backup_dir}" />
						<span class="help-inline">(Optional) Ex. /pligg will put the files in a folder named "pligg".</span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit" value="{#PLIGG_Dropbox_Backup_Perform#}" class="btn btn-success" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

{if $message}
	<div class="span8">
		<div class="alert alert-{$status}">
			<a data-dismiss="alert" class="close">&times;</a>
			{$message}
		</div>
	</div>
{/if}

{config_load file=dropbox_backup_pligg_lang_conf}