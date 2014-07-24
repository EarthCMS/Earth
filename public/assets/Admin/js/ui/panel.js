CC.UI.panel =
{
	'element': $('#ccd-panel'),
	
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
	}
}

/** 
 * Register default triggers
 */
CC.wake.register( function() 
{
	$( document ).on( 'click', '.panel-ajax-trigger', function( e ) 
	{
		e.preventDefault();
		CC.UI.panel.open();
	});
});