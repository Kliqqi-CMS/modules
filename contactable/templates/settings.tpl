<!-- settings.tpl -->
{config_load file=contactable_lang_conf}

<legend>{#Contactable_Settings#}</legend>

{if $templatelite.post.submit && !$msg}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		{#Contactable_Saved#}
		You may need to <a class="btn btn-mini" href="">refresh the page</a> to see the latest changes.
    </div>
{elseif $msg}
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert">&times;</button>
		{$msg}
    </div>
{/if}

<form action="" method="POST" id="thisform">
	<p>{#Contactable_Form_Label#}</p>
	<input type="text" name="contactable_mail" {if $contactable.contactable_mail != ''}value="{$contactable.contactable_mail}"{else}placeholder="sample@mail.com"{/if} size="40" maxlength="50" />
	<input type="submit" name="submit" value="{#Contactable_Form_Submit#}" class="btn btn-primary" />
</form>

{config_load file=contactable_pligg_lang_conf}
<!--/settings.tpl -->