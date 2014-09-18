<?php namespace Earth\Users;
/**
 * GroupControllerController
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */

use Carbon\Carbon;
 
class GroupController extends \Admin\Controller
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
		$this->theme->content_header[] = \CCView::create( 'Admin::content-search.view' );
		
		$this->view = $this->theme->view( 'Earth\\Users::group/table.view' );
		
		$this->view->table = $this->admin_table();
	}
	
	/**
	 * edit action
	 *
	 * @return void|CCResponse
	 */
	public function action_edit()
	{
		// recive the group
		if ( !$group = \Group::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			$group = new \Group;
		}
		
		// create the detail view
		$view = \CCView::create( 'Earth\\Users::group/detail.view', array(
			'group' => $group,
		));
		
		// add the user list
		
		$controller = \CCController::create( 'Earth\\Users::Admin' );
		
		$view->user_list = $this->theme->view( 'Earth\\Users::table.view' );
		$view->user_list->table = $controller->admin_table();
		$view->user_list->group_id = $group->id;
		$view->user_list->search = false;
		
				
		// work with post data
		if ( \CCIn::method( 'post' ) )
		{
			$group->strict_assign( array( 'name' ), \CCIn::all( 'post' ) );
			
			$validator = \CCValidator::post();
			
			$validator->rules( 'name', 'required', 'between:3,50' );
			
			if ( $validator->success() )
			{
				$group->save();
				
				\UI\Alert::add( 'success', __( 'Earth::message.success.save' ) );
			}
			else
			{
				\UI\Alert::add( 'danger', $validator->errors() );
			}
		}
		
		// return panel view
		return \Admin\Panel::create( $view->render() )
			->topic( ( $group->id > 0 ) ? $group->name : __(':action.new') )
			->header( 'save', '#group-detail-form' )
			->response();
	}
	
	/**
	 * Get the admin table of the users
	 */
	public function admin_table()
	{
		$table = new \Admin\Table( '\\Group' );
		$table->column( 'id', true, true, function( $id ) 
		{
			return '<span class="label label-default">#'.$id.'</span>';
		});
		$table->column( 'name', true, true );
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
		return $this->admin_table()->response( null );
	}
}
