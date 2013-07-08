<!-- Start MooTools Share -->
<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/modules/mootools_share/templates/mootools_share.css" media="screen" />
{literal}
<script type="text/javascript">
(function($){
	window.addEvent('domready',function() {
		$$('a.share').each(function(a){
			//containers
			var storyList = a.getParent();
			var shareHover = storyList.getElements('div.share-hover')[0];
			shareHover.set('opacity',0);
			//show/hide
			a.addEvent('mouseenter',function() {
					shareHover.setStyle('display','block').fade('in');
			});
			shareHover.addEvent('mouseleave',function(){
				shareHover.fade('out');
			});
			storyList.addEvent('mouseleave',function() {
				shareHover.fade('out');
			});
		});
	});
})(document.id);
</script>
{/literal}
<!-- End MooTools Share -->