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
				if ( $callback instanceof Module )
				{
					continue;
				}
				
				$module = new Module;
				
				call_user_func_array( $callback, array( &$module ) );
				
				$module->uri = $uri;
				
				\CCRouter::on( $prefix.'/'.$uri, array( 'alias' => 'admin.'.$uri ), $module->controller );
				
				static::$modules[$uri] = $module;
			}
		}
	}
}
