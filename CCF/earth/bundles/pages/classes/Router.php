<?php namespace Earth\Pages;
/**
 * Router
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Router 
{
	/**
	 * Handle the root request
	 *
	 * @return CCResponse
	 */
	public static function root()
	{
		$route = new \CCRoute;
		$route->uri = '#root';
		return \CCRequest::create( reset( \Earth\Pages\Router::resolve( array( $route ) ) ) )
			->perform()
			->response();
	}
	
	/**
	 * Resolve custom routes
	 *
	 * @param array[CCRoute] 		$route
	 * @return array
	 */
	public static function resolve( $route )
	{
		$route = reset( $route );
		
		// grab the uri from the route
		$uri = $route->uri;
		
		if ( $page = Page::find( 'full_url', $uri ) )
		{
			return static::handle_page( $route, $page );
		}
		
		// try it with an action
		$uri = explode( '/', $uri );
		
		$route->action = $action = array_pop( $uri );
		$route->uri = $uri = implode( '/', $uri );
		
		if ( $page = Page::find( 'full_url', $uri ) )
		{
			return static::handle_page( $route, $page );
		}
		
		// otherwise return false
		return false;
	}
	
	/** 
	 * Handle Page matching
	 *
	 * @param CCRoute			$route
	 * @param Page 				$page
	 * @return bool|array
	 */
	private static function handle_page( $route, $page )
	{
		// is the page active?
		if ( $page->status !== true )
		{
			return false;
		}
		
		// does this page implement an controller
		if ( $page->type === 'controller' )
		{
			// create the controller
			$controller = \CCController::create( $page->controller );
		}
		// else we use the page controller
		elseif ( $page->type === 'redirect' )
		{
			return array( function() use( $page )
			{
				return \CCRedirect::to( $page->redirect );
			}, true );
		}
		else 
		{
			$controller = \CCController::create( 'Earth\\Pages::Content' );
		}
		
		// add the current page as first param to the controller
		array_unshift( $route->params, $page );
		
		// set the route callback to the controller execute
		$route->callback = array( $controller, 'execute' );
		
		// return the route
		return array( $route, true );
	}
}
