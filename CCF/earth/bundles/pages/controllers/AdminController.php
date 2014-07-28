<?php namespace Earth\Pages;
/**
 * Pages AdminController
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */

use Carbon\Carbon; 

class AdminController extends \Admin\Controller
{
	/**
	 * controller wake
	 * 
	 * @return void|CCResponse
	 */
	public function wake()
	{
		$this->theme->topic = __( ':controller.topic' );

		parent::wake();
	}

	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_index()
	{
		
	}
}
