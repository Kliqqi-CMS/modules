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
					name: 'Name',
					email: 'Email',
					dropdownTitle: 'Issue',
					dropdownOptions: ['General', 'Website bug', 'Feature request'],
					message : 'Message',
					submit : 'SEND',
					recievedMsg : 'Thank you for your message',
					notRecievedMsg : 'Sorry but your message could not be sent, try again later',
					disclaimer: 'Please feel free to get in touch, we value your feedback',
					hideOnSubmit: true
				});
			});
		</script>
		{/literal}
		
	{config_load file=contactable_pligg_lang_conf}
	<!--/ contactable.tpl -->
{/if}
