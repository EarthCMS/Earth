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
		// recive the page object if no record is found
		// just create a empty one
		if ( !$page = Page::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			$page = new Page;
		}
		
		// Check if this is a post request, if it is so 
		// handle the recived data and save the page record
		if ( \CCIn::method( 'post' ) )
		{
			// Create validator
			$validator = \CCValidator::post();
			
			// assign base form
			$page->strict_assign( array(
				'hidden',
				'status',
				'name',
				'url'
			), \CCIn::all( 'post' ));
			
			// validate the base form elements such as status, name etc.
			$validator->rules( 'name', 'required', 'min:1' );
			
			// because the url has a modifier we have to pass 
			// the modified string to the validator
			$validator->set( 'url', $page->url );
			$validator->rules( 'url', 'required', 'min:1' );
			
			// forward to type specifc save function
			$response = call_user_func_array( array( $this, 'handle_'.$page->type.'_save' ), array( &$page, &$validator ) );
			
			// if response is not true
			if ( $validator->success() )
			{
				$page->save();
				\UI\Alert::add( 'success', __( 'Earth::message.success.save' ) );
			}
			else
			{
				\UI\Alert::add( 'danger', $validator->errors() );
			}
		}
		
		// create the detail view for the panel response
		$view = \CCView::create( 'Earth\\Pages::admin/detail.view', array(
		
			// assign the page model
			'page' => $page,
			
			// assign the type specific edit subview
			'edit_view' => \CCView::create( 'Earth\\Pages::admin/detail/'.$page->type.'.view', array(
			
				// we need the page also in the edit view
				'page' => $page,
			)),
		));
		
		// run the prepare edit view for mehtod for the page type
		call_user_func_array( array( $this, 'prepare_'.$page->type.'_view' ), array( &$view ) );
		
		// return panel view
		return \Admin\Panel::create( $view->render() )
			->topic( ( $page->id > 0 ) ? $page->name : __(':action.new') )
			->header( 'save', '#page-detail-form' )
			->response();
	}
	
	/**
	 * Prepare the content view
	 *
	 * @param CCView			$view
	 * @return void
	 */
	public function prepare_content_view( $view )
	{
		$view->edit_view->editor = \Earth\Editor\Manager::create()
			->editor( 'content' )
			->content( 'Habibi <b>Sulfat</b>' )
			->view()
			->render();
	}
	
	/**
	 * Handle Controller save
	 *
	 * @param Page				$page
	 * @param CCValidator		$validator
	 * @return bool|array
	 */
	public function handle_content_save( $page, $validator )
	{
		return true;
	}
	
	/**
	 * Handle Controller save
	 *
	 * @param Page				$page
	 * @param CCValidator		$validator
	 * @return bool|array
	 */
	public function handle_controller_save( $page, $validator )
	{
		$page->controller = trim( \CCIn::post( 'controller' ) );
		
		return true;
	}
	
	
	/**
	 * Handle Controller save
	 *
	 * @param Page				$page
	 * @param CCValidator		$validator
	 * @return bool|array
	 */
	public function handle_redirect_save( $page, $validator )
	{
		$page->redirect = trim( \CCIn::post( 'redirect' ) );
		
		return true;
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
						$page->save( array( 'parent_id', 'sequence', 'url', 'full_url' ) );
					}
				}
			}
		}
		
		// get the root page
		$page = Page::with( 'pages', function( $q ) 
		{
			$q->where( 'url', '/' );
			$q->limit(1);
		});
		
		return \CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )
			->render();
	}
	
	
	/**
	 * create item action
	 * 
	 * @return void|CCResponse
	 */
	public function action_create()
	{
		// we just deliver content in this action
		$this->modal = true;
		
		// create new page item
		$page = new Page;
		$page->save();
		$page->name = 'New page #'.$page->id;
		$page->save( 'name' );
		
		return \CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )
			->render();
	}
	
	/**
	 * save the item collapsed or expanded status
	 * 
	 * @return void|CCResponse
	 */
	public function action_save_tree_status()
	{
		// we just deliver content in this action
		$this->modal = true;
		
		// recive the page
		if ( !$page = Page::find( \CCIn::get( 'r', \CCIn::post( 'r', 0 ) ) ) )
		{
			return \CCResponse::error(404);
		}
		
		\CCSession::set( 'earth.pages.page-'.$page->id.'.expanded', \CCIn::get('collapsed') === "true" ? false : true );
	}
}
