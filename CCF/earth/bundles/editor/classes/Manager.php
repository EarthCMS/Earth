<?php namespace Earth\Editor;
/**
 * Manager
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Manager 
{
	/**
	 * Instance holder
	 *
	 * @var array
	 */
	protected static $_instances = array();
	
	/**
	 * Default editor instance name
	 *
	 * @var string
	 */
	private static $_default = 'main';
	
	/**
	 * The editors registry
	 *
	 * @var array
	 */ 
	private static $_editors = array(
		'main' => array(
			'editor' => 'Earth\\Editor\\Editor',
			'formattor' => 'Earth\\Editor\\Formattor',
		),
	);
	
	/**
	 * Get a editor instance manager
	 *
	 * @param string				$name
	 * @return Session\Manager
	 */
	public static function create( $name = null ) 
	{
		if ( is_null( $name ) ) 
		{
			$name = static::$_default;
		}
		
		if ( !isset( static::$_instances[$name] ) )
		{
			static::$_instances[$name] = new static( $name );
		}
		
		return static::$_instances[$name];
	}
	
	/**
	 * The editor instance 
	 *
	 * @var Editor
	 */
	protected $editor = null;
	
	/**
	 * The formattor instance
	 *
	 * @var Formattor
	 */
	protected $formattor = null;
	
	/**
	 * The editor constructor
	 *
	 * @param string 		$name
	 * @return void
	 */
	protected function __construct( $name )
	{
		if ( !isset( static::$_editors[$name] ) )
		{
			throw new Exception( 'Invalid editor "'.$name.'".' );
		}
		
		extract( static::$_editors[$name] );
		
		// the editor instance has to be created every time
		// ->editor() so we just save the editors class
		$this->editor = $editor;
		
		// the formattor can use always the same instance so
		// we create that instance here
		$this->formattor = new $formattor;
	}
	
	/**
	 * Returns the managers editor
	 *
	 * @param string 		$key		The form key
	 * @return Editor
	 */
	public function editor( $key )
	{
		return new $this->editor( $key );
	}
	
	/**
	 * Returns the managers formattor
	 *
	 * @return Editor
	 */
	public function formattor()
	{
		return $this->formattor;
	}
}
