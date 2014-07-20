CC.UI.loading = function( selector, is_loading ) 
{
	// loop trough all recived elements
	$.each( selector, function() {

		var $this = $(this),
			wrapper = $this.parent().parent();


		// create a wrapper element
		if ( wrapper.data( 'is_loading' ) === undefined )
		{
			if ( $this.css( 'display' ) == 'block' )
			{
				$this.wrap( "<div class='clearfix loading-wrapper'><div class='clearfix loading-content-wrapper'></div></div>" );
			}
			else 
			{
				$this.wrap( "<span class='loading-wrapper'><span class='loading-content-wrapper'></span></span>" );
			}

			wrapper = $this.parent().parent();
		}

		// check for state
		if ( is_loading === undefined ) 
		{
			is_loading = wrapper.data( 'is_loading' );
		}

		// disable loading
		if ( is_loading ) 
		{
			// is no more loading
			wrapper.data( 'is_loading', false );

			// remove indicator
			wrapper.find('.ccf-loading-indicator').remove();

			wrapper.find( '.loading-content-wrapper' ).css({
				opacity: 1
			});

		}
		// set loading 
		else 
		{
			// set loading status
			wrapper.data( 'is_loading', true );

			// add the loading indicator
			wrapper.prepend(  "<span class='ccf-loading-indicator'><img style='width:32px;height:32px' src='"+CC.config.ui.loading_img+"'></span>" );

			var loader = wrapper.find('.ccf-loading-indicator');

			loader.hide();

			// udpate styling of weapper and loader
			wrapper.css({
				position: 'relative',
			});

			wrapper.find('.loading-content-wrapper').css({'opacity':0.2});

			loader.css({ 
				top: wrapper.outerHeight() / 2 - ( loader.outerHeight() / 2 ),
				left: ( wrapper.outerWidth() / 2 ) - ( loader.outerWidth() / 2 ),
				position: 'absolute',
			});

			loader.fadeIn();
		}
	});
}