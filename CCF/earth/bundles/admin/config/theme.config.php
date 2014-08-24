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
        'js'	=> '',
        
        'content_header' => array(),
        'content_topic' => '',
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
		'less/layout.less' 				=> 'theme@style',
		'less/elusive-webfont.less' 		=> 'theme@style',

		// js core
		'jquery.min.js'					=> 'vendor@lib',
		'js/bootstrap.min.js'			=> 'theme@lib',
		'js/application.js'				=> 'theme@app',
		
		// CCF and plugins
		'js/CCF.js'						=> 'theme@lib',
		'js/ui/loading.js'				=> 'theme@lib',
		'js/ui/panel.js'					=> 'theme@lib',
		
		// bootstrap table
		'datatables/js/jquery.dataTables.min.js' => 'vendor@lib',
		'datatables/js/jquery.bootstrap.dataTables.js' => 'vendor@lib',
		//'datatables/css/jquery.dataTables.min.css' => 'vendor@style',
		
		// ajax forms
		'jquery-form/jquery.form.js' => 'vendor@lib',
		
		// jquery ui
		'jquery-ui/jquery-ui.min.js' => 'vendor@lib',
		'jquery-ui/jquery-ui.min.css' => 'vendor@style',
		
		// jquery sortable
		'jquery-sortable/jquery.mjs.nestedSortable.js' => 'vendor@lib',
		
		// jquery elastic 
		'jquery.elastic.js' => 'vendor@lib',
	)
);