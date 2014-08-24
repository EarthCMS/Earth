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
		'status' => array( 'bool', true ),
		'hidden' => array( 'bool', false ),
		'sequence' => array( 'int', 0 ),
		'parent_id' => array( 'int', 1 ),
		'url' => array( 'string', '' ),
		'full_url' => array( 'string', '' ),
		'name' => array( 'string', '' ),
		'description' => array( 'string', '' ),
		'image' => array( 'string', '' ),
		'controller' => array( 'string', '' ),
		'redirect' => array( 'string', '' ),
		'content' => array( 'string', '' ),
		'content_build' => array( 'string', '' ),
		'modules' => array( 'json', array() ),
		'options' => array( 'json', array() ),
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
	 * Save the inital name to be able to know when to update the url
	 *
	 * @var string
	 */
	public $initial_name = null;
	
	/**
	 * Save the inital url so that we can check if we have to update the children
	 *
	 * @var string
	 */
	public $initial_url = null;
	
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
	 * Clean the url before setting
	 *
	 * @param string 			$type
	 * @return void
	 */
	protected function _set_modifier_url( $url )
	{
		// if the url is empty use the name
		if ( empty( $url ) )
		{
			$url = $this->name;
		}
		
		return \CCStr::clean_url( $url );
	}
	
	/**
	 * Build content when its set
	 *
	 * @param string 			$content
	 * @return void
	 */
	protected function _set_modifier_content( $content )
	{
		// rebuild content only if something has changed
		if ( $this->content !== $content )
		{
			$this->content_build = \Earth\Editor\Content::build( $content );
		}		
		
		return $content;
	}
	
	/**
	 * Returns the builded and formatted content
	 *
	 * @return string
	 */
	public function content()
	{
		return $this->content_build;
	}
	
	/**
	 * Recive subpages
	 *
	 * @return DB\Releation
	 */
	public function pages()
	{
		return $this->has_many( '\\Earth\\Pages\\Page', 'parent_id' )
			->order_by( 'sequence' );
	}
	
	/**
	 * Recive parent
	 *
	 * @return DB\Releation
	 */
	public function parent()
	{
		return $this->belongs_to( '\\Earth\\Pages\\Page', 'id', 'parent_id' );
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
	
	/**
	 * Is the current page collapsed for the current admin?
	 *
	 * @return bool
	 */
	public function is_expanded()
	{
		return \CCSession::get( 'earth.pages.page-'.$this->id.'.expanded', false );
	}
	
	/**
	 * Before assign
	 *
	 * @param array 			$data
	 * @return $data
	 */
	protected function _before_assign( $data ) 
	{
		// check if the name and the url matches
		if ( isset( $data['name'] ) )
		{
			$this->initial_name = $data['name'];
		}
		
		// save the inital url also
		if ( isset( $data['full_url'] ) )
		{
			$this->initial_url = $data['full_url'];
		}
		
		return $data;
	}
	
	/**
	 * Before saving we set empty urls and fix the full url 
	 *
	 * @param array 			$data
	 * @return $data
	 */
	protected function _before_save( $data ) 
	{
		// while the url is matching the name keep updating the url
		if ( isset( $data['name'] ) && isset( $data['url'] ) )
		{
			if ( $this->initial_name !== $data['name'] && \CCStr::clean_url( $this->initial_name ) === $data['url'] )
			{
				$this->url = $data['url'] = \CCStr::clean_url( $data['name'] );
			}
		}
				
		// updated full url
		if ( !$this->is_root() )
		{
			$data['full_url'] = $this->full_url = trim( $this->parent->full_url.'/'.$data['url'], '/' );
		}
		
		return $data; 
	}
	
	/**
	 * After saving we have to update the children
	 *
	 * @param array 			$data
	 * @return $data
	 */
	protected function _after_save() 
	{
		if ( $this->full_url !== $this->initial_url )
		{
			foreach( $this->pages as $page )
			{
				$page->save();
			}
		}
	}
}
