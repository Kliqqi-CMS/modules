{config_load file=pligg_web_toolbar_lang_conf}
<fieldset>
	<legend>{#pligg_web_toolbar_settings#}</legend>

	{if isset($msg)}
		<div style="font-weight:bold;color:#87051B;background:#F3E8BC;border:1px solid #A7A28D;">
			<p>{$msg}</p>
		</div>
	{/if}

	<p>
		<ul>
			<li>{if $pligg_web_toolbar_enabled eq true}<b>{#pligg_web_toolbar_enabled#}</b>{else}<a href="module.php?module=pligg_web_toolbar&action=enable">{#pligg_web_toolbar_enable#}</a>{/if}
				| {if $pligg_web_toolbar_enabled eq false}<b>{#pligg_web_toolbar_disabled#}</b>{else}<a href="module.php?module=pligg_web_toolbar&action=disable">{#pligg_web_toolbar_disable#}</a>{/if}
			</li>
		</ul>
	</p>
	<br />
</fieldset>
{config_load file=pligg_web_toolbar_pligg_lang_conf}