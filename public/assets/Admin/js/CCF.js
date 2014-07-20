(function( window, undefined ) {

var CCF = {
	/*
	 * Front end configuration
	 */
	config: 
	{
		// language
		lang: {},
	},

	/**
	 * inital config changes
	 */
	init: function( options ) {
		// assign some data
		for ( var property in options ) {
			this.config[property] = options[property];
		}

		// fire the events
		this.wake.fire();
	},

	/**
	 * Render callbacks
	 */
	wake: 
	{
		// callback holder
		_holder: [],	

		// register a new wake callback
		register: function( callback ) 
		{
			this._holder.push( callback );
		},
		// fire the wake event
		fire: function() 
		{
			for( var i=0, l=this._holder.length; i<l; ++i ) 
			{
				this._holder[i].call();
			}
		},
	},

	/**
	 * UI loading
	 */
	UI: {}
};

// assign CCF to the window as CC
window.CC = CCF;
})(window);
