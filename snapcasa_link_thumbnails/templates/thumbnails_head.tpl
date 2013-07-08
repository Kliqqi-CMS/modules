{literal}
<!-- SnapCasa Link Thumbnails Start -->
<style type="text/css">
	a.screenshot { text-decoration:none; border-bottom:1px dotted #900; }
	a.screenshot:hover { border-bottom-style:solid; color:#900; }
	.tip { border:2px solid #999; }
</style>
<script type="text/javascript">
	/* when the dom is ready... */
	window.addEvent('domready',function() {
		/* tooltips */
		var tips = new Tips();
		var tipURLs = [];
		/* grab all complete linked anchors */
		$$('a[href^="http://"]').each(function(a) {
			/* if it's not on your domain */
			var href = a.get('href');
			if(!href.contains(window.location.host) && !tipURLs.contains(href)) {
				/* vars */
				tipURLs.push(href);
				var url = href.replace(window.location.protocol + '//','');
				/* set tooltip info */
				a.store('tip:title','');
				/* Please replace #### below with your own snapcapa ID. */
				a.store('tip:text','<img src="http://snapcasa.com/get.aspx?code=####&size=l&wait=0&url=' + url + '" />');
				a.addClass('screenshot');
				/* attach tooltip */
				tips.attach(a);
			}
		});
	});
</script>
<!-- SnapCasa Link Thumbnails End -->
{/literal}