// ScrollTo Plugin 1.4.2 | Copyright (c) 2007-2009 Ariel Flesler | GPL/MIT License
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

c2 = {
	numModules: 0,
	container: null,
	arrow: null,
	linkClicked: null,
	resizeTimeout: null,
	resizeTimer: null,
	shadowTimer: null,
	statusText: null,

	init: function() {
		c2.numModules = jQuery( 'div.c2-module' ).not( '.placeholder' ).size();
		c2.container = jQuery( 'div.module-container' );

		c2.level_modules();
		c2.level_placeholders();
		c2.level_placeholders_on_resize();

		jQuery( 'a.more-info-link', 'div.c2-module' ).bind( 'click', function(e) {
			e.preventDefault();
			c2.hide_shadows();

			if ( c2.linkClicked && c2.linkClicked.parents( 'div.c2-module' ).attr( 'id' ) == jQuery(this).parents( 'div.c2-module' ).attr( 'id' ) ) {
				c2.close_learn_more( function() { c2.show_shadows(); } );
			} else {
				c2.linkClicked = jQuery(this);
				c2.insert_learn_more( jQuery(this).parents( 'div.c2-module' ), function() { c2.show_shadows(); } );
				jQuery( 'a.c2-deactivate-button' ).hide();
				jQuery( 'a.c2-configure-button' ).show();
				c2.linkClicked.parents( 'div.c2-module' ).children( '.c2-module-actions' ).children( 'a.c2-deactivate-button' ).show();
				c2.linkClicked.parents( 'div.c2-module' ).children( '.c2-module-actions' ).children( 'a.c2-configure-button' ).hide();
			}
		} );
		
		jQuery( window ).bind( 'resize', function() {
			c2.hide_shadows();
			
			clearTimeout( c2.shadowTimer );
			c2.shadowTimer = setTimeout( function() { c2.show_shadows(); }, 200 );
		});

		jQuery( 'a#c2-debug' ).bind( 'click', function(e) {
			e.preventDefault();
			c2.toggle_debug();
		});
		
		jQuery( '#c2-disconnect a' ).hover( function() {
			c2.statusText = jQuery( this ).html();
			jQuery(this).html( jQuery( '#c2-disconnect span' ).html() );
			jQuery(this).hide().fadeIn(100);
		}, function() {
			jQuery(this).html( c2.statusText );
			jQuery(this).hide().fadeIn(100);
			c2.statusText = null;
		} );
	},

	level_modules: function() {
		var max_height = 0;

		// Get the tallest module card and set them all to be that tall.
		jQuery( 'div.c2-module', 'div.module-container' ).each( function() {
			max_height = Math.max( max_height, jQuery(this).height() );
		} ).height( max_height );
	},

	level_placeholders: function( w ) {
		jQuery( 'div.placeholder' ).show();

		var containerWidth = c2.container.width(),
		    needed = 3 * parseInt( containerWidth / 242, 10 ) - c2.numModules

		if ( c2.numModules * 242 > containerWidth )
			jQuery( 'div.placeholder' ).slice( needed ).hide();
		else
			jQuery( 'div.placeholder' ).hide();
	},

	level_placeholders_on_resize: function() {
		jQuery( window ).bind( 'resize', function() {
			if ( c2.resizeTimer ) {
				return;
			}

			c2.resizeTimer = setTimeout( function() {
				c2.resizeTimer = false;
				c2.level_placeholders();
				c2.level_placeholders_on_resize();
			}, 100 );
		} );	
	},

	insert_learn_more: function( card, callback ) {
		var perRow = parseInt( c2.container.width() / 242, 10 );
		var cardPosition = 0;

		// Get the position of the card clicked.
		jQuery( 'div.c2-module', 'div.module-container' ).each( function( i, el ) {
			if ( jQuery(el).attr('id') == jQuery(card).attr('id') )
				cardPosition = i;
		} );

		var cardRow = 1 + parseInt( cardPosition / perRow, 10 );

		// Insert the more info box after the last item of the row.
		jQuery( 'div.c2-module', 'div.module-container' ).each( function( i, el ) {
			if ( i + 1 == ( perRow * cardRow ) ) {
				// More info box already exists.
				if ( jQuery( 'div.more-info' ).length ) {
					if ( jQuery( el ).next().hasClass( 'more-info' ) ) {
						jQuery( 'div.more-info div.c2-content' ).fadeOut( 100 );
						c2.learn_more_content( jQuery(card).attr( 'id' ) );
						jQuery( window ).scrollTo( ( jQuery( 'div.more-info' ).prev().offset().top ) - 70, 600, function() { if ( typeof callback == 'function' ) callback.call( this ); } );
					} else {
						jQuery( 'div.more-info div.c2-content' ).hide();
						jQuery( 'div.more-info' ).slideUp( 200, function() {
							jQuery(this).detach().insertAfter( el );
							jQuery( 'div.more-info div.c2-content' ).hide();
							c2.learn_more_content( jQuery(card).attr( 'id' ) );
							jQuery( 'div.more-info' ).slideDown( 300 );
							jQuery( window ).scrollTo( ( jQuery( 'div.more-info' ).prev().offset().top ) - 70, 600, function() { if ( typeof callback == 'function' ) callback.call( this ); } );
						} );
					}

				// More info box does not exist.
				} else {
					// Insert the box.
					jQuery( el ).after( '<div id="message" class="more-info c2-message"><div class="arrow"></div><div class="c2-content"></div><div class="c2-close">&times;</div><div class="clear"></div></div>' );

					// Show the box
					jQuery( 'div.more-info', 'div.module-container' ).hide().slideDown( 400, function() {
						// Load the content and scroll to it
						c2.learn_more_content( jQuery(card).attr( 'id' ) );
						jQuery( window ).scrollTo( ( jQuery( 'div.more-info' ).prev().offset().top ) - 70, 600 );
						
						if ( typeof callback == 'function' ) callback.call( this );
					} );
					jQuery( 'div.more-info' ).children( 'div.arrow' ).animate( { left: jQuery(card).offset().left - c2.container.offset().left + 28 + 'px' }, 300 );
				}
				jQuery( 'div.more-info' ).children( 'div.arrow' ).animate( { left: jQuery(card).offset().left - c2.container.offset().left + 28 + 'px' }, 300 );
				
				return;
			}
		} );

		// Listen for resize
		jQuery( window ).bind( 'resize', function() {
			c2.reposition_learn_more( card );
			c2.level_placeholders_on_resize();
		} );

		// Listen for close.
		jQuery( 'div.more-info div.c2-close' ).unbind( 'click' ).bind( 'click', function() {
			c2.close_learn_more();
		} );
	},

	reposition_learn_more: function( card ) {
		var perRow = parseInt( c2.container.width() / 242, 10 );
		var cardPosition = 0;

		// Get the position of the card clicked.
		jQuery( 'div.c2-module', 'div.module-container' ).each( function( i, el ) {
			if ( jQuery(el).attr('id') == jQuery(card).attr('id') )
				cardPosition = i;
		} );

		var cardRow = 1 + parseInt( cardPosition / perRow, 10 );

		jQuery( 'div.c2-module', 'div.module-container' ).each( function( i, el ) {
			if ( i + 1 == ( perRow * cardRow ) ) {
				jQuery( 'div.more-info' ).detach().insertAfter( el );
				jQuery( 'div.more-info' ).children( 'div.arrow' ).css( { left: jQuery(card).offset().left - c2.container.offset().left + 28 + 'px' }, 300 );
			}
		} );
	},

	learn_more_content: function( module_id ) {
		response = jQuery( '#c2-more-info-' + module_id ).html();
		jQuery( 'div.more-info div.c2-content' ).html( response ).hide().fadeIn( 300 );
	},

	close_learn_more: function( callback ) {
		jQuery( 'div.more-info div.c2-content' ).hide();

		jQuery( 'div.more-info' ).slideUp( 200, function() {
			jQuery( this ).remove();
				jQuery( 'a.c2-deactivate-button' ).hide();
				c2.linkClicked.parents( 'div.c2-module' ).children( '.c2-module-actions' ).children( 'a.c2-configure-button' ).show();
			c2.linkClicked = null;
			
			if ( typeof callback == 'function' ) callback.call( this );
		} );
	},

	toggle_debug: function() {
		jQuery('div#c2-configuration').toggle();
	},
	
	hide_shadows: function() {
		jQuery( 'div.c2-module, div.more-info' ).css( { '-webkit-box-shadow': 'none' } );
	},
	
	show_shadows: function() {
		jQuery( 'div.c2-module' ).css( { '-webkit-box-shadow': 'inset 0 1px 0 #fff, inset 0 0 20px rgba(0,0,0,0.05), 0 1px 2px rgba( 0,0,0,0.1 )' } );
		jQuery( 'div.more-info' ).css( { '-webkit-box-shadow': 'inset 0 0 20px rgba(0,0,0,0.05), 0 1px 2px rgba( 0,0,0,0.1 )' } );
	}
}
jQuery( function() { c2.init(); } );
