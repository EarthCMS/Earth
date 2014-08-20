<?php namespace Earth\Pages;
/**
 * ContentController
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class ContentController extends \CCViewController
{
	/**
	 * Index action
	 * @return void|CCResponse
	 */
	protected function action_index( $page )
	{
		// In the page controller the theme topic is always the page name
		$this->theme->topic = $page->name;
		
		echo $page->name;
	}
	
	/**
	 * Controller wake
	 * @return void|CCResponse
	 */
	protected function wake()
	{
		//
	}
	
	/**
	 * Controller wake
	 * @return void
	 */
	protected function sleep()
	{
		//
	}
}
