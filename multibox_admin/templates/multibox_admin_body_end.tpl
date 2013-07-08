  {literal}
	<script type="text/javascript">
	    var box = {};
        window.addEvent('domready', function(){
        box = new MultiBox('mb', {
        descClassName: 'multiBoxDesc',
        useOverlay: true,
			onOpen: function(){},
			onClose: function(){}
        });
        });
		
		var box2 = {};
        window.addEvent('domready', function(){
        box2 = new MultiBox('onetime', {
		descClassName: 'multiBoxDesc',
        useOverlay: true,
			onOpen: function(){},
			onClose: function(){window.location = "./admin_modules.php?action=disable&module=Hello%20World"}
        });
	if ($('autopop'))
		box2.open($('autopop'));
        });
	</script>
  {/literal}