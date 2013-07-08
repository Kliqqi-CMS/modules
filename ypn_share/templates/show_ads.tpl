<center>
<br />

{ypn assign=users_ypn}
{if $users_ypn}

	{* this part shows the users adsense id *}

	<script language="JavaScript" type="text/javascript">
<!--
ctxt_ad_partner = "{$ypn_id}; {* dont change this line *}
ctxt_ad_section = "{$ypn_channel}"; {* dont change this line *}
ctxt_ad_bg = "";
ctxt_ad_width = 468;
ctxt_ad_height = 60;
ctxt_ad_bc = "F5E391";
ctxt_ad_cc = "F9F7EE";
ctxt_ad_lc = "774525";
ctxt_ad_tc = "774525";
ctxt_ad_uc = "999999";
// -->
</script>
<script language="JavaScript" src="http://ypn-js.overture.com/partner/js/ypn.js">
</script>

{else}

	{* this part shows your adsense id *}
<script language="JavaScript" type="text/javascript">
<!--
ctxt_ad_partner = "1989948420"; {*  be sure to put your YPN id here *}
ctxt_ad_section = "69693";
ctxt_ad_bg = "";
ctxt_ad_width = 468;
ctxt_ad_height = 60;
ctxt_ad_bc = "F5E391";
ctxt_ad_cc = "F9F7EE";
ctxt_ad_lc = "774525";
ctxt_ad_tc = "774525";
ctxt_ad_uc = "999999";
// -->
</script>
<script language="JavaScript" src="http://ypn-js.overture.com/partner/js/ypn.js">
</script>
{/if}
</center>