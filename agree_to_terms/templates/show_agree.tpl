{if $pagename eq "register"}
{if isset($register_agree_error)}<br /><span class="error">{$register_agree_error}</span><br /><br />{/if}
I have read the terms and I agree to them.<br />
<input type="checkbox" name="agree" value="agree" {if isset($register_agree_checked) && $register_agree_checked eq true} CHECKED{/if}> I Agree
{/if}