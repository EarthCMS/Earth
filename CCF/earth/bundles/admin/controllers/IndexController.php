<?php namespace Admin;
/**
 * IndexController
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class IndexController extends Controller
{	
	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_index()
	{
		$this->theme->topic = 'Dashboard';
		
		
		
		echo "IndexController";
	}
	
	/**
	 * controller sleep
	 * 
	 * @return void
	 */
	public function sleep()
	{
		// Do stuff
	}
}
