<?php namespace Earth\Users;
/**
 * User AdminController
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
		$this->theme->content_topic = __( ':action.topic' );
		$this->theme->content_header = \CCView::create( 'Admin::content-search.view' );
		
		$this->view = $this->theme->view( 'Earth\\Users::table.view' );
	}
	
	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_listsource()
	{
		$users = \User::find();
		
		foreach( $users as $id => $user )
		{
			$users[$id] = $user->as_array();
		} 
		
		return \CCResponse::json( array_values( $users ) );
	}
}
