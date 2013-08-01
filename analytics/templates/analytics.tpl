{if $settings.analytics_id}
	<!-- Google analytics.tpl -->
	{config_load file=analytics_lang_conf}
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', {$settings.analytics_id}]);
		  _gaq.push(['_setDomainName', '{$my_base_url|replace:'www.':''|replace:'https://':''|replace:'http://':''}']);
		  _gaq.push(['_trackPageview']);
		{literal}
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		{/literal}
		</script>
	{config_load file=analytics_pligg_lang_conf}
	<!--/ Google analytics.tpl -->
{/if}
