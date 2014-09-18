<?php namespace Earth\Block;
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
		
		$this->view = $this->theme->view( 'Earth\\Block::admin/table.view' );
		
		$this->view->table = $this->admin_table();
	}
	
	/**
	 * edit action
	 *
	 * @return void|CCResponse
	 */
	public function action_edit()
	{
		// recive the block
		if ( !$block = Block::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			$block = new Block;
		}
		
		// create the detail view
		$view = \CCView::create( 'Earth\\Block::admin/detail.view', array(
			'block' => $block,
		));
				
		// work with post data
		if ( \CCIn::method( 'post' ) )
		{
			$block->key = \CCStr::clean_url( \CCIn::post( 'key' ), '.' );
			$block->content = \CCIn::post( 'content' );
			
			$validator = \CCValidator::post();
			
			// update the formatted key
			$validator->set( 'key', $block->key );
			
			$validator->rules( 'key', 'required', 'between:3,50' );
			
			if ( $validator->success() )
			{
				$block->save();
				
				\UI\Alert::add( 'success', __( 'Earth::message.success.save' ) );
			}
			else
			{
				\UI\Alert::add( 'danger', $validator->errors() );
			}
		}
		
		$view->editor = \Earth\Editor\Manager::create()
			->editor( 'content' )
			->content( $block->content )
			->modal( true )
			->view()
			->render();
		
		// return panel view
		return \Admin\Panel::create( $view->render() )
			->topic( ( $block->id > 0 ) ? $block->key : __(':action.new') )
			->header( 'save', '#block-detail-form' )
			->response();
	}
	
	/**
	 * Get the admin table of the users
	 */
	public function admin_table()
	{
		$table = new \Admin\Table( 'Earth\\Block\\Block' );
		$table->column( 'id', true, true, function( $id ) 
		{
			return '<span class="label label-default">#'.$id.'</span>';
		});
		$table->column( 'key', true, true );
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
		return $this->admin_table()->response();
	}
}
