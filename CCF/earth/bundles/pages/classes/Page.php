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
		'modules' => array( 'string', '' ),
		'options' => array( 'string', '' ),
		'created_at' => array( 'int', 0 ),
		'modified_at' => array( 'int', 0 )
	);
	
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
