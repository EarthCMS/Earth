CC.UI.panel =
{
	/**
	 * The panel element
	 */
	'element': $('#ccd-panel'),
	
	/**
	 * The panel container
	 */
	'container': $('#ccd-panel .panel-container'),
	
	/**
	 * Panel is active
	 */
	is_open: function()
	{
		return !this.element.hasClass( 'panel-hidden' );
	},
	
	/**
	 * Open the panel
	 */
	open: function()
	{
		this.element.removeClass( 'panel-hidden' );
	},
	
	/**
	 * Open the panel
	 */
	close: function()
	{
		this.element.addClass( 'panel-hidden' );
	},
	
	/**
	 * Load data using ajax in the panel
	 */
	ajax: function( url, data, method )
	{
		// default method
		if ( method === undefined )
		{
			method = 'GET';
		}
		
		// default data
		if ( data === undefined )
		{
			data = {};
		}
		
		$.ajax(
		{
			type: method.toUpperCase(),
			url: url,
			data: data,
			cache: false,
			dataType: 'json',
		})
		.done( function( response ) 
		{
			CC.UI.panel.container.html( response.body );
			
			if ( response.close )
			{
				CC.UI.panel.close();
			}
		});
	},
}

/** 
 * Register default triggers
 */
CC.wake.register( function() 
{
	$( document ).on( 'click', '.panel-ajax-trigger', function( e ) 
	{
		e.preventDefault();
		
		var $this = $(this);
		
		if ( CC.UI.panel.is_open() )
		{
			CC.UI.panel.close();
		}
		
		CC.UI.panel.ajax( $this.attr( 'href' ) );
		
		CC.UI.panel.open();
	});
	
	$(document).on( 'keyup', function(e) 
	{
		if ( e.keyCode == 27 ) 
		{
			CC.UI.panel.close();
		}
	});
});