<?php namespace Earth\Editor;
/**
 * Formattor_Interface
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
interface Formattor_Interface 
{
	/**
	 * Build the content
	 *
	 * @param string 		$content
	 * @return string
	 */
	public function build( $content );
}
