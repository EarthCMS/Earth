<?php namespace Admin;
/**
 * Module
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Module
{
	/**
	 * The module uri
	 *
	 * @var string
	 */
	public $uri = '';
	
	/**
	 * The module title
	 *
	 * @var string
	 */
	public $title = '';
	
	/**
	 * The module controller
	 *
	 * @var string
	 */
	public $controller = '';
	
	/**
	 * The admin sidebar
	 *
	 * @var string
	 */
	public $sidebar = null;
	
	/**
	 * The module icon class or png image
	 *
	 * @var string
	 */
	public $icon = '';
	
	/**
	 * A module can have submodules
	 *
	 * @var array
	 */
	public $modules = array();
	
	/**
	 * Is this module currently active
	 *
	 * @var bool
	 */ 
	public $active = false;
	
	/**
	 * Get the modules title
	 *
	 * @return string
	 */
	public function title()
	{
		if ( empty( $this->title ) )
		{
			return "no title";
		}
		
		return $this->title;
	}
	
	/**
	 * Get a link to the admin module
	 *
	 * @return string
	 */
	public function link()
	{
		if ( empty( $this->uri ) )
		{
			throw new Exception( 'Cannot create module link without a registered uri.' );
		}
		
		return \CCUrl::alias( 'admin.'.$this->uri );
	}
	
	/**
	 * Is the icon an image or icon class
	 *
	 * @return string
	 */
	public function is_image()
	{
		return \CCStr::extension( $this->icon() ) === 'png';
	}
	
	/**
	 * Is the icon an image or icon class
	 *
	 * @return string
	 */
	public function icon()
	{
		if ( empty( $this->icon ) )
		{
			return "el-icon-warning-sign";
		}
		
		return $this->icon;
	}
	
	/**
	 * Get the sidebar view contentes
	 *
	 * @return string
	 */
	public function sidebar()
	{
		if ( !is_null( $this->sidebar ) )
		{
			return \CCView::create( $this->sidebar )->render();
		}
		
		return '';
	}
	
	/**
	 * Add a submodule to the current one. At the 
	 * moment there is only one dimension of submodules supported.
	 *
	 * @param string 		$uri
	 * @param closure		$module
	 * 
	 * @return void
	 */
	public function add( $uri, $module )
	{
		$this->modules[$uri] = $module;
	}
}
