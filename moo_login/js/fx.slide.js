/* FX.Slide */
/* toggle window for the login section */
/* Works with mootools-release-1.2 */
/* more info at http://demos.mootools.net/Fx.Slide */

window.addEvent('domready', function(){

	$('login').setStyle('height','auto');
	var mySlide = new Fx.Slide('login').hide();  //starts the panel in closed state  

    $('toggleLogin').addEvent('click', function(e){
		e = new Event(e);
		mySlide.toggle();
		e.stop();
	});

    $('closeLogin').addEvent('click', function(e){
		e = new Event(e);
		mySlide.slideOut();
		e.stop();
	});

});

window.addEvent('domready', function(){

	$('search').setStyle('height','auto');
	var mySlide = new Fx.Slide('search').hide();  //starts the panel in closed state  

    $('toggleSearch').addEvent('click', function(e){
		e = new Event(e);
		mySlide.toggle();
		e.stop();
	});

    $('closeSearch').addEvent('click', function(e){
		e = new Event(e);
		mySlide.slideOut();
		e.stop();
	});

});



