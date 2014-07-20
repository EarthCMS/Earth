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
	 * Prepare the modules, register the routes etc..
	 *
	 * @return void
	 */
	public static function prepare()
	{
		// we only prepare the admin modules if we are on 
		// the admin route namespace and we are logged in as super user.
		$prefix = Earth::$config->get( 'admin.uri' );
		
		if ( substr( \CCIn::uri(), 0, strlen( $prefix ) ) === $prefix && Earth::$user->is_su() )
		{
			foreach( static::$modules as $uri => $callback )
			{
				$module = new Module;
				
				call_user_func_array( $callback, array( &$module ));
				
				\CCRouter::on( $prefix.'/'.$uri, $module->controller );
			}
		}
	}
}
