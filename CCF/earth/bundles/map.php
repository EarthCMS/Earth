<?php
/*
 *---------------------------------------------------------------
 * Admin Index
 *---------------------------------------------------------------
 * 
 * Admin dashboard
 */
Admin\Registry::add( 'index', function( $module ) 
{
	$module->title = 'Dashboard';
	$module->controller = 'Admin::Index';
	$module->icon = "el-icon-dashboard";
});

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
	$module->title = __('Earth\\Users::controller/admin.topic');
	$module->controller = 'Earth\\Users::Admin';
	$module->icon = "el-icon-user";
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