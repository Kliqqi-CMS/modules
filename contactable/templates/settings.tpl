<!-- settings.tpl -->
{config_load file=contactable_lang_conf}

<legend>{#Contactable_Settings#}</legend>

{if $templatelite.post.submit && !$msg}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		{#Contactable_Saved#}
    </div>
{elseif $msg}
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert">&times;</button>
		{$msg}
    </div>
{/if}

<form action="" method="POST" id="thisform">
	<p>{#Contactable_Form_Label#}</p>
	<div class="col-lg-5">
		<div class="input-group">
			<input type="text" class="form-control" name="contactable_mail" {if $contactable.contactable_mail != ''}value="{$contactable.contactable_mail}"{else}placeholder="sample@mail.com"{/if} size="40" maxlength="50" />
			<span class="input-group-btn">
				<input class="btn btn-primary" type="submit" name="submit" value="{#Contactable_Form_Submit#}" />
			</span>
		</div><!-- /input-group -->
	</div>
</form>
<div class="clearfix"></div>
<hr />

<p>If you want to edit the form labels, either edit the module's language file (/modules/contactable/lang.conf) or <a href="/module.php?module=admin_language#contactable">edit the file using the "Modify Language" module</a> for Pligg.</p>

{config_load file=contactable_pligg_lang_conf}
<!--/settings.tpl -->