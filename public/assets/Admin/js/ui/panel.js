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
	 * Work with a json response
	 */
	json_response_reciver: function( response )
	{
		CC.UI.panel.container.html( response.body );
		
		// register new ajax forms
		$('.panel-form').ajaxForm(
		{
			dataType: 'json', 
				
			success: function( response )
			{
				CC.UI.panel.json_response_reciver( response );
				CC.UI.loading( CC.UI.panel.container, true );
			},
			
			beforeSubmit: function()
			{
				CC.UI.loading( CC.UI.panel.container, false );
			}	
		});
		
		if ( response.close == true )
		{
			CC.UI.panel.close();
		}
		
		CC.UI.loading( CC.UI.panel.container, true );
	},
	
	/**
	 * Load data using ajax in the panel
	 */
	ajax: function( target )
	{	
		// set loading
		CC.UI.loading( CC.UI.panel.container );
			
		// jquery object might be a form or an other element
		if ( target instanceof jQuery )
		{
			// we just assume an form element here, we probalby 
			// have to change that one day.
			
		}
		else 
		{
			$.ajax(
			{
				type: 'GET',
				url: target,
				cache: false,
				dataType: 'json',
			})
			.done( function( response ) 
			{
				CC.UI.panel.json_response_reciver( response );
			});
		}	
	},
}

/** 
 * Register default triggers
 */
CC.wake.register( function() 
{
	// ajax panel
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
	
	// panel close button
	$( document ).on( 'click', '.panel-close-trigger', function( e ) 
	{
		e.preventDefault();
		CC.UI.panel.close();
	});
	
	// fornm submit from external form
	$( document ).on( 'click', '.panel-form-submit-trigger', function( e ) 
	{
		e.preventDefault();
		var target = $( $(this).data( 'target' ) );
		
		if ( target !== undefined )
		{
			target.submit();
		}
	});
	
	// esc key exit panel
	$(document).on( 'keyup', function(e) 
	{
		if ( e.keyCode == 27 ) 
		{
			CC.UI.panel.close();
		}
	});
});