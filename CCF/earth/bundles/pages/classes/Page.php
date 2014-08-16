<?php namespace Earth\Pages;
/**
 * Page
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Page extends \DB\Model
{
	/**
	 * The database table name
	 * 
	 * @var string
	 */
	protected static $_table = 'earth_pages';
	
	/**
	 * Allow automatic timestamps
	 * 
	 * @var bool
	 */
	protected static $_timestamps = true;
	
	/**
	 * The  default properties
	 * 
	 * @var string
	 */
	protected static $_defaults = array(
		'id',
		'type' => 1, 
		'status' => array( 'bool', false ),
		'hidden' => array( 'bool', false ),
		'sequence' => array( 'int', 0 ),
		'parent_id' => array( 'int', 0 ),
		'url' => array( 'string', '' ),
		'full_url' => array( 'string', '' ),
		'name' => array( 'string', '' ),
		'description' => array( 'string', '' ),
		'image' => array( 'string', '' ),
		'controller' => array( 'string', '' ),
		'redirect' => array( 'string', '' ),
		'modules' => array( 'string', '' ),
		'options' => array( 'string', '' ),
		'created_at' => array( 'int', 0 ),
		'modified_at' => array( 'int', 0 )
	);
	
	/**
	 * Page types
	 *
	 * @var array
	 */
	public static $_types = array(
		1 => 'content',
		2 => 'redirect',
		3 => 'controller',
	);
	
	/**
	 * Return the type always as string
	 *
	 * @param int 			$type
	 * @return string
	 */
	protected function _get_modifier_type( $type )
	{
		if ( !in_array( $type, array_keys( static::$_types ) ) )
		{
			reset( static::$_types );
			$type = key( static::$_types );
		}
		
		return static::$_types[(int)$type];
	}
	
	/**
	 * Set the type always using a string
	 *
	 * @param string 			$type
	 * @return void
	 */
	protected function _set_modifier_type( $type )
	{
		if ( !in_array( $type, static::$_types ) )
		{
			throw new Exception( 'Invalid page type "'.$type.'".' );
		}
		
		return \CCArr::get( $type, array_flip( static::$_types ) );
	}
	
	/**
	 * Recive subpages
	 *
	 * @return DB\Releation
	 */
	public function pages()
	{
		return $this->has_many( '\\Earth\\Pages\\Page', 'parent_id' );
	}
	
	/**
	 * Is this the root page
	 *
	 * @return bool
	 */
	public function is_root()
	{
		return $this->url === '/';
	}
}
