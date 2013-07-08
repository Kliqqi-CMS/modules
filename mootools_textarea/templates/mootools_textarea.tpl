<!-- Start MooTools Textarea -->
<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/modules/mootools_textarea/js/mootools-for-textarea.js"> </script>
<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/modules/mootools_textarea/js/UvumiTextarea-compressed.js"> </script>
<link rel="stylesheet" type="text/css" media="screen" href="{$my_base_url}{$my_pligg_base}/modules/mootools_textarea/css/uvumi-textarea.css" />
{if $pagename eq "submit"}
	{literal}
	<script type="text/javascript">
		new UvumiTextarea({
			selector:'textarea.bodytext',
			maxChar:{/literal}{php} echo maxStoryLength; {/php}{literal}
		});
	</script>
	{/literal}
{else}
	{literal}
	<script type="text/javascript">
		new UvumiTextarea({
			selector:'textarea#comment_content',
			maxChar:{/literal}{php} echo maxCommentLength; {/php}{literal}
		});
	</script>
	{/literal}
{/if}1
<!-- End MooTools Textarea -->