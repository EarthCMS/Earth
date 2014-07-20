<?php namespace Earth\Users;
/**
 * AdminController
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class AdminController extends \Admin\Controller
{
	/**
	 * controller wake
	 * 
	 * @return void|CCResponse
	 */
	public function wake()
	{
		// Do stuff
	}
	
	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_index()
	{
		echo "AdminController";
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
