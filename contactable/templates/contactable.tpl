{if $contactable.contactable_mail}
	<!-- contactable.tpl -->
	{config_load file=contactable_lang_conf}
	
		<div id="my-contact-div">
			<!-- contactable html placeholder -->
		</div>

		<link rel="stylesheet" href="{$my_pligg_base}/modules/contactable/templates/contactable.css" type="text/css" />
		<script type="text/javascript" src="{$my_pligg_base}/modules/contactable/templates/jquery.contactable.js"></script>
		
		{literal}
		<script>
			jQuery(function(){
				jQuery('#my-contact-div').contactable(
				{
					subject: 'feedback URL:'+location.href,
					url: '{/literal}{$my_pligg_base}{literal}/modules/contactable/mail.php',
					{/literal}
					name: '{#Contactable_Name#}',
					email: '{#Contactable_Email#}',
					dropdownTitle: '{#Contactable_Concerning#}',
					dropdownOptions: [{#Contactable_Topics#}],
					message : '{#Contactable_Message#}',
					submit : '{#Contactable_Form_Submit#}',
					recievedMsg : '{#Contactable_Received#}',
					notRecievedMsg : '{#Contactable_Not_Received#}',
					disclaimer: '{#Contactable_Disclaimer#}',
					{literal}
					hideOnSubmit: true
				});
			});
		</script>
		{/literal}
		
	{config_load file=contactable_pligg_lang_conf}
	<!--/ contactable.tpl -->
{/if}
