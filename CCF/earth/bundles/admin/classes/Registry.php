<?php namespace Admin;
/**
 * Registry
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */

use Earth;

class Registry
{	
	/**
	 * The registered admin modules
	 *
	 * @var array
	 */ 
	protected static $modules = array();
	
	/**
	 * Register the inital redirect to index
	 *
	 * @return void
	 */
	public static function _init()
	{
		\CCRouter::on( 'ccadmin', function() 
		{
			return \CCRedirect::alias( 'admin.index' );
		});
	}
	
	/**
	 * Add a new module to the registry
	 *
	 * @param string 		$uri
	 * @param closure		$module
	 * @return void
	 */
	public static function add( $uri, $module )
	{
		static::$modules[$uri] = $module;
	}
	
	/**
	 * Get the modules
	 *
	 * @return array[Module]
	 */
	public static function modules()
	{
		return static::$modules;	
	}
	
	/**
	 * Prepare the modules, register the routes etc..
	 *
	 * @return void
	 */
	public static function prepare()
	{
		// we only prepare the admin modules if we are on 
		// the admin route namespace and we are logged in as super user.
		$prefix = Earth::$config->get( 'admin.uri' );
		
		if ( substr( \CCIn::uri(), 0, strlen( $prefix ) ) === $prefix && Earth::$user->is_admin() )
		{
			foreach( static::$modules as $uri => $callback )
			{
				// skip if already a module
				if ( $callback instanceof Module )
				{
					continue;
				}
				
				$module = new Module;
				call_user_func_array( $callback, array( &$module ) );
				
				$module->uri = $uri;
				
				// register the route
				\CCRouter::on( $prefix.'/'.$uri, array( 'alias' => 'admin.'.$uri ), $module->controller );
				
				// check if the module is active
				if ( \CCUrl::active( $module->link() ) )
				{
					$module->active = true;
				}
				
				// submodules
				foreach( $module->modules as $suburi => $subcallback )
				{					
					$submodule = new Module;
					call_user_func_array( $subcallback, array( &$submodule ) );
					
					$submodule->uri = $uri.'.'.$suburi;
					
					// register the route for the submodule
					\CCRouter::on( $prefix.'/'.$uri.'/'.$suburi, array( 
						'alias' => 'admin.'.$uri.'.'.$suburi )
					, $submodule->controller );
					
					// check if the module is active
					if ( \CCUrl::active( $submodule->link() ) )
					{
						$submodule->active = true;
					}
					
					$module->modules[$suburi] = $submodule;
				}
				
				static::$modules[$uri] = $module;
			}
		}
	}
}
