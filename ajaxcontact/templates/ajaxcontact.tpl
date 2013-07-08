{config_load file=ajaxcontact_lang_conf}

{literal}
	<style type='text/css' media='screen,projection'>
	<!--
	fieldset { border:0;margin:0;padding:0; }
	label { display:block; }
	input.text,textarea { width:300px;font:12px/12px 'courier new',courier,monospace;color:#333;padding:3px;margin:1px 0;border:1px solid #ccc; }
	input.submit { padding:2px 5px;font:bold 12px/12px verdana,arial,sans-serif; }
	-->
	</style>
{/literal}

	<h2>{#PLIGG_Ajax_Contact#}</h2>
	<p id="loadBar" style="display:none;">
		<strong>{#PLIGG_Ajax_Contact_Sending_Email#}</strong> <img src="{$ajaxcontact_path}img/loading.gif" alt="Loading..." title="Sending Email" align="absmiddle" />
		<br /><br />
	</p>
	<p id="emailSuccess" style="display:none;">
		<strong style="color:green;">{#PLIGG_Ajax_Contact_Sending_Email_Success#}</strong>
		<br /><br />
	</p>
	
	<div id="contactFormArea">
		<form action="{$ajaxcontact_path}scripts/contact.php" method="post" id="cForm">
			<fieldset>
				{#PLIGG_Ajax_Contact_Name#}:<br />
				<input class="text" type="text" size="25" name="posName" id="posName" /><br /><br />
				{#PLIGG_Ajax_Contact_Email#}:<br />
				<input class="text" type="text" size="25" name="posEmail" id="posEmail" /><br /><br />
				{#PLIGG_Ajax_Contact_Regarding#}:<br />
				<input class="text" type="text" size="25" name="posRegard" id="posRegard" /><br /><br />
				{#PLIGG_Ajax_Contact_Message#}:<br />
				<textarea cols="50" rows="5" name="posText" id="posText"></textarea><br /><br />
				<label for="selfCC">
					<input type="checkbox" name="selfCC" id="selfCC" value="send" /> {#PLIGG_Ajax_Contact_Send_CC#}
				</label><br />
				<label>
					<input class="submit" type="submit" name="sendContactEmail" id="sendContactEmail" value="{#PLIGG_Ajax_Contact_Send_Email#}" />
				</label>
			</fieldset>
		</form>
	</div>

{config_load file=ajaxcontact_pligg_lang_conf}