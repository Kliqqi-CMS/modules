{config_load file=age_verification_lang_conf}
<br />
<div style="border:1px solid #ababab;background:#f2f2ca;padding:0 8px 8px 8px;width:95%;">
{if isset($register_agree_error)}<br /><span class="error">{$register_agree_error}</span><br />{/if}
<p>{#PLIGG_AgeVerification_Terms#}</p>
<input type="checkbox" name="agree" value="agree" {if isset($register_agree_checked) && $register_agree_checked eq true} CHECKED{/if}> <strong>{#PLIGG_AgeVerification_Agree#}</strong>
</div>
<br />
{config_load file=age_verification_pligg_lang_conf}