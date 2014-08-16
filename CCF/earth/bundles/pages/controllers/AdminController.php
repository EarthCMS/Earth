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
		$this->theme->content_topic = __( ':action.topic' );
		
		$this->view = \CCView::create( 'Earth\\Pages::admin/index.view' );
		
		// add a save button to the header bar
		$this->theme->content_header[] = \UI\HTML::a( '<i class="el-icon-ok-circle"></i> '.
			__( 'Earth::common.save' ) )
			->class( 'btn btn-success' )
			->id( 'pages-save-order-trigger' );
			//->disabled( true );
		
		$this->view->page = Page::with( 'pages', function( $q ) 
		{
			$q->where( 'url', '/' );
			$q->limit(1);
		});
	}
	
	/**
	 * edit action
	 * 
	 * @return void|CCResponse
	 */
	public function action_edit()
	{
		// recive the user
		if ( !$page = Page::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			$page = new Page;
		}
		
		// create the detail view
		$view = \CCView::create( 'Earth\\Pages::admin/detail.view', array(
		
			// assign the page model
			'page' => $page,
			
			// assign the type specific edit subview
			'edit_view' => \CCView::create( 'Earth\\Pages::admin/detail/'.$page->type.'.view' ),
		));
		
		// return panel view
		return \Admin\Panel::create( $view->render() )
			->topic( ( $page->id > 0 ) ? $page->name : __(':action.new') )
			->header( 'save', '#user-detail-form' )
			->response();
	}
	
	/**
	 * change page type action
	 * 
	 * @return void|CCResponse
	 */
	public function action_change_type()
	{
		// recive the user
		if ( !$page = Page::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			return \CCResponse::error(404);
		}
		
		// check fingerprint
		if ( !\CCSession::valid_fingerprint() )
		{
			return \CCResponse::error(404);
		}
		
		// we can simply set the type. If the type is invalid the page will throw an exception.
		$page->type = \CCIn::get( 'type' );
		$page->save('type');
		
		// now just forward the change type action
		return \CCRedirect::action( 'edit', array( 'r' => $page->id ) );
	}
	
	/**
	 * tree action
	 * 
	 * @return void|CCResponse
	 */
	public function action_tree()
	{
		// we just deliver content in this action
		$this->modal = true;
		
		// get the root page
		$page = Page::with( 'pages', function( $q ) 
		{
			$q->where( 'url', '/' );
			$q->limit(1);
		});
		
		// on post try to save all the recived data
		if ( \CCIn::method( 'post' ) )
		{
			$pages = Page::find();
			
			$order = json_decode( \CCIn::post( 'order' ), true );
			
			foreach( $order as $key => $order_data )
			{
				// if there is a page
				if ( isset( $pages[$order_data['item_id']] ) )
				{
					$page = $pages[$order_data['item_id']];
					$something_changed = false;
					
					// assign the new sequence
					if ( $page->sequence != $key )
					{
						$page->sequence = $key;
						$something_changed = true;
					}
					
					// set new parent
					if ( $order_data['parent_id'] < 1 )
					{
						$order_data['parent_id'] = 1;
					}
					
					if ( isset( $pages[$order_data['parent_id']] ) )
					{
						if ( $page->parent_id != $order_data['parent_id'] )
						{
							$page->parent_id = $order_data['parent_id'];
							$something_changed = true;
						}
					}
					
					// save if something has changed
					if ( $something_changed )
					{
						$page->save( array( 'parent_id', 'sequence' ) );
					}
				}
			}
		}
		
		return \CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )
			->render();
	}
}
