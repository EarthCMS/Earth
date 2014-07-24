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
		$this->theme->content_topic = __( ':action.topic' );
		$this->theme->content_header = \CCView::create( 'Admin::content-search.view' );
		
		$this->view = $this->theme->view( 'Earth\\Users::table.view' );
		
		$this->view->table = $this->admin_table();
	}
	
	/**
	 * edit action
	 *
	 * @return void|CCResponse
	 */
	public function action_edit()
	{
		$this->modal = true;
		
		if ( !$user = \User::find( \CCIn::get( 'r', 0 ) ) )
		{
			$user = new \User;
		}
		
		$view = \CCView::create( 'Earth\\Users::detail.view', array(
			'user' => $user,
		));
		
		return \Admin\Panel::create( $view->render() )
			->topic( ( $user->id > 0 ) ? $user->email : __(':action.new') )
			->response();
	}
	
	/**
	 * Get the admin table of the users
	 */
	public function admin_table()
	{
		$table = new \Admin\Table( '\\User' );
		$table->column( 'id', true, true, function( $id ) 
		{
			return '<span class="label label-default">#'.$id.'</span>';
		});
		$table->column( 'avatar', false, false, function( $id, $model ) 
		{
			return \UI\HTML::img()
				->src( $model->avatar() )
				->class( 'rounded' )
				->width( '32px' )
				->height( '32px' )
				->render();
		});
		$table->column( 'email', true, true );
		$table->column( 'group', false, false, function( $group, $model ) 
		{
			return $group->name;
		});
		$table->column( 'created_at', true, false, function( $timestamp ) 
		{
			return Carbon::createFromTimeStamp( $timestamp )->format( 'd/m/Y H:i' );
		});
		$table->column( 'actions', false, false, function( $id, $model ) 
		{
			return \UI\HTML::a( '<i class="el-icon-file-edit"></i>' )
				->class( 'btn btn-dark btn-sm panel-ajax-trigger hover-visible rounded' )
				->href( \CCUrl::action( 'edit', array( 'r' => $model->id ) ) )
				->render();
		});
		
		return $table;
	}
	
	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_listsource()
	{
		return $this->admin_table()->response( null, array( 'group' ) );
	}
}
