<?php namespace Earth\Editor;
/**
 * Editor_Interface
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
interface Editor_Interface 
{
	/**
	 * New editor instance constructor
	 * 
	 * @param string 		$key
	 * @return void
	 */
	public function __construct( $key );
	
	/**
	 * Recive the raw editors content
	 * 
	 * @param string 		$content
	 * @return void
	 */
	public function content( $content );
	
	/**
	 * Return the editors frontend view 
	 *
	 * @return CCView
	 */
	public function view();
}
