<?php
/**
 * CCFTheme default configuration
 */
return array(
    
    'default' => array(
        
        /*
         * the topic gets added to the title
         */
        'topic'     => 'no title',
        
        /*
         * the html title template
         */
        'title'     => '%s | '.ClanCats::runtime( 'name' ),
        
        /*
         * the default html description
         */
        'description'   => 'Change your default description under theme.config -> defatul.description.',
        
        /*
         * sidebar ( if false full container gets used )
         */
        'sidebar'	=> false,
    ), 
    
    /*
     * Assets configuration
     *
     * you can pack files to gether:
     * <holder>@<pack>
     */
	'assets' => array(
		// load bootstrap core
		'css/bootstrap.min.css'		=> 'theme@style',
	
		// add mixins
		'less/mixins/mixins.less'		=> 'theme@style',
		'less/mixins/background.less'	=> 'theme@style',
		'less/mixins/css3.less'			=> 'theme@style',
		'less/mixins/transform.less'		=> 'theme@style',
	
		// Main style
		'less/style.less' 				=> 'theme@style',
	
		// js core
		'jquery.min.js'					=> 'vendor@lib',
		'js/bootstrap.min.js'			=> 'theme@core',
		'js/application.js'				=> 'theme@app',
	)
);