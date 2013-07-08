/**************************************************************

	Script		: Overlay
	Version		: 1.2
	Authors		: Samuel birch
	Desc		: Covers the window with a semi-transparent layer.
	Licence		: Open Source MIT Licence

	Modified: Leonardo Di Lella (leonardo@dilella.org) - MooTools 1.2 support

**************************************************************/

var Overlay = new Class({
	
	getOptions: function(){
		return {
			colour: '#000',
			opacity: 0.7,
			zIndex: 1,
			container: document.body,
			onClick: new Class()
		};
	},

	initialize: function(options){
		this.setOptions(this.getOptions(), options);
		
		this.options.container = $(this.options.container);
		
		this.container = new Element('div').setProperty('id', 'OverlayContainer').setStyles({
			position: 'absolute',
			left: '0px',
			top: '0px',
			width: '100%',
			visibility: 'hidden',
			overflow: 'hidden',
			zIndex: this.options.zIndex
		}).inject(this.options.container,'inside');
		
		this.iframe = new Element('iframe').setProperties({
			'id': 'OverlayIframe',
			'name': 'OverlayIframe',
			'src': 'javascript:void(0);',
			'frameborder': 1,
			'scrolling': 'no'
		}).setStyles({
			'position': 'absolute',
			'top': 0,
			'left': 0,
			'width': '100%',
			'height': '100%',
			'filter': 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)',
			'opacity': 0,
			'zIndex': 1
		}).inject(this.container,'inside');
		
		this.overlay = new Element('div').setProperty('id', 'Overlay').setStyles({
			position: 'absolute',
			left: '0px',
			top: '0px',
			width: '100%',
			height: '100%',
			zIndex: 2,
			backgroundColor: this.options.colour
		}).inject(this.container,'inside');
		
		this.container.addEvent('click', function(){
			this.options.onClick();
		}.bind(this));
		
		this.fade = new Fx.Morph(this.container, 'opacity').set(0);
		this.position();
		
		window.addEvent('resize', this.position.bind(this));
	},
	
	position: function(){ 
		if(this.options.container == document.body){ 
			var h = document.getScrollSize().x+'px'; 
			//this.container.setStyles({top: '0px', height: h});
			this.container.setStyles({top: '0px', height: '100%'});
		}else{ 
			var myCoords = this.options.container.getCoordinates(); 
			this.container.setStyles({
				top: myCoords.top+'px', 
				height: myCoords.height+'px', 
				left: myCoords.left+'px', 
				width: myCoords.width+'px'
			}); 
		} 
	},
	
	show: function(){
		this.fade.start({'opacity':[0,this.options.opacity], 'visibility':'visible'});
	},
	
	hide: function(){
		this.fade.start({'opacity':[0,this.options.opacity], 'visibility':'hidden'});
	}
	
});
Overlay.implement(new Options);

/*************************************************************/
