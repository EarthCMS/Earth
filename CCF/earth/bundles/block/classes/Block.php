<?php namespace Earth\Block;
/**
 * Block
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Block extends \DB\Model
{
	/**
	 * The database table name
	 * 
	 * @var string
	 */
	protected static $_table = 'earth_blocks';
	
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
		'key' => array( 'string', '' ),
		'language' => '',
		'content' => array( 'string', '' ),
		'content_build' => array( 'string', '' ),
		'footer' => array( 'string', '' ),
		'modified_at' => array( 'int', 0 ),
		'created_at' => array( 'int', 0 )
	);
	
	/**
	 * Render a block by key
	 *
	 * @param string 			$key
	 * @param string 			$lang
	 */
	public static function render( $key, $lang = null )
	{
		if ( is_null( $lang ) )
		{
			$lang = \CCLang::current();
		}
		
		$block = static::find( function( $q ) use( $key, $lang ) 
		{
			$q->limit(1);
			$q->where( 'language', $lang );
			$q->where( 'key', $key );
		});
		
		if ( !$block )
		{
			"Block {$key} could not be found.";
		}
		
		return $block->content();
	}
	
	/**
	 * Inital content for revisions
	 *
	 * @var array
	 */
	protected $_initial_content = array();
	
	/**
	 * model constructor
	 *
	 * @param array 		$data
	 * @return void
	 */
	public function __construct( $data = null ) 
	{
		// add the current language if not set
		if ( !isset( $data['language'] ) )
		{
			$data['language'] = \CCLang::current();
		}
		
		return parent::__construct( $data );
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
	 * Has the block changed its contents?
	 *
	 * @return bool
	 */
	private function block_has_changed_contents()
	{
		return (
			$this->content !== $this->_initial_content['content'] 
			|| $this->footer !== $this->_initial_content['footer'] 
			|| $this->key !== $this->_initial_content['key'] 
		);
	}
	
	/**
	 * Set the inital content array
	 *
	 * @param array 			$data
	 * @return bool
	 */
	private function set_inital_content_from_array( $data )
	{
		$this->_initial_content = array(
			'content'	=> $data['content'],
			'footer'		=> $data['footer'],
			'key'		=> $data['key'],
		);
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
	 * Catch the inital content
	 *
	 * @param array 			$data
	 * @return array
	 */
	protected function _before_assign( $data ) 
	{	
		$this->set_inital_content_from_array( $data );
		
		return $data;
	}
	
	/**
	 * Before save hook
	 *
	 * @param array 			$data
	 * @return array
	 */
	public function _before_save( $data ) 
	{	
		if ( !( empty( $this->id ) ) && $this->block_has_changed_contents() ) 
		{
			$revision = Block_Revision::create();
			$revision->content = $this->_initial_content;
			$revision->block_id = $this->id;
			$revision->save();
			
			// update the inital content
			$this->set_inital_content_from_array( $data );
		}
		
		return $data;
	}
}
