<?php namespace Admin;
/**
 * Controller
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Controller extends \CCViewController
{
	/**
	 * The default theme
	 * if you wish you can render this controller with a special theme
	 *
	 * @var string
	 */
	protected $_theme = 'Admin';
	
	/**
	 * controller wake
	 * 
	 * @return void|CCResponse
	 */
	public function wake()
	{
		if ( !\Earth::$user->is_admin() )
		{
			return CCRedirect::to( '@auth.sign_in' );
		}
	}
}
