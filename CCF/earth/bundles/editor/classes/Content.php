<?php namespace Earth\Editor;
/**
 * Builder
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Content
{
	/**
	 * The available content builders
	 *
	 * @var array
	 */ 
	private static $available_builders = array(
		'links',
		'images',
		'formattor',
	);
	
	/**
	 * Perform a build on a content string
	 *
	 * @param string			$content
	 * @return string
	 */
	public static function build( $content, $what = null )
	{
		if ( is_string( $what ) )
		{
			$what = array( $what );
		}
		
		if ( !is_array( $what ) )
		{
			$what = static::$available_builders;
		}
		
		// create new builder instance
		$builder = new Builder;
		
		foreach ( $what as $builder_function ) 
		{
			if ( !in_array( $builder_function, static::$available_builders ) )
			{
				throw new Exception("Invalid builder '".$builder_function."'.");
			}
			
			// call the build function build_<key>( $content )
			$content = call_user_func( array( $builder, 'build_'.$builder_function ), $content );
		}
		
		return $content;
	}
}
