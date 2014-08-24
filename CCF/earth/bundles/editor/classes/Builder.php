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
class Builder
{	
	public function build_links( $content )
	{
		return $content;
	}
	
	public function build_images( $content )
	{
		return $content;
	}
	
	/**
	 * Let the formattor format the content
	 *
	 * @param string 		$content
	 * @return string
	 */
	public function build_formattor( $content )
	{
		return Manager::create()->formattor()->build( $content );
	}
}
