<?php
/*
 *---------------------------------------------------------------
 * Users Bundle
 *---------------------------------------------------------------
 * 
 * Users administration bundle
 */
CCFinder::bundle( 'Earth\\Users', CCFPATH.'earth/bundles/users/' );

// register the admin module
Admin\Registry::add( 'users', function( $module ) 
{
	$module->title = __('Earth\\Users::module.title');
	$module->controller = 'Earth\\Users::Admin';
});


/*
 *---------------------------------------------------------------
 * Prepare all admin modules
 *---------------------------------------------------------------
 * 
 * This step will finally register the routes and build the 
 * navigation tree.
 */
Admin\Registry::prepare();