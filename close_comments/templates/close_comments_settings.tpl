{config_load file=close_comments_lang_conf}

{if $templatelite.post.submit}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		Module Settings have been Saved!
    </div>
{/if}
{if $module_error}
	<div class="alert alert-danger">
		<button class="close" data-dismiss="alert">&times;</button>
		{$module_error}
    </div>
{/if}

<legend>Close Comments</legend>
<p>This module allows you to hide the comment form from view when you want to prevent more comments from being posted on an article. You can disable comments by either clicking on an Admin link that appears on the story page, or you can choose to automatically close comments after a certain length of time.</p>

<link rel="stylesheet" type="text/css" media="screen" href="{$my_base_url}{$my_pligg_base}/modules/close_comments/templates/bootstrap-select.min.css">
<script src="{$my_base_url}{$my_pligg_base}/modules/close_comments/templates/bootstrap-select.min.js"></script>

<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
		<tr>
			<td width="200"><label style="text-align:right;">Close Method:</label></td>
			<td>
				<select class="selectpicker show-tick span9" name="close_comment_method">
					<option value="time"{if $settings.method eq "time"} selected{/if}>Automatically Close Older Articles</option>
					<option value="manual"{if $settings.method eq "manual"} selected{/if}>Manually Select Articles</option>
					<option value="both"{if $settings.method eq "both"} selected{/if}>Both Automatic AND Manual Closing</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="200">
				<label>
					Close After This Many Minutes:<br />
					<span class="help-inline">Sample Numbers:<ul><li>1440 = 1 Day</li><li>10080 = 1 Week</li><li>43829 = ~1 Month</li><li>525600 = ~1 Year</li></ul></span> 
				</label>
			</td>
			<td><input type="text" name="close_comment_time" class="span2" value="{if $settings.time eq ""}0{else}{$settings.time}{/if}" size="40"/></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
			</td>
		</tr>
	</table>
</form>

{literal}
<script type="text/javascript">
	$('select').selectpicker();
</script>
{/literal}

{config_load file="/languages/lang_".$pligg_language.".conf"}