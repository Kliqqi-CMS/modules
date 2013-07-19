<!-- settings.tpl -->
{config_load file=analytics_lang_conf}

<legend>{#Analytics_Settings#}</legend>

{if $templatelite.post.submit && !$msg}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		{#Analytics_Saved#}
    </div>
{elseif $msg}
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert">&times;</button>
		{$msg}
    </div>
{/if}

<form action="" method="POST" id="thisform">
	<p>{#Analytics_Form_Label#}</p>
	<input type="text" name="analytics_id" {if $settings.analytics_id != ''}value="{$settings.analytics_id}"{else}placeholder="UA-#####-#"{/if} size="20" maxlength="10" />
	<input type="submit" name="submit" value="{#Analytics_Form_Submit#}" class="btn btn-primary" />
</form>

{config_load file=analytics_pligg_lang_conf}
<!--/settings.tpl -->