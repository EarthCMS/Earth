<?php namespace Admin;
/**
 * Bootstrap Theme
 ** 
 *
 * @package		BootstrapTheme
 * @author		Mario Döring <mario@clancats.com>
 * @version		2.0
 * @copyright 	2010 - 2014 ClanCats GmbH
 *
 */
class Theme extends \Packtacular\Theme
{		
	/**
	 * Returns the current view namespace 
	 * You need to implement this method in your theme subclass.
	 *
	 * @return string
	 */
	public static function view_namespace()
	{
		return __NAMESPACE__;	
	}
	
	/**
	 * This the current public namespace
	 * By default its simply the PUBLICPATH/assets/<theme_namespace>
	 * You need to implement this method in your theme subclass.
	 *
	 * @return string
	 */
	public static function public_namespace()
	{
		return "assets/".__NAMESPACE__.'/';
	}
	
	/**
	 * Render the view and return the output.
	 *
	 * @param string		$file
	 * @return string
	 */
	public function render( $file = null ) 
	{
		// set the orbit asset holder
		\CCAsset::holder( 'admin.orbit' )->path = 'assets/vendor/';
		
		// assign the moduels
		$this->admin_modules = Registry::modules();
		
		// get the last active module
		foreach( $this->admin_modules as $module )
		{
			if ( $module->active )
			{
				$this->active_admin_module = $module;
				$this->active_admin_submodule = $module;
			}
			
			// and submodules
			foreach( $module->modules as $submodule )
			{
				if ( $submodule->active )
				{
					$this->active_admin_submodule = $submodule;
				}
			} 
		}	
		
		// render the theme
		return parent::render( $file );
	}
}
