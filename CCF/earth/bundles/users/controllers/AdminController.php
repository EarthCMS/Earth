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
		
		$this->view->table = $this->admin_table();
	}
	
	/**
	 * Get the admin table of the users
	 */
	public function admin_table()
	{
		$table = new \Admin\Table( '\\User' );
		$table->column( 'id', true, true, function( $id ) 
		{
			return '#'.$id;
		});
		$table->column( 'email', true, true );
		
		return $table;
	}
	
	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_listsource()
	{		
		return $this->admin_table()->response();
	}
}
