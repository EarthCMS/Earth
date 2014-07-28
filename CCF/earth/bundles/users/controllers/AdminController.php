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
	 * Allow this controller to be used with a special group as filter
	 *
	 * @param Group
	 */ 
	public $group = null;
	
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
		// recive the user
		if ( !$user = \User::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			$user = new \User;
			
			// new user need a default password we generate one
			$user->password = $password = \CCStr::random(6);
		}
		
		// create the detail view
		$view = \CCView::create( 'Earth\\Users::detail.view', array(
			'user' => $user,
		));
		
		// add available user groups
		$view->groups = array( 0 => $user->__( 'no-group' ) );
		foreach( \Group::find() as $group )
		{
			$view->groups[$group->id] = $group->name;
		}
		
		// work with post data
		if ( \CCIn::method( 'post' ) )
		{
			$user->strict_assign( array( 'email', 'name', 'group_id' ), \CCIn::all( 'post' ) );
			
			$validator = \CCValidator::post();
			
			$validator->rules( 'email', 'required', 'email' );
			$validator->rules( 'name', 'required', 'between:3,50' );
			$validator->in( 'group_id', array_keys( $view->groups ) );
			
			// check if current user trying to change itself
			if ( $user->id === \Earth::$user->id && \Earth::$user->group_id != $user->group_id )
			{
				$validator->add_error( 'group_id', __(':action.cant_change_own_group') );
			}
						
			if ( $validator->success() )
			{
				$user->save();
				
				\UI\Alert::add( 'success', __( 'Earth::message.success.save' ) );
				
				// show new password
				if ( isset( $password ) )
				{
					\UI\Alert::add( 'info', __( ':action.password_created', array( 'password' => $password ) ) );
				}
			}
			else
			{
				\UI\Alert::add( 'danger', $validator->errors() );
			}
		}
		
		// return panel view
		return \Admin\Panel::create( $view->render() )
			->topic( ( $user->id > 0 ) ? $user->email : __(':action.new') )
			->header( 'save', '#user-detail-form' )
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
		$table->column( 'name', true, true );
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
		return $this->admin_table()->response( function($q)
		{
			// filter by group if group is set
			if ( \CCIn::get( 'group', false ) )
			{
				$q->where( 'group_id', (int) \CCIn::get( 'group' ) );
			}
		}, array( 'group' ) );
	}
}
