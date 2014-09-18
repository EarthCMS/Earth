<div class="pdn20">
	<h4>Startseite</h4>
	
	<ol class="page-list">
		<li>
			<div class="page-item">
				
				<a href="{{CCUrl::action( 'edit', array( 'r' => $page->id ) )}}" class="panel-ajax-trigger page-item-action">
					<i class="el-icon-edit"></i>
				</a>
				
				<a href="{{to($page->full_url)}}" target="_blank" class="page-item-action" style="margin-top: 1px;margin-right: -2px;">
					<i style="font-size: 16px;" class="el-icon-screen"></i>
				</a>
				
				<span class="page-item-title">{{$page->name}}</span>
				<span class="page-item-type">{{$page->type}} - </span>
				<span class="page-item-url">{{$page->full_url}}</span>
			</div>
		</li>
	</ol>
	
	<h4>Seiten</h4>
	
	<ol id="earth-pages" class="page-list">
		{{CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )}}
	</ol>
</div>
<?php $theme->capture_append( 'js', function() { ?>
<script>
$(document).ready(function()
{
	var pages_container = $('#earth-pages');
	
	pages_container.nestedSortable(
	{
		forcePlaceholderSize: true,
		handle: 'div.page-item',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'page-item-placeholder',
		revert: 250,
		tabSize: 20,
		tolerance: 'pointer',
		toleranceElement: '> div',
		
		isTree: true,
		expandOnHover: 700,
		startCollapsed: true,
		
		branchClass: 'page-item-branch',
		collapsedClass: 'page-item-collapsed',
		disableNestingClass: 'page-item-no-nesting',
		errorClass: 'page-item-error',
		expandedClass: 'page-item-expanded',
		hoveringClass: 'page-item-hovering',
		leafClass: 'page-item-leaf'
	});
	
	/*
	 * Save the pages order and structure
	 */
	$(document).on( 'click', '#pages-save-order-trigger', function( e ) {
		e.preventDefault();
		
		CC.UI.loading( pages_container );
		
		$.ajax( {
			url: '{{CCUrl::action('tree')}}',
			type: "POST",
			data: 
			{
				order: JSON.stringify( pages_container.nestedSortable( 'toArray' ) ),
			},
			success: function( res ) 
			{
				pages_container.html( res );
				
				// disable loading
				CC.UI.loading( pages_container );
			},
		});
	});
	
	/*
	 * Create new pages item
	 */
	$(document).on( 'click', '.create-new-page-item-trigger', function( e ) {
		e.preventDefault();
		
		CC.UI.loading( pages_container );
		
		$.ajax( {
			url: '{{CCUrl::action('create')}}',
			success: function( res ) 
			{
				pages_container.append( res );
				
				// disable loading
				CC.UI.loading( pages_container );
			},
		});
	});
	
	/*
	 * Toggle sub pages
	 */
	$(document).on('click', '.toggle-sub-pages', function( e ) 
	{
		e.preventDefault();
		
		var $this = $(this),
			container = $this.closest( 'li' ),
			subitems = container.find( '> ol' );
			
		// save the collapsed or expanded server on the user
		$.ajax( {
			url: '{{CCUrl::action('save_tree_status')}}',
			data: {
				"r": container.data('page-id'),
				"collapsed": !container.hasClass( 'page-item-collapsed' ),
			},
		});
		
		if ( container.hasClass( 'page-item-collapsed' ) )
		{
			container.removeClass( 'page-item-collapsed' );
			container.addClass( 'page-item-expanded' );
		}
		else
		{
			container.addClass( 'page-item-collapsed' );
			container.removeClass( 'page-item-expanded' );
		}
	});
});
</script>
<?php }); ?>