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
	 * The module icon class or png image
	 *
	 * @var string
	 */
	public $icon = '';
	
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
}
